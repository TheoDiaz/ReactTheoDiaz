<?php

namespace App\Tests;

use App\Entity\User;
use App\Enum\UserRole;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function testCreateAdminUser()
    {
        self::bootKernel();
        $entityManager = self::$container->get('doctrine')->getManager();

        $user = new User();
        $user->setName('Admin User');
        $user->setEmail('admin@example.com');
        $user->setRole(UserRole::ADMIN);

        $entityManager->persist($user);
        $entityManager->flush();

        $this->assertNotNull($user->getId());
        $this->assertEquals(UserRole::ADMIN, $user->getRole());
    }
}
