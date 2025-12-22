<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité correspondant à une formation
 */
#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    /**
     * Début de chemin vers les images
     */
    private const CHEMINIMAGE = "https://i.ytimg.com/vi/";
    
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\LessThanOrEqual("now")]
    private ?DateTimeInterface $publishedAt = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $title = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $videoId = null;

    /**
     * @var Playlist|null
     */
    #[ORM\ManyToOne(inversedBy: 'formations')]
    private ?Playlist $playlist = null;

    /**
     * @var Collection<int, Categorie>
     */
    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'formations')]
    private Collection $categories;

    /**
     * Constructeur
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * Méthode permettant de récupérer l'id d'une formation
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Méthode permettant de récupérer la date de publication d'une formation
     * 
     * @return DateTimeInterface|null
     */
    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * Méthode permettant de modifier la date de publication d'une formation
     * 
     * @param DateTimeInterface|null $publishedAt
     * @return static
     */
    public function setPublishedAt(?DateTimeInterface $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * Méthode permettant de récupérer la date de publication d'une formation sous la forme d'une chaîne de caractères
     * 
     * @return string
     */
    public function getPublishedAtString(): string {
        if($this->publishedAt == null){
            return "";
        }
        return $this->publishedAt->format('d/m/Y');     
    }      
    
    /**
     * Méthode permettant de récupérer le titre d'une formation
     * 
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Méthode permettant de modifier le titre d'une formation
     * 
     * @param string|null $title
     * @return static
     */
    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Méthode permettant de récupérer la description d'une formation
     * 
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Méthode permettant de modifier la description d'une formation
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
     * Méthode permettant de récupérer l'id de la vidéo d'une formation
     * 
     * @return string|null
     */
    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    /**
     * Méthode permettant de modifier l'id de la vidéo d'une formation
     * 
     * @param string|null $videoId
     * @return static
     */
    public function setVideoId(?string $videoId): static
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * Méthode permettant de récupérer la miniature d'une formation
     * 
     * @return string|null
     */
    public function getMiniature(): ?string
    {
        return self::CHEMINIMAGE.$this->videoId."/default.jpg";
    }

    /**
     * Méthode permettant de récupérer l'image d'une formation
     * 
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return self::CHEMINIMAGE.$this->videoId."/hqdefault.jpg";
    }
    
    /**
     * Méthode permettant de récupérer la playlist à laquelle est affectée une formation
     * 
     * @return playlist|null
     */
    public function getPlaylist(): ?playlist
    {
        return $this->playlist;
    }

    /**
     * Méthode permettant de modifier la playlist à laquelle est affectée une formation
     * 
     * @param Playlist|null $playlist
     * @return static
     */
    public function setPlaylist(?Playlist $playlist): static
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * Méthode permettant de récupérer les catégories auxquelles est affectée une formation
     * 
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * Méthode permettant d'affecter une catégorie à une formation
     * 
     * @param Categorie $category
     * @return static
     */
    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    /**
     * Méthode permettant de désaffecter une catégorie d'une formation
     * 
     * @param Categorie $category
     * @return static
     */
    public function removeCategory(Categorie $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
