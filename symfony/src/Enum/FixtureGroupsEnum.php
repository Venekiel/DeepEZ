<?php

namespace App\Enum;

class FixtureGroupsEnum extends AbstractEnum {
    public const ALL = 'all';   /** Regroup all fixtures */
    public const PROD = 'prod'; /** Regroup fixtures meant to be used in production environment */
    public const USER = 'user'; /** Regroup all user related fixtures */
}
