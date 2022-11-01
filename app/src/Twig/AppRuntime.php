<?php

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class AppRuntime implements RuntimeExtensionInterface
{
    public function is_bool(mixed $value): bool
    {
        return is_bool($value);
    }
}