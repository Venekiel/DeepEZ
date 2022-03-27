<?php

namespace App\DataFixtures\User;

use Doctrine\Persistence\ObjectManager;

class SuperAdminUserFixtures extends AbstractUserFixtures
{
    public const REFERENCE = 'super-admin-user';

    public function load(ObjectManager $manager)
    {
        $this->loadUser(
            manager: $manager, 
            usernameParameterKey: 'super_admin_username',
            emailParameterKey: 'super_admin_email', 
            passwordParameterKey: 'super_admin_password', 
            roles: ['ROLE_SUPER_ADMIN'],
            reference: self::REFERENCE
        );
    }
}
