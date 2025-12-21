<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of UserRepositoryTest
 *
 * @author mattl
 */
class UserRepositoryTest extends KernelTestCase {
    
    public function recupRepository(): UserRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(UserRepository::class);
        return $repository;
    }
    
    public function newUser(): User {
        $user = (new User())
                ->setUsername("UserUsernameTest")
                ->setPassword("UserPasswordTest");
        return $user;
    }
    
    public function testUpgradePassword() {
        $repository = $this->recupRepository();
        $user = $this->newUser();
        $newHashedPassword = "NewUserPasswordTest";
        $repository->upgradePassword($user, $newHashedPassword);
        $this->assertNotNull($user);
        $this->assertEquals($newHashedPassword, $user->getPassword(), "erreur lors de l'amélioration du mot de passe");
    }
}
