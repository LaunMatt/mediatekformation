<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of FormationsControllerTest
 *
 * @author mattl
 */
class FormationsControllerTest extends WebTestCase {
    
    const FILTRETRIFORMATION = 'tbody tr h5.formation-titre';
    const FILTREFILTREFORMATION = 'h5.formation-titre';
    
    public function testTriFormationTitreAsc(){
        
        $client = static::createClient();
        $client->request('GET','/formations/tri/title/ASC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIFORMATION)
                ->first()
                ->text();
        $this->assertEquals('Android Studio (complément n°1) : Navigation Drawer et Fragment', trim($titre));
    }
    
    public function testTriFormationTitreDesc(){
        
        $client = static::createClient();
        $client->request('GET','/formations/tri/title/DESC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIFORMATION)
                ->first()
                ->text();
        $this->assertEquals('UML : Diagramme de paquetages', trim($titre));
    }
    
    public function testTriFormationPlaylistAsc(){
        
        $client = static::createClient();
        $client->request('GET','/formations/tri/name/ASC/playlist');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIFORMATION)
                ->first()
                ->text();
        $this->assertEquals('Bases de la programmation n°74 - POO : collections', trim($titre));
    }
    
    public function testTriFormationPlaylistDesc(){
        
        $client = static::createClient();
        $client->request('GET','/formations/tri/name/DESC/playlist');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIFORMATION)
                ->first()
                ->text();
        $this->assertEquals('C# : ListBox en couleur', trim($titre));
    }
    
    public function testTriFormationDateAsc(){
        
        $client = static::createClient();
        $client->request('GET','/formations/tri/publishedAt/ASC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIFORMATION)
                ->first()
                ->text();
        $this->assertEquals("Cours UML (1 à 7 / 33) : introduction et cas d'utilisation", trim($titre));
    }
    
    public function testTriFormationDateDesc(){
        
        $client = static::createClient();
        $client->request('GET','/formations/tri/publishedAt/DESC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIFORMATION)
                ->first()
                ->text();
        $this->assertEquals('Eclipse n°8 : Déploiement', trim($titre));
    }
    
    public function testFiltreTitre(){
        $client = static::createClient();
        $client->request('GET','/formations/recherche/title');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(19, $crawler->filter(self::FILTREFILTREFORMATION));
        $this->assertSelectorTextSame(self::FILTREFILTREFORMATION, 'Python n°18 : Décorateur singleton');
    }
    
    public function testFiltrePlaylist(){
        $client = static::createClient();
        $client->request('GET','/formations/recherche/name/playlist');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(19, $crawler->filter(self::FILTREFILTREFORMATION));
        $this->assertSelectorTextSame(self::FILTREFILTREFORMATION, 'Python n°18 : Décorateur singleton');
    }
    
    public function testFiltreCategorie(){
        $client = static::createClient();
        $client->request('GET','/formations/recherche/id/categories');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(19, $crawler->filter(self::FILTREFILTREFORMATION));
        $this->assertSelectorTextContains(self::FILTREFILTREFORMATION, 'Python n°18 : Décorateur singleton');
    }
    
    public function testLinkFormation(){
        $client = static::createClient();
        $client->request('GET', '/formations' );
        $client->clickLink('Eclipse n°8 : Déploiement');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/formations/formation/1', $uri);
        $this->assertSelectorTextContains('h4.formation-titre', 'Eclipse n°8 : Déploiement');
    }
}
