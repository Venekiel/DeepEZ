<?php

namespace App\Entity;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Credential", mappedBy="user")
     * @var Collection $credentials
     */
    private Collection $credentials;

    public function __construct(string $username, string $email, string $password = '', array $roles = ['ROLE_USER'])
    {
        $this
            ->setUsername($username)
            ->setEmail($email)
            ->setPassword($password)
            ->setRoles($roles)
        ;        
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
     * Get $credentials
     *
     * @return Collection
     */ 
    public function getCredentials(): Collection
    {
        return $this->credentials;
    }

    /**
     * Set $credentials
     *
     * @param array $credentials
     *
     * @return  self
     */ 
    public function setCredentials(array $credentials): self
    {
        $this->credentials = $credentials;

        return $this;
    }

    public function addCredentials(array $credentials): self
    {
        foreach ($credentials as $credential)
        {
            $this->credentials->add($credential);
        }

        return $this;
    }

    # public function removeCredentials(array $credentials): self
    # {
    #     foreach ($credentials as $credential)
    #     {
    #         /** Search for the credential to remove */
    #         $key = array_search($credential, $this->credentials);
    #     
    #         /** Delete it if found */
    #         $key !== false ? array_splice($this->credentials, $key, 1) : '';
    #     }
    # 
    #     return $this;
    # }
}   
