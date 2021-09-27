<?php

namespace App\Controller;

use App\Repository\CredentialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    const ACTIVE_NAV_ELEMENT = 'password';
    // private EntityManagerInterface $entityManager;

    // public function __construct(EntityManagerInterface $entityManager) {
        // $this->entityManager = $entityManager;
    // }

    /**
     * @Route("/password", name="password")
     */
    public function password(CredentialRepository $repository): Response
    {
        $credentials = $repository->findall();

        return $this->render('password/view.html.twig', [
            'active_nav_element' => $this::ACTIVE_NAV_ELEMENT,
            'credentials' => $credentials,
        ]);
    }
}
