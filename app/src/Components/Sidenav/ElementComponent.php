<?php

namespace App\Components\Sidenav;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('sidenav/element')]
class ElementComponent
{
    public array $navElement;
    public array $activeElement;
}