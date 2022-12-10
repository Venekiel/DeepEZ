<?php

namespace App\Enum;

class NavElementsEnum extends AbstractEnum {
    public const DASHBOARD = [
        'title' => 'Dashboard',
        'routeName' => 'dashboard',
        'logo' => '<i class="fas fa-home vertical-center"></i>',
    ];
    public const FINANCIALS = [
        'title' => 'Financials',
        'routeName' => null,
        'logo' => '<i class="fas fa-coins vertical-center"></i>',
    ];
    public const CALENDAR = [
        'title' => 'Calendar',
        'routeName' => null,
        'logo' => '<i class="fas fa-calendar-alt vertical-center"></i>',
    ];
    public const CREDENTIALS = [
        'title' => 'Credentials',
        'routeName' => 'credentials',
        'logo' => '<i class="fas fa-lock vertical-center"></i>',
    ];
    public const HELP = [
        'title' => 'Help',
        'routeName' => null,
        'logo' => '<i class="fas fa-question vertical-center"></i>',
    ];

    public static function getElementsAttribute($attribute)
    {
        $attributes = [];
        $constants = static::getConstants();

        foreach ($constants as $name => $constant) {
            $attributes[$name] = $constant[$attribute];
        }

        return $attributes;
    }
}
