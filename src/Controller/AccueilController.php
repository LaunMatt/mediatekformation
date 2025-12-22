<?php
namespace App\Controller;

use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur de la page d'accueil
 *
 * @author emds
 */
class AccueilController extends AbstractController{
    
    /**
     * @var FormationRepository
     */
    private $repository;
    
    /**
     * Constructeur
     * 
     * @param FormationRepository $repository
     */
    public function __construct(FormationRepository $repository) {
        $this->repository = $repository;
    }   
    
    /**
     * Route d'affichage de la page d'accueil
     * 
     * @return Response
     */
    #[Route('/', name: 'accueil')]
    public function index(): Response{
        $formations = $this->repository->findAllLasted(2);
        return $this->render("pages/accueil.html.twig", [
            'formations' => $formations
        ]); 
    }
    
    /**
     * Route d'affichage de la page des conditions générales d'utilisation
     * 
     * @return Response
     */
    #[Route('/cgu', name: 'cgu')]
    public function cgu(): Response{
        return $this->render("pages/cgu.html.twig"); 
    }
}
