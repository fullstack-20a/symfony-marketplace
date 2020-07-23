<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\ORM\Mapping as ORM;
// POUR API PLATFORM
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AnnonceRepository::class)
 * @ApiResource(
 *     attributes={"pagination_items_per_page"=100},
 *     normalizationContext={"groups"={"scenario1"}},
 *     denormalizationContext={"groups"={"scenario2"}}
 * ) 
 */
class Annonce
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"scenario1", "scenario2"})
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=160)
     * @Groups({"scenario1", "scenario2"})
     */
    public $titre;

    /**
     * @ORM\Column(type="string", length=160)
     */
    private $uri;

    /**
     * @ORM\Column(type="text")
     * @Groups({"scenario1"})
     */
    public $description;

    /**
     * @ORM\Column(type="string", length=160)
     * @Groups({"scenario1", "scenario2"})
     */
    public $photo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTabJson ()
    {
        $tabAsso = [];
        // ON VA CONVERTIR L'OBJET EN TABLEAU ASSOCIATIF
        $tabAsso["id"]          = $this->id;
        $tabAsso["titre"]       = $this->titre;
        $tabAsso["description"] = $this->description;
        $tabAsso["photo"]       = $this->photo;

        // ...
        return $tabAsso;
    }
}
