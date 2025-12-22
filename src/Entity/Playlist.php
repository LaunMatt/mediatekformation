<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité correspondant à une playlist
 */
#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, Formation>
     */
    #[ORM\OneToMany(targetEntity: Formation::class, mappedBy: 'playlist')]
    private Collection $formations;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    /**
     * Méthode permettant de récupérer l'id d'une playlist
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le nom d'une playlist
     * 
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Méthode permettant de modifier le nom d'une playlist
     * 
     * @param string|null $name
     * @return static
     */
    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Méthode permettant de récupérer la description d'une playlist
     * 
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Méthode permettant de modifier la description d'une playlist
     * 
     * @param string|null $description
     * @return static
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Méthode permettant de récupérer les formations affectées à une playlist
     * 
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    /**
     * Méthode permettant d'affecter une formation à une playlist
     * 
     * @param Formation $formation
     * @return static
     */
    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->setPlaylist($this);
        }

        return $this;
    }

    /**
     * Méthode permettant de désaffecter une formation d'une playlist
     * 
     * @param Formation $formation
     * @return static
     */
    public function removeFormation(Formation $formation): static
    {
        if ($this->formations->removeElement($formation) && $formation->getPlaylist() === $this) {
            // set the owning side to null (unless already changed)
            $formation->setPlaylist(null);
        }

        return $this;
    }
    
    /**
     * Méthode permettant de récupérer les catégories auxquelles sont affectées les formations affectées à une playlist
     * 
     * @return Collection<int, string>
     */
    public function getCategoriesPlaylist() : Collection
    {
        $categories = new ArrayCollection();
        foreach($this->formations as $formation){
            $categoriesFormation = $formation->getCategories();
            foreach($categoriesFormation as $categorieFormation){
                if(!$categories->contains($categorieFormation->getName())){
                    $categories[] = $categorieFormation->getName();
                }
            }
        }
        return $categories;
    }
}
