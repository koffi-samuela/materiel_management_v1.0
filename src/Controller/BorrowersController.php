<?php

namespace App\Controller;

use App\Entity\Borrowing;
use App\Form\BorrowingType;
use App\Repository\BorrowingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/borrowers')]
class BorrowersController extends AbstractController
{
    
    #[Route('/', name: 'app_borrowers_index', methods: ['GET'])]
    public function index(Request $request, BorrowingRepository $borrowingRepository): Response
    {
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $searchQuery = $request->query->get('q');
    
        // Si une recherche est effectuée, filtrer les matériaux par ID
        if ($searchQuery) {
        // Utilisation d'une requête personnalisée avec LIKE SQL pour correspondre aux parties du numéro de série
        $borrowings = $borrowingRepository->createQueryBuilder('m')
            ->where('m.student LIKE :searchQuery')
            ->setParameter('searchQuery', '%'.$searchQuery.'%')
            ->getQuery()
            ->getResult();
        
    } else {
        // Sinon, récupérer tous les matériaux
        $borrowings = $borrowingRepository->findAll();
    }
        return $this->render('borrowers/index.html.twig', [
            'borrowers' => $borrowings,
        ]);
    }

    #[Route('/new', name: 'app_borrowers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $borrowing = new Borrowing();
        $form = $this->createForm(BorrowingType::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($borrowing);
            $entityManager->flush();

            return $this->redirectToRoute('app_borrowers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrowers/new.html.twig', [
            'borrowing' => $borrowing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrowers_show', methods: ['GET'])]
    public function show(Borrowing $borrowing): Response
    {
        return $this->render('borrowers/show.html.twig', [
            'borrowing' => $borrowing,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_borrowers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BorrowingType::class, $borrowing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_borrowers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('borrowers/edit.html.twig', [
            'borrowing' => $borrowing,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_borrowing_delete', methods: ['POST'])]
    public function delete(Request $request, Borrowing $borrowing, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borrowing->getId(), $request->request->get('_token'))) {
            $entityManager->remove($borrowing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_borrowing_index', [], Response::HTTP_SEE_OTHER);
    }
}
