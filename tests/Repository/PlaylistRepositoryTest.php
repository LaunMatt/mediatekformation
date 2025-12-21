<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Playlist;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of PlaylistRepositoryTest
 *
 * @author mattl
 */
class PlaylistRepositoryTest extends KernelTestCase {
    
    public function recupRepository(): PlaylistRepository{
        self::bootKernel();
        $repository = self::getContainer()->get(PlaylistRepository::class);
        return $repository;
    }
    
    public function newPlaylist(): Playlist {
        $playlist = (new Playlist())
                ->setName("Playlist programmation");
        return $playlist;
    }
    
    public function testAddPlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $nbPlaylists = $repository->count([]);
        $repository->add($playlist, true);
        $this->assertEquals($nbPlaylists + 1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemovePlaylist(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $nbPlaylists = $repository->count([]);
        $repository->remove($playlist, true);
        $this->assertEquals($nbPlaylists - 1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindAllOrderByNameAsc(){
        $repository = $this->recupRepository();
        $playlists = $repository->findAllOrderByName("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(28, $nbPlaylists);
        $this->assertEquals(strcmp($playlists[0]->getName(), $playlists[1]->getName()) <= 0, "erreur lors du tri croissant des playlists par nom");
    }
    
    public function testFindAllOrderByNameDesc(){
        $repository = $this->recupRepository();
        $playlists = $repository->findAllOrderByName("DESC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(28, $nbPlaylists);
        $this->assertEquals(strcmp($playlists[0]->getName(), $playlists[1]->getName()) >= 0, "erreur lors du tri décroissant des playlists par nom");
    }
    
    public function testFindAllOrderByNbFormationsAsc(){
        $repository = $this->recupRepository();
        $playlists = $repository->findAllOrderByNbFormations("ASC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(28, $nbPlaylists);
        $this->assertEquals(strcmp($playlists[0]->getFormations()->count(), $playlists[1]->getFormations()->count()) <= 0, "erreur lors du tri croissant des playlists par nombre de formations");
    }
    
    public function testFindAllOrderByNbFormationsDesc(){
        $repository = $this->recupRepository();
        $playlists = $repository->findAllOrderByNbFormations("DESC");
        $nbPlaylists = count($playlists);
        $this->assertEquals(28, $nbPlaylists);
        $this->assertEquals(strcmp($playlists[0]->getFormations()->count(), $playlists[1]->getFormations()->count()) >= 0, "erreur lors du tri décroissant des playlists par nombre de formations");
    }
    
    public function testFindByContainValue(){
        $repository = $this->recupRepository();
        $playlist = $this->newPlaylist();
        $repository->add($playlist, true);
        $playlists = $repository->findByContainValue("name", "Playlist programmation");
        $this->assertNotEmpty($playlists);
        foreach($playlists as $playlist){
            $this->assertStringContainsString("Playlist programmation", $playlist->getName(), "nom de playlist non trouvé");
        }
    }
    
    public function testFindByContainValueEmpty(){
        $repository = $this->recupRepository();
        $nbPlaylists = $repository->count([]);
        $playlists = $repository->findByContainValue("name", "");
        $this->assertEquals($nbPlaylists, count($playlists), "nombre total de playlists incorrect");
    }
}
