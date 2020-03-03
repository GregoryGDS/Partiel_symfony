<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RolesRepository")
 */
class Roles
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
    private $libe√elle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibe√elle(): ?string
    {
        return $this->libe√elle;
    }

    public function setLibe√elle(string $libe√elle): self
    {
        $this->libe√elle = $libe√elle;

        return $this;
    }
}
