<?php

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AdminPlaylistsControllerTest
 *
 * @author mattl
 */
class AdminPlaylistsControllerTest extends WebTestCase {
    
    const FILTRETRIADMINPLAYLIST = 'tbody tr h5.playlist-nom';
    const FILTREFILTREADMINPLAYLIST = 'h5.playlist-nom';
    
    private function creationClientAuthentifie(){
        
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy([
            'username' => 'admin'
        ]);
        $client->loginUser($admin);
        return $client;
    }
    
    public function testTriPlaylistNomAsc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.playlists/tri/name/ASC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINPLAYLIST)
                ->first()
                ->text();
        $this->assertEquals('Bases de la programmation (C#)', trim($titre));
    }
    
    public function testTriPlaylistNomDesc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.playlists/tri/name/DESC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINPLAYLIST)
                ->first()
                ->text();
        $this->assertEquals('Visual Studio 2019 et C#', trim($titre));
    }
    
    public function testTriNombreFormationsPlaylistAsc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.playlists/tri/nb_formations/ASC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINPLAYLIST)
                ->first()
                ->text();
        $this->assertEquals('playlist test', trim($titre));
    }
    
    public function testTriNombreFormationsPlaylistDesc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.playlists/tri/nb_formations/DESC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINPLAYLIST)
                ->first()
                ->text();
        $this->assertEquals('Bases de la programmation (C#)', trim($titre));
    }
    
    public function testFiltreNom(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.playlists/recherche/name');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(1, $crawler->filter(self::FILTREFILTREADMINPLAYLIST));
        $this->assertSelectorTextSame(self::FILTREFILTREADMINPLAYLIST, 'Programmation sous Python');
    }
    
    public function testFiltreCategorie(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.playlists/recherche/id/categories');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(1, $crawler->filter(self::FILTREFILTREADMINPLAYLIST));
        $this->assertSelectorTextSame(self::FILTREFILTREADMINPLAYLIST, 'Programmation sous Python');
    }
    
    public function testLinkAjoutPlaylist(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET', '/admin/playlists' );
        $client->clickLink('Ajouter une nouvelle playlist');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/admin/playlists/ajout', $uri);
        $this->assertSelectorTextContains('h2', 'Nouvelle playlist :');
    }
    
    public function testLinkEditPlaylist(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET', '/admin/playlists' );
        $client->clickLink('Modifier');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/admin/playlists/edit/13', $uri);
        $this->assertSelectorTextContains('h2', 'Détail playlist :');
    }
    
    public function testLinkSupprPlaylist(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET', '/admin/playlists' );
        $client->clickLink('Supprimer');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/admin/playlists/suppr/28', $uri);
        $client->followRedirect();
        $this->assertSelectorTextContains(self::FILTREFILTREADMINPLAYLIST, 'Bases de la programmation (C#)');
    }
}
