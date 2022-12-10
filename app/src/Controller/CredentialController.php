<?php

namespace App\Controller;

use App\Entity\Credential;
use App\Form\PaginationFormType;
use App\Form\Type\CredentialType;
use App\Services\PaginatorService;
use App\Repository\CredentialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Cookie;
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
    public const PAGINATION_FIRST_PAGE = 1;
    public const PAGINATION_MAX_RESULTS = 50;
    private const CREDENTIALS_PAGE_COOKIE = 'credentials_page';

    private CredentialRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, CredentialRepository $repository) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="credentials", methods={"GET", "POST"})
     */
    public function list(Request $request, PaginatorService $paginatorService): Response
    {
        $response = new Response();
        $page = $request->cookies->get(static::CREDENTIALS_PAGE_COOKIE) ?? static::PAGINATION_FIRST_PAGE;

        $credentials = $this->repository->findPaginatedBy(['user' => $this->getUser()], $page, static::PAGINATION_MAX_RESULTS);
        $formOptions['pageCount'] = $paginatorService->getPageCount($credentials);

        $paginationForm = $this->createForm(PaginationFormType::class, [
            'page' => $page,
        ], $formOptions);

        $paginationForm->handleRequest($request);
        // Handle form submission
        // Or redirect to first page if asked page is empty
        if (($paginationForm->isSubmitted() && $paginationForm->isValid()) || count($credentials->getIterator()) <= 0) {
            $formData = $paginationForm->getData();
            $page = $formData['page'] !== null ? $formData['page'] : static::PAGINATION_FIRST_PAGE;

            $pageCookie = new Cookie(static::CREDENTIALS_PAGE_COOKIE, $page);
            $response->headers->setCookie($pageCookie);

            $credentials = $this->repository->findPaginatedBy(['user' => $this->getUser()], $page, static::PAGINATION_MAX_RESULTS);
        }

        return $this->renderForm('credentials/list.html.twig', [
            'credentials' => $credentials,
            'paginationForm' => $paginationForm,
        ], $response);
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
