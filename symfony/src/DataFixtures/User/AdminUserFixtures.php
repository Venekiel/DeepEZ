<?php

namespace App\DataFixtures\User;

use Doctrine\Persistence\ObjectManager;

class AdminUserFixtures extends AbstractUserFixtures
{
    public function load(ObjectManager $manager)
    {
        $this->loadUser(
            manager: $manager, 
            emailParameterKey: 'admin_email', 
            passwordParameterKey: 'admin_password', 
            roles: ['ROLE_ADMIN']
        );

        $manager->flush();
    }
}
