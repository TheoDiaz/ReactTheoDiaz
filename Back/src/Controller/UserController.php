<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\UserRole;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/users/register', name: 'register_user', methods: ['POST'])]
    public function registerUser(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérifiez si les données sont présentes
        if (!isset($data['name'], $data['email'], $data['password'])) {
            return new JsonResponse(['message' => 'Données invalides'], 400);
        }

        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if ($existingUser) {
            return new JsonResponse(['message' => 'Email déjà utilisé'], 400);
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setRole(UserRole::USER); // Rôle par défaut lors de l'inscription

        // Encodez le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $data['password']
        );
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $user->setPassword(null); // Ne pas inclure le mot de passe dans la réponse
        $jsonData = $serializer->serialize($user, 'json');

        return new JsonResponse($jsonData, 201, [], true);
    }

    #[Route('/api/users/login', name: 'login_user', methods: ['POST'])]
    public function loginUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'])) {
            return new JsonResponse(['message' => 'Données invalides'], 400);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if (!$user || !$this->passwordHasher->isPasswordValid($user, $data['password'])) {
            return new JsonResponse(['message' => 'Identifiants incorrects'], 401);
        }

        // Inclure l'ID de l'utilisateur dans la réponse
        return new JsonResponse([
            'message' => 'Connexion réussie',
            'userId' => $user->getId(),
            'userName' => $user->getName(), // Optionnel : inclure le nom de l'utilisateur si nécessaire
            // Vous pouvez ajouter d'autres informations utiles ici, mais évitez les données sensibles
        ], 200);
    }
}
