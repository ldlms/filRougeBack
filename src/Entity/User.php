<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['note:readAll'])]
    private ?string $pseudo = null;

    #[ORM\Column(length: 100)]
    private ?string $mail = null;

    #[ORM\Column]
    private ?int $role = null;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Favoris::class, orphanRemoval: true)]
    private Collection $favoris;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    #[ORM\OneToMany(mappedBy: 'utilisateur1', targetEntity: FavorisUtilisateur::class, orphanRemoval: true)]
    private Collection $favorisUtilisateur1;

    #[ORM\OneToMany(mappedBy: 'utilisateur2', targetEntity: FavorisUtilisateur::class, orphanRemoval: true)]
    private Collection $favorisUtilisateur2;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Note::class, orphanRemoval: true)]
    private Collection $note;

    public function __construct()
    {
        $this->favoris = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
        $this->favorisUtilisateur1 = new ArrayCollection();
        $this->favorisUtilisateur2 = new ArrayCollection();
        $this->note = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Favoris>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavori(Favoris $favori): self
    {
        if (!$this->favoris->contains($favori)) {
            $this->favoris->add($favori);
            $favori->setUtilisateur($this);
        }

        return $this;
    }

    public function removeFavori(Favoris $favori): self
    {
        if ($this->favoris->removeElement($favori)) {
            // set the owning side to null (unless already changed)
            if ($favori->getUtilisateur() === $this) {
                $favori->setUtilisateur(null);
            }
        }

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
            $commentaire->setUtilisateur($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getUtilisateur() === $this) {
                $commentaire->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FavorisUtilisateur>
     */
    public function getFavorisUtilisateur(): Collection
    {
        return $this->favorisUtilisateur1;
    }

    public function addFavorisUtilisateur(FavorisUtilisateur $favorisUtilisateur1): self
    {
        if (!$this->favorisUtilisateur1->contains($favorisUtilisateur1)) {
            $this->favorisUtilisateur1->add($favorisUtilisateur1);
            $favorisUtilisateur1->setUtilisateur1($this);
        }

        return $this;
    }

    public function removeFavorisUtilisateur(FavorisUtilisateur $favorisUtilisateur1): self
    {
        if ($this->favorisUtilisateur1->removeElement($favorisUtilisateur1)) {
            // set the owning side to null (unless already changed)
            if ($favorisUtilisateur1->getUtilisateur1() === $this) {
                $favorisUtilisateur1->setUtilisateur1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, FavorisUtilisateur>
     */
    public function getFavorisUtilisateur2(): Collection
    {
        return $this->favorisUtilisateur2;
    }

    public function addFavorisUtilisateur2(FavorisUtilisateur $favorisUtilisateur2): self
    {
        if (!$this->favorisUtilisateur2->contains($favorisUtilisateur2)) {
            $this->favorisUtilisateur2->add($favorisUtilisateur2);
            $favorisUtilisateur2->setUtilisateur2($this);
        }

        return $this;
    }

    public function removeFavorisUtilisateur2(FavorisUtilisateur $favorisUtilisateur2): self
    {
        if ($this->favorisUtilisateur2->removeElement($favorisUtilisateur2)) {
            // set the owning side to null (unless already changed)
            if ($favorisUtilisateur2->getUtilisateur2() === $this) {
                $favorisUtilisateur2->setUtilisateur2(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNote(): Collection
    {
        return $this->note;
    }

    public function addNote(Note $note): self
    {
        if (!$this->note->contains($note)) {
            $this->note->add($note);
            $note->setUtilisateur($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->note->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getUtilisateur() === $this) {
                $note->setUtilisateur(null);
            }
        }

        return $this;
    }
}
