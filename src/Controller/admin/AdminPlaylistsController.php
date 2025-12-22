<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Controller\admin;

use App\Entity\Playlist;
use App\Form\PlaylistType;
use App\Repository\CategorieRepository;
use App\Repository\FormationRepository;
use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Contrôleur des playlists (côté back office)
 */
class AdminPlaylistsController extends AbstractController {
    
    const PAGEGESTIONPLAYLISTS = "admin/admin.playlists.html.twig";
    
    /**
     * @var FormationRepository
     */
    private $playlistRepository;
    
    /**
     * @var CategorieRepository
     */
    private $categorieRepository;
    
    /**
     * @var FormationRepository
     */
    private $formationRepository;
    
    /**
     * Constructeur
     * 
     * @param PlaylistRepository $playlistRepository
     * @param CategorieRepository $categorieRepository
     * @param FormationRepository $formationRespository
     */
    function __construct(PlaylistRepository $playlistRepository, 
            CategorieRepository $categorieRepository,
            FormationRepository $formationRespository) {
        $this->playlistRepository = $playlistRepository;
        $this->categorieRepository = $categorieRepository;
        $this->formationRepository = $formationRespository;
    }
    
    /**
     * Route d'affichage de la page listant les playlists (côté back office)
     * 
     * @return Response
     */
    #[Route('/admin/playlists', name: 'admin.playlists')]
    public function index(): Response{
        $playlists = $this->playlistRepository->findAllOrderByName('ASC');
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEGESTIONPLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }
    
    /**
     * Route permettant la suppresion d'une playlist
     * 
     * @param int $id
     * @return Response
     */
    #[Route('/admin/playlists/suppr/{id}', name: 'admin.playlist.suppr')]
    public function suppr(int $id): Response{
        $playlist = $this->playlistRepository->find($id);
        
        if($playlist->getFormations()->count() > 0){
            return $this->redirectToRoute('admin.playlists');
        }else{
            $this->playlistRepository->remove($playlist);
            return $this->redirectToRoute('admin.playlists');
        }
    }
    
    /**
     * Route permettant l'affichage du formulaire de modification d'une playlist
     * 
     * @param int $id
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/playlists/edit/{id}', name: 'admin.playlist.edit')]
    public function edit(int $id, Request $request): Response{
        $playlist = $this->playlistRepository->find($id);
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        
        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute('admin.playlists');
        }
        
        return $this->render("admin/admin.playlist.edit.html.twig", [
            'playlist' => $playlist,
            'formplaylist' => $formPlaylist->createView()
        ]);
    }
    
    /**
     * Route permettant l'affichage du formulaire d'ajout d'une playlist
     * 
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/playlists/ajout', name: 'admin.playlist.ajout')]
    public function ajout(Request $request): Response{
        $playlist = new Playlist();
        $formPlaylist = $this->createForm(PlaylistType::class, $playlist);
        
        $formPlaylist->handleRequest($request);
        if($formPlaylist->isSubmitted() && $formPlaylist->isValid()){
            $this->playlistRepository->add($playlist);
            return $this->redirectToRoute('admin.playlists');
        }
        
        return $this->render("admin/admin.playlist.ajout.html.twig", [
            'playlist' => $playlist,
            'formplaylist' => $formPlaylist->createView()
        ]);
    }

    /**
     * Route permettant l'affichage de la liste des playlists selon un tri effectué (côté back office)
     * 
     * @param type $champ
     * @param type $ordre
     * @return Response
     */
    #[Route('/admin.playlists/tri/{champ}/{ordre}', name: 'admin.playlists.sort')]
    public function sort($champ, $ordre): Response{
        switch($champ){
            case "name":
                $playlists = $this->playlistRepository->findAllOrderByName($ordre);
                break;
            case "nb_formations":
                $playlists = $this->playlistRepository->findAllOrderByNbFormations($ordre);
                break;
            default:
                return $this->redirectToRoute('admin.playlists');
        }
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEGESTIONPLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories            
        ]);
    }          

    /**
     * Route permettant l'affichage de la liste des playlists selon un filtre effectué (côté back office)
     * 
     * @param type $champ
     * @param Request $request
     * @param type $table
     * @return Response
     */
    #[Route('/admin.playlists/recherche/{champ}/{table}', name: 'admin.playlists.findallcontain')]
    public function findAllContain($champ, Request $request, $table=""): Response{
        $valeur = $request->get("recherche");
        $playlists = $this->playlistRepository->findByContainValue($champ, $valeur, $table);
        $categories = $this->categorieRepository->findAll();
        return $this->render(self::PAGEGESTIONPLAYLISTS, [
            'playlists' => $playlists,
            'categories' => $categories,            
            'valeur' => $valeur,
            'table' => $table
        ]);
    }
}
