<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur des catégories (côté back office)
 */
class AdminCategorieController extends AbstractController {
    
    /**
     * @var categorieRepository
     */
    private $categorieRepository;
    
    const PAGEGESTIONCATEGORIES = "admin/admin.categories.html.twig";
    
    /**
     * Constructeur
     * 
     * @param CategorieRepository $categorieRepository
     */
    public function __construct(CategorieRepository $categorieRepository) {
        $this->categorieRepository = $categorieRepository;
    }
    
    /**
     * Route d'affichage de la page listant les catégories (côté back office)
     * 
     * @return Response
     */
    #[Route('/admin/categories', name: 'admin.categories')]
    public function index(): Response{
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEGESTIONCATEGORIES, [
            'categories' => $categories
        ]);
    }
    
    /**
     * Route permettant la suppresion d'une catégorie
     * 
     * @param int $id
     * @return Response
     */
    #[Route('/admin/categorie/suppr/{id}', name: 'admin.categorie.suppr')]
    public function suppr(int $id): Response{
        $categorie = $this->categorieRepository->find($id);
        
        if($categorie->getFormations()->count() > 0){
            return $this->redirectToRoute('admin.categories');
        }else{
            $this->categorieRepository->remove($categorie);
            return $this->redirectToRoute('admin.categories');
        }
    }
    
    /**
     * Route permettant l'ajout d'une catégorie
     * 
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/categorie/ajout', name: 'admin.categorie.ajout')]
        public function ajout (Request $request) : Response{
        $nomCategorie = $request->get("nom");
        
        if(empty($nomCategorie)){
            $this->addFlash('danger', 'Veuillez saisir le nom de la nouvelle catégorie.');
            return $this->redirectToRoute('admin.categories');
        }
        
        $nomExistant = $this->categorieRepository->findOneByName($nomCategorie);
        if($nomExistant !== null){
            $this->addFlash('danger', sprintf('La catégorie '.$nomCategorie.' existe déjà.'));
            return $this->redirectToRoute('admin.categories');
        }
        
        $categorie = new Categorie();
        $categorie->setName($nomCategorie);
        $this->categorieRepository->add($categorie);
        return $this->redirectToRoute('admin.categories');
    }
}
