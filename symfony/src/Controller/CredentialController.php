<?php

namespace App\Controller;

use App\Entity\Credential;
use App\Enum\NavElementsEnum;
use App\Form\Type\CredentialType;
use App\Repository\CredentialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/{id}", name="read-credential", requirements={"id"="\d+"})
     */
    public function readCredential(Credential $credential): Response
    {
        $form = $this->createForm(CredentialType::class, $credential);

        return $this->renderForm('credentials/read.html.twig', [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::CREDENTIALS,
            'form' => $form,
            'id' => $credential->getId(),
        ]);
    }

    /**
     * @Route("/new", name="create-credential")
     */
    public function createCredential(Request $request): Response
    {
        $credential = new Credential();
        $form = $this->createForm(CredentialType::class, $credential);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($credential);
            $entityManager->flush();
        }

        return $this->renderform('credentials/create.html.twig', [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::CREDENTIALS,
            'form' => $form,    
        ]);
    }

    /**
     * @Route("/edit/{id}", name="update-credential", requirements={"id"="\d+"})
     */
    public function updateCredential(Credential $credential): Response
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
