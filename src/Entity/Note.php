<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['note:readAll', 'note:id'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['note:readAll', 'note:id'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(['note:readAll', 'note:id'])]
    private ?int $score = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['note:readAll', 'note:id'])]
    private ?string $critique = null;

    #[ORM\ManyToOne(inversedBy: 'note')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Livre $livre = null;

    #[ORM\OneToMany(mappedBy: 'note', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    #[ORM\ManyToOne(inversedBy: 'note')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $utilisateur = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['note:readAll', 'note:id'])]
    private ?string $titreCritique = null;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getCritique(): ?string
    {
        return $this->critique;
    }

    public function setCritique(?string $critique): self
    {
        $this->critique = $critique;

        return $this;
    }

    public function getLivre(): ?Livre
    {
        return $this->livre;
    }

    public function setLivre(?Livre $livre): self
    {
        $this->livre = $livre;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setNote($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getNote() === $this) {
                $commentaire->setNote(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getTitreCritique(): ?string
    {
        return $this->titreCritique;
    }

    public function setTitreCritique(?string $titreCritique): self
    {
        $this->titreCritique = $titreCritique;

        return $this;
    }
}
