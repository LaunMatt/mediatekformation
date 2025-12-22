<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Contrôleur de l'authentification
 */
class LoginController extends AbstractController
{
    /**
     * Route d'affichage de la page permettant l'authentification
     * 
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // récupération éventuelle de l'erreur
        $error = $authenticationUtils->getLastAuthenticationError();
        //récupération éventuelle du dernier nom de login utilisé
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }
    
    /**
     * Route permettant la déconnexion
     */
    #[Route('/logout', name: 'logout')]
    public function logout(){
        
    }
}
