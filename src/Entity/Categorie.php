<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité correspondant à une catégorie
 */
#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * 
     * @var string|null
     */
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $name = null;

    /**
     * @var Collection<int, Formation>
     */
    #[ORM\ManyToMany(targetEntity: Formation::class, mappedBy: 'categories')]
    private Collection $formations;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->formations = new ArrayCollection();
    }

    /**
     * Méthode permettant de récupérer l'id d'une catégorie
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer le nom d'une catégorie
     * 
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Méthode permettant de modifier le nom d'une catégorie
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
     * Méthode permettant de récupérer les formations appartenant à une catégorie
     * 
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    /**
     * Méthode permettant d'affecter une formation à une catégorie
     * 
     * @param Formation $formation
     * @return static
     */
    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->addCategory($this);
        }

        return $this;
    }

    /**
     * Méthode permettant de désaffecter une formation d'une catégorie
     * 
     * @param Formation $formation
     * @return static
     */
    public function removeFormation(Formation $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            $formation->removeCategory($this);
        }

        return $this;
    }
}
