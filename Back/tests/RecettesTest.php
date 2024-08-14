<?php
// tests/RecettesTest.php

namespace App\Tests;

use App\Entity\Recettes;
use App\Entity\User;
use App\Enum\TypeRecette;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RecettesTest extends KernelTestCase
{
    public function testCreateRecette()
    {
        self::bootKernel();
        $entityManager = self::$container->get('doctrine')->getManager();

        // Récupérer l'utilisateur admin
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => 'admin@example.com']);

        $recette = new Recettes();
        $recette->setName('Tarte aux pommes');
        $recette->setTypeRecette(TypeRecette::DESSERT);
        $recette->setInstructions('Couper les pommes, étaler la pâte, cuire au four.');
        $recette->setAddedBy($user);

        $entityManager->persist($recette);
        $entityManager->flush();

        $this->assertNotNull($recette->getId());
        $this->assertEquals('Tarte aux pommes', $recette->getName());
    }
}
