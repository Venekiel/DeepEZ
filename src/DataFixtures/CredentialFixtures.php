<?php

namespace App\DataFixtures;

use App\Entity\Credential;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class CredentialFixtures extends Fixture
{
    const ITERATIONS = 10;
    // private $faker = Factory::create();

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < $this::ITERATIONS; $i++)
        {
            $credential = (new Credential())
                ->setName($faker->name())
            ;

            $manager->persist($credential);
        }

        $manager->flush();
    }
}
