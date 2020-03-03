<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(message="L'email ne peut pas être vide")
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Il vous faut un mot de passe")
     * @Assert\Length(min="2", minMessage="Le prénom est trop petit",
     * max="255", maxMessage="Le prénom est trop long")
     */

     private $password;
    //nullable=true pour l'admin
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Le nom ne peut pas être vide")
     * @Assert\Length(min="3", minMessage="Le nom est trop petit",
     * max="255", maxMessage="Le nom est trop long")
     */
    private $lastName;
    //nullable=true pour l'admin
    /**
     * @ORM\Column(type="string", length=255, nullable=true) 
     * @Assert\NotBlank(message="Le prénom ne peut pas être vide")
     * @Assert\Length(min="3", minMessage="Le prénom est trop petit",
     * max="255", maxMessage="Le prénom est trop long")
     */
    private $firstName;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type(type="DateTime")
     */
    private $createDate;
//, nullable=true
    /**
     * @ORM\Column(type="date")
     * @Assert\Type(type="DateTime")
     */
    private $birthDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Articles", mappedBy="author")
     */
    private $listArticles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="users")
     */
    private $listComments;

    public function __construct()
    {
        $this->listArticles = new ArrayCollection();
        $this->listComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getcreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setcreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

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
            $listArticle->setAuthor($this);
        }

        return $this;
    }

    public function removeListArticle(Articles $listArticle): self
    {
        if ($this->listArticles->contains($listArticle)) {
            $this->listArticles->removeElement($listArticle);
            // set the owning side to null (unless already changed)
            if ($listArticle->getAuthor() === $this) {
                $listArticle->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getListComments(): Collection
    {
        return $this->listComments;
    }

    public function addListComment(Comments $listComment): self
    {
        if (!$this->listComments->contains($listComment)) {
            $this->listComments[] = $listComment;
            $listComment->setUsers($this);
        }

        return $this;
    }

    public function removeListComment(Comments $listComment): self
    {
        if ($this->listComments->contains($listComment)) {
            $this->listComments->removeElement($listComment);
            // set the owning side to null (unless already changed)
            if ($listComment->getUsers() === $this) {
                $listComment->setUsers(null);
            }
        }

        return $this;
    }

}
