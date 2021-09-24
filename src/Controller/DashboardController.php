<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    const ACTIVE_NAV_ELEMENT = 'dashboard';

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render("dashboard/view.html.twig", [
        // return $this->render("passwords/view.html.twig", [
            'active_nav_element' => $this::ACTIVE_NAV_ELEMENT,
        ]);
    }
}
