<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class AppExtension extends AbstractExtension
{
    public function getTests()
    {
        return [
            new TwigTest('bool', [AppRuntime::class, 'is_bool']),
        ];
    }
}