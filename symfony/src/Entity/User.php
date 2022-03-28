<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Credential::class, mappedBy="user")
     */
    private $credentials;

    public function __construct(string $username, string $email, string $password = '', array $roles = ['ROLE_USER'])
    {
        $this
            ->setUsername($username)
            ->setEmail($email)
            ->setPassword($password)
            ->setRoles($roles)
        ;
        $this->credential = new ArrayCollection();        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username): self
    {
        $this->username = $username;

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Credential>
     */
    public function getCredentials(): Collection
    {
        return $this->credentials;
    }

    public function addCredential(Credential $credential): self
    {
        if (!$this->credentials->contains($credential)) {
            $this->credential[] = $credential;
            $credential->setUser($this);
        }

        return $this;
    }

    public function removeCredential(Credential $credential): self
    {
        if ($this->credentials->removeElement($credential)) {
            // set the owning side to null (unless already changed)
            if ($credential->getUser() === $this) {
                $credential->setUser(null);
            }
        }

        return $this;
    }
}   
