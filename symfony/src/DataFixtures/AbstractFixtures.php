<?php

namespace App\DataFixtures;

use App\Enum\FixtureGroupsEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

abstract class AbstractFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return [FixtureGroupsEnum::ALL, FixtureGroupsEnum::PROD];
    }
}