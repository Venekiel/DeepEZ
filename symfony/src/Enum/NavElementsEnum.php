<?php

namespace App\Enum;

class NavElementsEnum extends AbstractEnum {
    public const DASHBOARD = 0;
    public const CALENDAR = 1;
    public const CREDENTIALS = 2;
    public const HELP = 3;

    public static function getNavElements(): array
    {
        return [
            'DASHBOARD' => 0,
            'CALENDAR' => 1,
            'CREDENTIALS' => 2,
            'HELP' => 3,
        ];
    }
}
