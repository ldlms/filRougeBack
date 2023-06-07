<?php

namespace App\Entity;

use App\Repository\FavorisUtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavorisUtilisateurRepository::class)]
class FavorisUtilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $statut = null;

    #[ORM\ManyToOne(inversedBy: 'favorisUtilisateur1')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur1 = null;

    #[ORM\ManyToOne(inversedBy: 'favorisUtilisateur2')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $utilisateur2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUtilisateur1(): ?User
    {
        return $this->utilisateur1;
    }

    public function setUtilisateur1(?User $utilisateur1): self
    {
        $this->utilisateur1 = $utilisateur1;

        return $this;
    }

    public function getUtilisateur2(): ?User
    {
        return $this->utilisateur2;
    }

    public function setUtilisateur2(?User $utilisateur2): self
    {
        $this->utilisateur2 = $utilisateur2;

        return $this;
    }
}
