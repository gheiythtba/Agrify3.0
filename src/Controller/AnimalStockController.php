<?php

namespace App\Controller;

use App\Entity\AnimalStock;
use App\Form\AnimalStockType;
use App\Repository\AnimalStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/animal/stock')]
class AnimalStockController extends AbstractController
{
    #[Route('/', name: 'app_animal_stock_index', methods: ['GET'])]
    public function index(AnimalStockRepository $animalStockRepository): Response
    {
        return $this->render('animal_stock/index.html.twig', [
            'animal_stocks' => $animalStockRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_animal_stock_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animalStock = new AnimalStock();
        $form = $this->createForm(AnimalStockType::class, $animalStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animalStock);
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('animal_stock/new.html.twig', [
            'animal_stock' => $animalStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_stock_show', methods: ['GET'])]
    public function show(AnimalStock $animalStock): Response
    {
        return $this->render('animal_stock/show.html.twig', [
            'animal_stock' => $animalStock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_animal_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnimalStock $animalStock, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimalStockType::class, $animalStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('animal_stock/edit.html.twig', [
            'animal_stock' => $animalStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_stock_delete', methods: ['POST'])]
    public function delete(Request $request, AnimalStock $animalStock, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animalStock->getId(), $request->request->get('_token'))) {
            $entityManager->remove($animalStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animal_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
