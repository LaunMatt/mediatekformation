<?php

namespace App\Repository;

use App\Entity\Playlist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Repository de l'entité Playlist
 * 
 * @extends ServiceEntityRepository<Playlist>
 */
class PlaylistRepository extends ServiceEntityRepository
{
    /**
     * Constructeur
     * 
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playlist::class);
    }

    /**
     * Méthode permettant d'ajouter une playlist à la base de données
     * 
     * @param Playlist $entity
     * @return void
     */
    public function add(Playlist $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * Méthode permettant de supprimer une playlist de la base de données
     * 
     * @param Playlist $entity
     * @return void
     */
    public function remove(Playlist $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
    
    /**
     * Méthode retournant toutes les playlists triées sur le nom de la playlist
     * 
     * @param type $ordre
     * @return Playlist[]
     */
    public function findAllOrderByName($ordre): array{
        return $this->createQueryBuilder('p')
                ->leftjoin('p.formations', 'f')
                ->groupBy('p.id')
                ->orderBy('p.name', $ordre)
                ->getQuery()
                ->getResult();       
    }
    
    /**
     * Méthode retournant toutes les playlists triées sur le nombre de formations de la playlist
     * 
     * @param type $ordre
     * @return Playlist[]
     */
    public function findAllOrderByNbFormations($ordre): array{
        return $this->createQueryBuilder('p')
                ->leftjoin('p.formations', 'f')
                ->addSelect('count(f.id) as hidden nbFormations')
                ->groupBy('p.id')
                ->orderBy('nbFormations', $ordre)
                ->getQuery()
                ->getResult();       
    }
	
    /**
     * Méthode retournant les enregistrements dont un champ contient une valeur
     * ou tous les enregistrements si la valeur est vide
     * 
     * @param type $champ
     * @param type $valeur
     * @param type $table si $champ dans une autre table
     * @return Playlist[]
     */
    public function findByContainValue($champ, $valeur, $table=""): array{
        if($valeur==""){
            return $this->findAllOrderByName('ASC');
        }    
        if($table==""){      
            return $this->createQueryBuilder('p')
                    ->leftjoin('p.formations', 'f')
                    ->where('p.'.$champ.' LIKE :valeur')
                    ->setParameter('valeur', '%'.$valeur.'%')
                    ->groupBy('p.id')
                    ->orderBy('p.name', 'ASC')
                    ->getQuery()
                    ->getResult();              
        }else{   
            return $this->createQueryBuilder('p')
                    ->leftjoin('p.formations', 'f')
                    ->leftjoin('f.categories', 'c')
                    ->where('c.'.$champ.' LIKE :valeur')
                    ->setParameter('valeur', '%'.$valeur.'%')
                    ->groupBy('p.id')
                    ->orderBy('p.name', 'ASC')
                    ->getQuery()
                    ->getResult();              
        }           
    }    
}
