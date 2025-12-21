<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of PlaylistControllerTest
 *
 * @author mattl
 */
class PlaylistControllerTest extends WebTestCase {
    
    public function testLinkFormationPlaylist(){
        $client = static::createClient();
        $client->request('GET', '/playlists/playlist/13' );
        $client->clickLink('Bases de la programmation n°1 - procédural : premier exemple');
        $response = $client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $uri = $client->getRequest()->server->get("REQUEST_URI");
        $this->assertEquals('/formations/formation/196', $uri);
        $this->assertSelectorTextContains('h4.formation-titre', 'Bases de la programmation n°1 - procédural : premier exemple');
    }
}
