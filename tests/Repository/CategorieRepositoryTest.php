<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of CategorieRepositoryTest
 *
 * @author mattl
 */
class CategorieRepositoryTest extends KernelTestCase {
    
    public function recupRepository(): CategorieRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(CategorieRepository::class);
        return $repository;
    }
    
    public function newCategorie(): Categorie {
        $categorie = (new Categorie())
                ->setName("Catégorie programmation");
        return $categorie;
    }
    
    public function testAddCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $nbCategories = $repository->count([]);
        $repository->add($categorie, true);
        $this->assertEquals($nbCategories + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemoveCategorie(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $nbCategories = $repository->count([]);
        $repository->remove($categorie, true);
        $this->assertEquals($nbCategories - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $categorie = $repository->findAll()[0];
        $formation = $categorie->getFormations()[0];
        $playlistId = $formation->getPlaylist()->getId();
        $categories = $repository->findAllForOnePlaylist($playlistId);
        $this->assertNotEmpty($categories);
        foreach($categories as $categorie){
            $formationTrouvee = false;
            foreach($categorie->getFormations() as $formation){
                if($formation->getPlaylist()->getId() === $playlistId){
                    $formationTrouvee = true;
                    break;
                }
            }
            $this->assertTrue($formationTrouvee, "catégorie non liée à une formation de la playlist");
        }
    }
    
    public function testFindOneByName(){
        $repository = $this->recupRepository();
        $categorie = $this->newCategorie();
        $repository->add($categorie, true);
        $categories = $repository->findOneByName("Catégorie programmation");
        $this->assertNotNull($categories);
        $this->assertStringContainsString("Catégorie programmation", $categorie->getName(), "nom de catégorie non trouvé");
    }
}
