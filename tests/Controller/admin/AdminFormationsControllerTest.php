<?php

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AdminFormationsControllerTest
 *
 * @author mattl
 */
class AdminFormationsControllerTest extends WebTestCase {
    
    const FILTRETRIADMINFORMATION = 'tbody tr h5.formation-titre';
    const FILTREFILTREADMINFORMATION = 'h5.formation-titre';
    
    private function creationClientAuthentifie(){
        
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy([
            'username' => 'admin'
        ]);
        $client->loginUser($admin);
        return $client;
    }
    
    public function testTriFormationTitreAsc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.formations/tri/title/ASC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINFORMATION)
                ->first()
                ->text();
        $this->assertEquals('Android Studio (complément n°1) : Navigation Drawer et Fragment', trim($titre));
    }
    
    public function testTriFormationTitreDesc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.formations/tri/title/DESC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINFORMATION)
                ->first()
                ->text();
        $this->assertEquals('UML : Diagramme de paquetages', trim($titre));
    }
    
    public function testTriFormationPlaylistAsc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.formations/tri/name/ASC/playlist');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINFORMATION)
                ->first()
                ->text();
        $this->assertEquals('Bases de la programmation n°74 - POO : collections', trim($titre));
    }
    
    public function testTriFormationPlaylistDesc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.formations/tri/name/DESC/playlist');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINFORMATION)
                ->first()
                ->text();
        $this->assertEquals('C# : ListBox en couleur', trim($titre));
    }
    
    public function testTriFormationDateAsc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.formations/tri/publishedAt/ASC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINFORMATION)
                ->first()
                ->text();
        $this->assertEquals("Cours UML (1 à 7 / 33) : introduction et cas d'utilisation", trim($titre));
    }
    
    public function testTriFormationDateDesc(){
        
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.formations/tri/publishedAt/DESC');
        $this->assertResponseIsSuccessful();
        $crawler = $client->getCrawler();
        $titre = $crawler
                ->filter(self::FILTRETRIADMINFORMATION)
                ->first()
                ->text();
        $this->assertEquals('Eclipse n°8 : Déploiement', trim($titre));
    }
    
    public function testFiltreTitre(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.formations/recherche/title');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(19, $crawler->filter(self::FILTREFILTREADMINFORMATION));
        $this->assertSelectorTextSame(self::FILTREFILTREADMINFORMATION, 'Python n°18 : Décorateur singleton');
    }
    
    public function testFiltrePlaylist(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.formations/recherche/name/playlist');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(19, $crawler->filter(self::FILTREFILTREADMINFORMATION));
        $this->assertSelectorTextSame(self::FILTREFILTREADMINFORMATION, 'Python n°18 : Décorateur singleton');
    }
    
    public function testFiltreCategorie(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET','/admin.formations/recherche/id/categories');
        $crawler = $client->submitForm('filtrer', [
        'recherche' => 'Python'
        ]);
        $this->assertCount(19, $crawler->filter(self::FILTREFILTREADMINFORMATION));
        $this->assertSelectorTextContains(self::FILTREFILTREADMINFORMATION, 'Python n°18 : Décorateur singleton');
    }
    
    public function testLinkAjoutFormation(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET', '/admin' );
        $client->clickLink('Ajouter une nouvelle formation');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/admin/ajout', $uri);
        $this->assertSelectorTextContains('h2', 'Nouvelle formation :');
    }
    
    public function testLinkEditFormation(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET', '/admin' );
        $client->clickLink('Modifier');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/admin/edit/1', $uri);
        $this->assertSelectorTextContains('h2', 'Détail formation :');
    }
    
    public function testLinkSupprFormation(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET', '/admin' );
        $client->clickLink('Supprimer');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/admin/suppr/1', $uri);
        $client->followRedirect();
        $this->assertSelectorTextContains(self::FILTREFILTREADMINFORMATION, 'Eclipse n°7 : Tests unitaires');
    }
}
