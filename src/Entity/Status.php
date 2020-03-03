<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 */
class Status
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Articles", mappedBy="id_status")
     */
    private $listArticles;

    public function __construct()
    {
        $this->listArticles = new ArrayCollection();//possible trie des articles par statut
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    //possible trie des articles par statut
    /**
     * @return Collection|Articles[]
     */
    public function getListArticles(): Collection
    {
        return $this->listArticles;
    }

    public function addListArticle(Articles $listArticle): self
    {
        if (!$this->listArticles->contains($listArticle)) {
            $this->listArticles[] = $listArticle;
            $listArticle->setIdStatus($this);
        }

        return $this;
    }

    public function removeListArticle(Articles $listArticle): self
    {
        if ($this->listArticles->contains($listArticle)) {
            $this->listArticles->removeElement($listArticle);
            // set the owning side to null (unless already changed)
            if ($listArticle->getIdStatus() === $this) {
                $listArticle->setIdStatus(null);
            }
        }

        return $this;
    }
}
