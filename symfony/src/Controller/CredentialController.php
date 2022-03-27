<?php

namespace App\Controller;

use App\Entity\Credential;
use App\Enum\NavElementsEnum;
use App\Form\Type\CredentialType;
use App\Repository\CredentialRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\PasswordGeneratorService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/credentials")
 */
class CredentialController extends AbstractController
{
    private CredentialRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, CredentialRepository $repository) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("", name="credentials")
     */
    public function credentials(): Response
    {
        $credentials = $this->repository->findBy(['user' => $this->getUser()]);

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
     * @Route("/edit/{id}", name="edit-credential", requirements={"id"="\d+"})
     */
    public function editCredential(Request $request, $id = null)
    {
        /** Detect if we need to create or update a credential */
        if ($id === null) {
            $credential = new Credential();
            $template = 'credentials/create.html.twig';
        } else {
            $credential = $this->entityManager->getRepository(Credential::class)->findOneBy(['id' => $id]);
            $template = 'credentials/edit.html.twig';
        }

        $form = $this->createForm(CredentialType::class, $credential);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($credential);
            $this->entityManager->flush();

            return new RedirectResponse($this->generateUrl('read-credential', ['id' => $credential->getId()]));
        }

        return $this->renderform($template, [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::CREDENTIALS,
            'form' => $form,    
        ]);
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
            $this->entityManager->remove($credential);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('credentials');
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(): JsonResponse
    {
        $generator = new PasswordGeneratorService();

        $test = $generator->generate();

        return new JsonResponse(['test' => $test]);
    }
}
