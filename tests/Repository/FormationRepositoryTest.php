<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Formation;
use App\Repository\FormationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of FormationRepositoryTest
 *
 * @author mattl
 */
class FormationRepositoryTest extends KernelTestCase {
    
    public function recupRepository(): FormationRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(FormationRepository::class);
        return $repository;
    }
    
    public function newFormation(): Formation {
        $formation = (new Formation())
                ->setTitle("Formation programmation")
                ->setPublishedAt(new DateTime("now"));
        return $formation;
    }
    
    public function testAddFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $nbFormations = $repository->count([]);
        $repository->add($formation, true);
        $this->assertEquals($nbFormations + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemoveFormation(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $nbFormations = $repository->count([]);
        $repository->remove($formation, true);
        $this->assertEquals($nbFormations - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindAllOrderByAsc(){
        $repository = $this->recupRepository();
        $formations = $repository->findAllOrderBy("title", "ASC");
        $nbFormations = count($formations);
        $this->assertEquals(237, $nbFormations);
        $this->assertEquals(strcmp($formations[0]->getTitle(), $formations[1]->getTitle()) <= 0, "erreur lors du tri croissant des formations par titre");
    }
    
    public function testFindAllOrderByDesc(){
        $repository = $this->recupRepository();
        $formations = $repository->findAllOrderBy("title", "DESC");
        $nbFormations = count($formations);
        $this->assertEquals(237, $nbFormations);
        $this->assertTrue(strcmp($formations[0]->getTitle(), $formations[1]->getTitle()) >= 0, "erreur lors du tri décroissant des formations par titre");
    }
    
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $formation = $this->newFormation();
        $repository->add($formation, true);
        $formations = $repository->findByContainValue("title", "Formation programmation");
        $this->assertNotEmpty($formations);
        foreach($formations as $formation){
            $this->assertStringContainsString("Formation programmation", $formation->getTitle(), "titre de formation non trouvé");
        }
    }
    
    public function testFindByContainValueEmpty(){
        $repository = $this->recupRepository();
        $nbFormations = $repository->count([]);
        $formations = $repository->findByContainValue("title", "");
        $this->assertEquals($nbFormations, count($formations), "nombre total de formations incorrect");
    }
    
    public function testFindAllLasted(){
        $repository = $this->recupRepository();
        $formations = $repository->findAllLasted(10);
        $this->assertCount(10, $formations);
        $this->assertTrue($formations[0]->getPublishedAt() >= $formations[1]->getPublishedAt(), "erreur lors du tri décroissant des formations par date");
    }
    
    public function testFindAllForOnePlaylist(){
        $repository = $this->recupRepository();
        $formation = $repository->findAll()[0];
        $playlistId = $formation->getPlaylist()->getId();
        $formations = $repository->findAllForOnePlaylist($playlistId);
        $this->assertNotEmpty($formations);
        foreach($formations as $formation){
            $this->assertEquals($playlistId, $formation->getPlaylist()->getId(), "formation non liée à la playlist");
        }
    }
}
