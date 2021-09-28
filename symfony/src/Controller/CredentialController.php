<?php

namespace App\Controller;

use App\Entity\Credential;
use App\Enum\NavElementsEnum;
use App\Repository\CredentialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CredentialController extends AbstractController
{
    private CredentialRepository $repository;

    public function __construct(CredentialRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @Route("/credentials", name="credentials")
     */
    public function credentials(): Response
    {
        $credentials = $this->repository->findall();

        return $this->render('credentials/view.html.twig', [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::CREDENTIALS,
            'credentials' => $credentials,
        ]);
    }

    
    /**
     * @Route("/credential/{#id}", name="credential")
     */
    public function credential(CredentialRepository $repository, Credential $credential): Response
    {
        return $this->render('credentials/view.html.twig', [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => $this::ACTIVE_NAV_ELEMENT,
            'credential' => $credential,
        ]);
    }
}
