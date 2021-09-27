<?php

namespace App\Controller;

use App\Repository\CredentialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CredentialController extends AbstractController
{
    const ACTIVE_NAV_ELEMENT = 'credentials';
    // private EntityManagerInterface $entityManager;

    // public function __construct(EntityManagerInterface $entityManager) {
        // $this->entityManager = $entityManager;
    // }

    /**
     * @Route("/credentials", name="credentials")
     */
    public function credentials(CredentialRepository $repository): Response
    {
        $credentials = $repository->findall();

        return $this->render('credentials/view.html.twig', [
            'active_nav_element' => $this::ACTIVE_NAV_ELEMENT,
            'credentials' => $credentials,
        ]);
    }
}
