<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManagerService
{
    private UserPasswordHasherInterface $passwordHasher;
    private User $user;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function createUser(string $username, string $email, string $password, array $roles = ['ROLE_USER']): User
    {
        $this->user = (new User())
            ->setUsername($username)
            ->setEmail($email)
        ;

        /** hash the password */
        $password = $this->passwordHasher->hashPassword(
            $this->user,
            $password
        );

        /** Fill the user data */
        $this->user
            ->setPassword($password)
            ->setRoles($roles)
        ;

        return $this->user;
    }
}
