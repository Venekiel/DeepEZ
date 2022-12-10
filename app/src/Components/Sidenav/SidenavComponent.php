<?php

// src/Components/AlertComponent.php
namespace App\Components\Sidenav;

use App\Enum\NavElementsEnum;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsTwigComponent('sidenav/sidenav')]
class SidenavComponent
{
    /** @var array[] $navElements */
    private array $navElements;
    private array $activeElement = [];

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator, RequestStack $requestStack)
    {
        $this->request = $requestStack->getMainRequest();
        $this->urlGenerator = $urlGenerator;
        $this->navElements = NavElementsEnum::getConstants();
        $this->generateUris();
    }

    /** @return string[] */
    public function getNavElements(): array
    {
        return $this->navElements;
    }

    public function getActiveElement(): array
    {
        if ($this->activeElement !== []) {
            return $this->activeElement;
        }

        $requestUri = $this->request->getRequestUri();
        $routeNames = NavElementsEnum::getElementsAttribute('routeName');

        foreach ($routeNames as $name => $routeName) {
            if ($routeName === null || !preg_match('#^'. $this->urlGenerator->generate($routeName) .'#', $requestUri)) {
                continue;
            }

            return $this->activeElement = $this->navElements[$name];
        }
    }

    private function generateUris(): void
    {
        foreach ($this->navElements as $name => $navElement) {
            $this->navElements[$name]['uri'] = $navElement['routeName'] !== null ? $this->urlGenerator->generate($navElement['routeName']) : '#';
        }
    }
}