<?php

namespace App\Components\Credentials;

use App\Entity\Credential;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('credentials/element')]
class ElementComponent
{
    public Credential $credential;
}
