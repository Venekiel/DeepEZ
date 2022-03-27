<?php

namespace App\DataFixtures;

use App\Entity\Credential;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CredentialFixtures extends AbstractFixtures
{
    const ITERATIONS = 50;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < $this::ITERATIONS; $i++)
        {
            $credential = (new Credential())
                ->setName($faker->domainName())
                ->setUsername($faker->email())
                ->setPassword($faker->password())
            ;

            $manager->persist($credential);
        }

        $manager->flush();
    }
}
