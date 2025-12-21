<?php

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of AdminCategorieControllerTest
 *
 * @author mattl
 */
class AdminCategorieControllerTest extends WebTestCase {
    
    private function creationClientAuthentifie(){
        
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $admin = $userRepository->findOneBy([
            'username' => 'admin'
        ]);
        $client->loginUser($admin);
        return $client;
    }
    
    public function testLinkSupprCategorie(){
        $client = $this->creationClientAuthentifie();
        $client->request('GET', '/admin/categories' );
        $client->clickLink('Supprimer');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_FOUND, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/admin/categorie/suppr/22', $uri);
        $client->followRedirect();
        $this->assertSelectorTextContains('td.categorie-nom', 'Java');
    }
}
