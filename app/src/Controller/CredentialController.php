<?php

namespace App\Controller;

use App\Entity\Credential;
use App\Enum\NavElementsEnum;
use App\Form\PageSelectionFormType;
use App\Form\Type\CredentialType;
use App\Repository\CredentialRepository;
use App\Services\PaginatorService;
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
    public const PAGINATION_FIRST_PAGE = 1;
    public const PAGINATION_MAX_RESULTS = 50;

    private CredentialRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, CredentialRepository $repository) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/page-{page}", name="credentials", defaults={"page" = self::PAGINATION_FIRST_PAGE}, requirements={"page"="\d+"}, methods={"GET", "POST"})
     */
    public function list(Request $request, PaginatorService $paginatorService, int $page = self::PAGINATION_FIRST_PAGE): Response
    {
        $credentials = $this->repository->findPaginatedBy(['user' => $this->getUser()], $page, static::PAGINATION_MAX_RESULTS);
        $formOptions['pageCount'] = $paginatorService->getPageCount($credentials);

        $pageSelectionForm = $this->createForm(PageSelectionFormType::class, [
            'page' => $page,
        ], $formOptions);

        $pageSelectionForm->handleRequest($request);
        // Handle form submission
        // Or redirect to first page if asked page is empty
        if (($pageSelectionForm->isSubmitted() && $pageSelectionForm->isValid()) || count($credentials->getIterator()) <= 0) {
            $formData = $pageSelectionForm->getData();
            $page = $formData['page'] !== null ? $formData['page'] : static::PAGINATION_FIRST_PAGE;

            $this->redirectToRoute('credentials', [
                'page' => $page,
            ]);
        }

        return $this->renderForm('credentials/list.html.twig', [
            'credentials' => $credentials,
            'pageSelectionForm' => $pageSelectionForm,
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
