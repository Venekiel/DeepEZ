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

    public function createUser(string $email, string $password, array $roles = ['ROLE_USER']): User
    {
        $this->user = new User();

        /** hash the password */
        $password = $this->passwordHasher->hashPassword(
            $this->user,
            $password
        );

        /** Fill the user data */
        $this->user = (new User())
            ->setEmail($email)
            ->setPassword($password)
            ->setRoles($roles)
        ;

        return $this->user;
    }

}