<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistsControllerTest
 *
 * @author mattl
 */
class PlaylistsControllerTest extends WebTestCase {
    
    const FILTRETRIPLAYLIST = 'tbody tr h5.playlist-nom';
    const FILTREFILTREPLAYLIST = 'h5.playlist-nom';
    
    public function testTriPlaylistNomAsc(){
        
        $client = static::createClient();
        $client->request('GET','/playlists/tri/name/ASC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIPLAYLIST)
                ->first()
                ->text();
        $this->assertEquals('Bases de la programmation (C#)', trim($titre));
    }
    
    public function testTriPlaylistNomDesc(){
        
        $client = static::createClient();
        $client->request('GET','/playlists/tri/name/DESC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIPLAYLIST)
                ->first()
                ->text();
        $this->assertEquals('Visual Studio 2019 et C#', trim($titre));
    }
    
    public function testTriNombreFormationsPlaylistAsc(){
        
        $client = static::createClient();
        $client->request('GET','/playlists/tri/nb_formations/ASC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIPLAYLIST)
                ->first()
                ->text();
        $this->assertEquals('playlist test', trim($titre));
    }
    
    public function testTriNombreFormationsPlaylistDesc(){
        
        $client = static::createClient();
        $client->request('GET','/playlists/tri/nb_formations/DESC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIPLAYLIST)
                ->first()
                ->text();
        $this->assertEquals('Bases de la programmation (C#)', trim($titre));
    }
    
    public function testFiltreNom(){
        $client = static::createClient();
        $client->request('GET','/playlists/recherche/name');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(1, $crawler->filter(self::FILTREFILTREPLAYLIST));
        $this->assertSelectorTextSame(self::FILTREFILTREPLAYLIST, 'Programmation sous Python');
    }
    
    public function testFiltreCategorie(){
        $client = static::createClient();
        $client->request('GET','/playlists/recherche/id/categories');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(1, $crawler->filter(self::FILTREFILTREPLAYLIST));
        $this->assertSelectorTextSame(self::FILTREFILTREPLAYLIST, 'Programmation sous Python');
    }
    
    public function testLinkPlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists' );
        $client->clickLink('Voir détail');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/playlists/playlist/13', $uri);
        $this->assertSelectorTextContains('h4.playlist-nom', 'Bases de la programmation (C#)');
    }
}
