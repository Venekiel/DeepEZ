<?php

namespace App\DataFixtures\User;

use App\Entity\User;
use App\Enum\FixtureGroupsEnum;
use App\Services\UserManagerService;
use App\DataFixtures\AbstractFixtures;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

abstract class AbstractUserFixtures extends AbstractFixtures
{
    protected ParameterBagInterface $parameterBag;
    protected UserManagerService $userManager;
    protected User $user;

    public function __construct(ParameterBagInterface $parameterBag, UserManagerService $userManager)
    {
        $this->parameterBag = $parameterBag;
        $this->userManager = $userManager;
    }

    protected function loadUser(ObjectManager $manager, string $emailParameterKey, string $passwordParameterKey, array $roles = ['ROLE_USER'])
    {
        $email = $this->parameterBag->get($emailParameterKey);
        $password = $this->parameterBag->get($passwordParameterKey);

        $this->user = $this->userManager->createUser($email, $password, $roles);
        $manager->persist($this->user);
    }

    public static function getGroups(): array
    {
        return [FixtureGroupsEnum::ALL, FixtureGroupsEnum::USER];
    }
}