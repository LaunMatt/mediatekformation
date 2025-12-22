<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Classe permettant de créer un utilisateur dans la base de données
 */
class UserFixture extends Fixture
{
    /**
     * @var type
     */
    private $passwordHasher;
    
    /**
     * Constructeur
     * 
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher){
        $this->passwordHasher = $passwordHasher;
    }
    
    /**
     * Méthode permettant le chargement des données de l'utilisateur dans la base de données
     * 
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername("admin");
        $plaintextPassword = "admin";
        $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();
    }
}
