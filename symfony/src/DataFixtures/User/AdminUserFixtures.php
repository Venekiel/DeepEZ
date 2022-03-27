<?php

namespace App\DataFixtures\User;

use Doctrine\Persistence\ObjectManager;

class AdminUserFixtures extends AbstractUserFixtures
{
    public const REFERENCE = 'admin-user';

    public function load(ObjectManager $manager)
    {
        $this->loadUser(
            manager: $manager, 
            usernameParameterKey: 'admin_username',
            emailParameterKey: 'admin_email', 
            passwordParameterKey: 'admin_password', 
            roles: ['ROLE_ADMIN'],
            reference: self::REFERENCE
        );
    }
}
