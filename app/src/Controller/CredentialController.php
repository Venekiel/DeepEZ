<?php

namespace App\Controller;

use App\Entity\Credential;
use App\Enum\NavElementsEnum;
use App\Form\Type\CredentialType;
use App\Repository\CredentialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
    public function list(): Response
    {
        $credentials = $this->repository->findBy(['user' => $this->getUser()]);

        return $this->render('credentials/list.html.twig', [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::CREDENTIALS,
            'credentials' => $credentials,
        ]);
    }
    
    /**
     * @Route("/create", name="create-credential", requirements={"id"="\d+"})
     */
    public function create(Request $request): Response
    {
        $credential = (new Credential())
            ->setUser($this->getUser())
        ;

        $form = $this->createForm(CredentialType::class, $credential);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->processForm($form, $credential);

            return new RedirectResponse($this->generateUrl('read-credential', ['id' => $credential->getId()]));
        }

        return $this->renderform('credentials/create.html.twig', [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::CREDENTIALS,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="read-credential", requirements={"id"="\d+"})
     */
    public function read(Credential $credential): Response
    {
        // Access verification is handled by App/Security/CredentialVoter
        if (!$this->isGranted('read', $credential)) {
            return new Response(status: 404);
        }

        $form = $this->createForm(CredentialType::class, $credential, ['readonly' => true]);

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
    public function edit(Request $request, Credential $credential): Response
    {
        // Access verification is handled by `App/Security/CredentialVoter`
        if (!$this->isGranted('edit', $credential)) {
            return new Response(status: 404);
        }

        $form = $this->createForm(CredentialType::class, $credential);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->processForm($form, $credential);

            return new RedirectResponse($this->generateUrl('read-credential', ['id' => $credential->getId()]));
        }

        return $this->renderform('credentials/edit.html.twig', [
            'nav_elements' => NavElementsEnum::getConstants(),
            'active_nav_element' => NavElementsEnum::CREDENTIALS,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete-credential", requirements={"id"="\d+"})
     */
    public function delete(Credential $credential = null): Response
    {
        // Access verification is handled by `App/Security/CredentialVoter`
        if (!$this->isGranted('delete', $credential)) {
            return new Response(status: 404);
        }

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

    private function processForm(FormInterface $form, Credential $credential = null): never
    {
        $this->entityManager->persist($credential);
        $this->entityManager->flush();
    }
}
