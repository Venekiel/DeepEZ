<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Credential;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\User\{
    AdminUserFixtures,
    SuperAdminUserFixtures,
    UserFixtures
};
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CredentialFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    const ITERATIONS = 50;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        /** @var User[] $users */
        $users = [
            $this->getReference(AdminUserFixtures::REFERENCE),
            $this->getReference(SuperAdminUserFixtures::REFERENCE),
            $this->getReference(UserFixtures::REFERENCE)
        ];

        $userCount = count($users);

        for ($i = 0; $i < $this::ITERATIONS; $i++)
        {
            $credential = (new Credential())
                ->setName($faker->domainName())
                ->setUsername($faker->email())
                ->setPassword($faker->password())
            ;

            $randomUser = $users[rand(1, $userCount) - 1];
            $credential->setUser($randomUser);

            $manager->persist($credential);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AdminUserFixtures::class,
            SuperAdminUserFixtures::class,
            UserFixtures::class
        ];
    }
}
