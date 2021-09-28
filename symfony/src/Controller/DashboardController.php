<?php

namespace App\Controller;

use App\Enum\NavElementsEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render("dashboard/view.html.twig", [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::DASHBOARD,
        ]);
    }
}
