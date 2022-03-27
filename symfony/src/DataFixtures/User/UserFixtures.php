<?php

namespace App\DataFixtures\User;

use Doctrine\Persistence\ObjectManager;

class UserFixtures extends AbstractUserFixtures
{
    public function load(ObjectManager $manager)
    {
        $this->loadUser(
            manager: $manager, 
            emailParameterKey: 'user_email', 
            passwordParameterKey: 'user_password'
        );

        $manager->flush();
    }
}
