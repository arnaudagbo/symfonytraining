<?php
namespace App\Entity;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
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
    private $firstname;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthday;
    /**
     * @ORM\Column(type="simple_array")
     */
    private $roles;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apiKey;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="userId")
     */
    private $articles;
    public function __construct()
    {
        $this->roles = array('ROLE_USER');
        $this->apiKey = uniqid('', true);
        $this->articles = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }
    public function getLastname(): ?string
    {
        return $this->lastname;
    }
    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
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
    public function getBirthday(): ?DateTimeInterface
    {
        return $this->birthday;
    }
    public function setBirthday(DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;
        return $this;
    }
    public function getRoles(): ?array
    {
        return $this->roles;
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    public function getApiKey(): ?string
    {
        return $this->apiKey;
    }
    public function setApiKey(string $apiKey): self
    {
        $this->apiKey = $apiKey;
        return $this;
    }
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setUserId($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getUserId() === $this) {
                $article->setUserId(null);
            }
        }

        return $this;
    }
}