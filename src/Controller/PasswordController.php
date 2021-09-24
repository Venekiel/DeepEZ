<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    #[Route('/password', name: 'password')]
    public function password(): Response
    {
        return $this->render('password/view.html.twig', [
            'active_page' => 'password',
        ]);
    }
}
