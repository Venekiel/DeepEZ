<?php

namespace App\DataFixtures\User;

use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractUserFixtures
{
    public const REFERENCE = 'user';

    public function load(ObjectManager $manager)
    {
        $this->loadUser(
            manager: $manager, 
            usernameParameterKey: 'user_username',
            emailParameterKey: 'user_email', 
            passwordParameterKey: 'user_password',
            reference: self::REFERENCE
        );
    }
}
