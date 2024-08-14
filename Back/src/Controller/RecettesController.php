<?php

namespace App\Controller;

use App\Entity\Recettes;
use App\Entity\User;
use App\Entity\Ingredients;
use App\Entity\RecetteIngredient;
use App\Enum\TypeRecette;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RecettesController extends AbstractController
{
    #[Route('/api/recettes', name: 'get_recettes', methods: ['GET'])]
    public function getRecettes(EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $recettes = $entityManager->getRepository(Recettes::class)->findAll();
        $jsonData = $serializer->serialize($recettes, 'json');

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    #[Route('/api/recettes/{id}', name: 'get_recette', methods: ['GET'])]
    public function getRecette(int $id, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $recette = $entityManager->getRepository(Recettes::class)->find($id);

        if (!$recette) {
            throw new NotFoundHttpException('Recette non trouvée');
        }

        $jsonData = $serializer->serialize($recette, 'json');
        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    #[Route('/api/recettes', name: 'create_recette', methods: ['POST'])]
    public function createRecette(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);


        $constraints = new Assert\Collection([
            'name' => [new Assert\NotBlank(), new Assert\Type('string')],
            'typeRecette' => [new Assert\NotBlank(), new Assert\Type('string')],
            'instructions' => [new Assert\NotBlank(), new Assert\Type('string')],
            'addedBy' => [new Assert\NotBlank(), new Assert\Type('integer')],
            'ingredients' => new Assert\Optional([
                new Assert\Type('array'),
                new Assert\All([
                    new Assert\Collection([
                        'name' => [new Assert\NotBlank(), new Assert\Type('string')],
                        'quantity' => [new Assert\NotBlank(), new Assert\Type('numeric')],
                        'unit' => [new Assert\NotBlank(), new Assert\Type('string')],
                    ])
                ])
            ])
        ]);

        $errors = $validator->validate($data, $constraints);

        if (count($errors) > 0) {
            return $this->json(['message' => 'Données invalides', 'errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        // Vérification de l'utilisateur
        $user = $entityManager->getRepository(User::class)->find($data['addedBy']);
        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Création de la recette
        try {
            $recette = new Recettes();
            $recette->setName($data['name']);
            $recette->setTypeRecette(TypeRecette::from($data['typeRecette']));
            $recette->setInstructions($data['instructions']);
            $recette->setAddedBy($user);

            // Ajout des ingrédients
            if (isset($data['ingredients'])) {
                foreach ($data['ingredients'] as $ingredientData) {
                    $ingredient = $entityManager->getRepository(Ingredients::class)->findOneBy(['name' => $ingredientData['name']]);
                    if (!$ingredient) {
                        $ingredient = new Ingredients();
                        $ingredient->setName($ingredientData['name']);
                        $ingredient->setUnit($ingredientData['unit']);
                        $entityManager->persist($ingredient);
                    }

                    $recetteIngredient = new RecetteIngredient();
                    $recetteIngredient->setRecette($recette);
                    $recetteIngredient->setIngredient($ingredient);
                    $recetteIngredient->setQuantity($ingredientData['quantity']);
                    $entityManager->persist($recetteIngredient);
                }
            }

            $entityManager->persist($recette);
            $entityManager->flush();

            $jsonData = $serializer->serialize($recette, 'json', ['groups' => 'recette']);

            return new JsonResponse($jsonData, Response::HTTP_CREATED, [], true);
        } catch (\ValueError $e) {
            return $this->json(['message' => 'Valeur du type de recette invalide'], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/recettes/{id}', name: 'update_recette', methods: ['PUT'])]
    public function updateRecette(int $id, Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $recette = $entityManager->getRepository(Recettes::class)->find($id);
        if (!$recette) {
            return $this->json(['message' => 'Recette non trouvée'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        if (isset($data['name'])) $recette->setName($data['name']);
        if (isset($data['typeRecette'])) {
            try {
                $recette->setTypeRecette(TypeRecette::from($data['typeRecette']));
            } catch (\ValueError $e) {
                return $this->json(['message' => 'Valeur du type de recette invalide'], Response::HTTP_BAD_REQUEST);
            }
        }
        if (isset($data['instructions'])) $recette->setInstructions($data['instructions']);

        $entityManager->flush();

        $jsonData = $serializer->serialize($recette, 'json');

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }

    #[Route('/api/recettes/{id}', name: 'delete_recette', methods: ['DELETE'])]
    public function deleteRecette(int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $recette = $entityManager->getRepository(Recettes::class)->find($id);
        if (!$recette) {
            return $this->json(['message' => 'Recette non trouvée'], Response::HTTP_NOT_FOUND);
        }

        $entityManager->remove($recette);
        $entityManager->flush();

        return $this->json(['message' => 'Recette supprimée'], Response::HTTP_OK);
    }

    #[Route('/api/types-recettes', name: 'get_types_recettes', methods: ['GET'])]
    public function getTypesRecettes(): JsonResponse
    {
        $typesRecettes = [
            'ENTREE' => TypeRecette::ENTREE->value,
            'PLAT' => TypeRecette::PLAT->value,
            'DESSERT' => TypeRecette::DESSERT->value,
            'APERITIF' => TypeRecette::APERITIF->value,
        ];

        return new JsonResponse($typesRecettes, Response::HTTP_OK);
    }

    #[Route('/api/ingredients/search', name: 'search_ingredients', methods: ['GET'])]
    public function searchIngredients(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $query = $request->query->get('q');
        if (!$query) {
            return $this->json(['message' => 'Paramètre de recherche manquant'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $ingredients = $entityManager->getRepository(Ingredients::class)
                ->createQueryBuilder('i')
                ->where('LOWER(i.name) LIKE LOWER(:query)')
                ->setParameter('query', $query . '%')
                ->getQuery()
                ->getResult();

            $jsonData = $serializer->serialize($ingredients, 'json', ['groups' => 'ingredient']);

            return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
        } catch (\Exception $e) {
            $this->logger->error('Erreur lors de la recherche d\'ingrédients: ' . $e->getMessage());
            return $this->json(['message' => 'Une erreur est survenue lors de la recherche d\'ingrédients'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}