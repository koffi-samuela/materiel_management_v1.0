<?php

namespace App\Controller;

use App\Entity\TrainingProgram;
use App\Form\TrainingProgramType;
use App\Repository\TrainingProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/training_program', name: 'app_training_program_')]
class TrainingProgramController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(TrainingProgramRepository $trainingProgramRepository): Response
    {
        return $this->render('training_program/index.html.twig', [
            'training_programs' => $trainingProgramRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trainingProgram = new TrainingProgram();
        $form = $this->createForm(TrainingProgramType::class, $trainingProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($trainingProgram);
            $entityManager->flush();

            return $this->redirectToRoute('app_training_program_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_program/new.html.twig', [
            'training_program' => $trainingProgram,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(TrainingProgram $trainingProgram): Response
    {
        $user = $this->getUser();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('training_program/show.html.twig', [
            'training_program' => $trainingProgram,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TrainingProgram $trainingProgram, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrainingProgramType::class, $trainingProgram);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('training_program/edit.html.twig', [
            'training_program' => $trainingProgram,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, TrainingProgram $trainingProgram, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trainingProgram->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trainingProgram);
            $entityManager->flush();
        }

        return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
    }
}
