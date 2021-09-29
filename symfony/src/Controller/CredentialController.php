<?php

namespace App\Controller;

use App\Entity\Credential;
use App\Enum\NavElementsEnum;
use App\Repository\CredentialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/credentials")
 */
class CredentialController extends AbstractController
{
    private CredentialRepository $repository;

    public function __construct(CredentialRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @Route("/", name="credentials")
     */
    public function credentials(): Response
    {
        $credentials = $this->repository->findall();

        return $this->render('credentials/list.html.twig', [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::CREDENTIALS,
            'credentials' => $credentials,
        ]);
    }
    
    /**
     * @Route("/{id}", name="credential", requirements={"id"="\d+"})
     */
    public function credential(Credential $credential): Response
    {
        return $this->render('credentials/view.html.twig', [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::CREDENTIALS,
            'credential' => $credential,
        ]);
    }

    /**
     * @Route("/new", name="add-credential")
     */
    public function addCredential(): Response
    {
        return $this->json(["status" => 200, "Info" => "This route is still a Work In Progress"]);
    }

    /**
     * @Route("/edit/{id}", name="edit-credential", requirements={"id"="\d+"})
     */
    public function editCredential(Credential $credential): Response
    {
        return $this->json(["status" => 200, "Info" => "This route is still a Work In Progress", "credential" => $credential]);
    }

    /**
     * @Route("/delete/{id}", name="delete-credential", requirements={"id"="\d+"})
     */
    public function deleteCredential(Credential $credential = null): Response
    {
        /**
         * Deletes Credential only if one is found in database
         */
        if ($credential !== null)
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($credential);
            $entityManager->flush();
        }

        return $this->redirectToRoute('credentials');
    }
}
