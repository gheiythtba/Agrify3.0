<?php

namespace App\Controller;

use App\Entity\PlanteStock;
use App\Form\PlanteStockType;
use App\Repository\PlanteStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/plante/stock')]
class PlanteStockController extends AbstractController
{
    #[Route('/', name: 'app_plante_stock_index', methods: ['GET'])]
    public function index(PlanteStockRepository $planteStockRepository): Response
    {
        return $this->render('plante_stock/index.html.twig', [
            'plante_stocks' => $planteStockRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_plante_stock_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $planteStock = new PlanteStock();
        $form = $this->createForm(PlanteStockType::class, $planteStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($planteStock);
            $entityManager->flush();

            return $this->redirectToRoute('app_plante_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plante_stock/new.html.twig', [
            'plante_stock' => $planteStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plante_stock_show', methods: ['GET'])]
    public function show(PlanteStock $planteStock): Response
    {
        return $this->render('plante_stock/show.html.twig', [
            'plante_stock' => $planteStock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plante_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlanteStock $planteStock, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlanteStockType::class, $planteStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_plante_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('plante_stock/edit.html.twig', [
            'plante_stock' => $planteStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plante_stock_delete', methods: ['POST'])]
    public function delete(Request $request, PlanteStock $planteStock, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$planteStock->getId(), $request->request->get('_token'))) {
            $entityManager->remove($planteStock);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_plante_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
