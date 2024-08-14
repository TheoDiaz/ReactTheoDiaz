<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Recettes;
use App\Enum\UserRole;
use App\Enum\TypeRecette;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(EntityManagerInterface $entityManager): Response
    {
    // Créer un utilisateur de type admin
    $user = new User();
    $user->setName('Admin User');
    $user->setEmail('admin@example.com');
    $user->setRole(UserRole::ADMIN);

    $entityManager->persist($user);
    $entityManager->flush();

    // Créer une recette
    $recette = new Recettes();
    $recette->setName('Tarte aux pommes');
    $recette->setTypeRecette(TypeRecette::DESSERT);
    $recette->setInstructions('Couper les pommes, étaler la pâte, cuire au four.');
    $recette->setAddedBy($user);

    $entityManager->persist($recette);
    $entityManager->flush();

    return new Response('Utilisateur et recette créés avec succès !');
    }
}
