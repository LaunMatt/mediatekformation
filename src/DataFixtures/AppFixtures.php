<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Classe permettant de créer des données dans la base de données
 */
class AppFixtures extends Fixture
{
    /**
     * Méthode permettant le chargement des données dans la base de données
     * 
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
