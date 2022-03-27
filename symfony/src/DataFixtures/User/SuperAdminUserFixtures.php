<?php

namespace App\DataFixtures\User;

use Doctrine\Persistence\ObjectManager;

class SuperAdminUserFixtures extends AbstractUserFixtures
{
    public function load(ObjectManager $manager)
    {
        $this->loadUser(
            manager: $manager, 
            emailParameterKey: 'super_admin_email', 
            passwordParameterKey: 'super_admin_password', 
            roles: ['ROLE_SUPER_ADMIN']
        );

        $manager->flush();
    }
}
