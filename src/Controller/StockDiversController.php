<?php

namespace App\Controller;

use App\Entity\StockDivers;
use App\Form\StockDiversType;
use App\Repository\StockDiversRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stock/divers')]
class StockDiversController extends AbstractController
{
    #[Route('/', name: 'app_stock_divers_index', methods: ['GET'])]
    public function index(StockDiversRepository $stockDiversRepository): Response
    {
        return $this->render('stock_divers/index.html.twig', [
            'stock_divers' => $stockDiversRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stock_divers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stockDiver = new StockDivers();
        $form = $this->createForm(StockDiversType::class, $stockDiver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stockDiver);
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_divers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stock_divers/new.html.twig', [
            'stock_diver' => $stockDiver,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_divers_show', methods: ['GET'])]
    public function show(StockDivers $stockDiver): Response
    {
        return $this->render('stock_divers/show.html.twig', [
            'stock_diver' => $stockDiver,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stock_divers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StockDivers $stockDiver, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StockDiversType::class, $stockDiver);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stock_divers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stock_divers/edit.html.twig', [
            'stock_diver' => $stockDiver,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stock_divers_delete', methods: ['POST'])]
    public function delete(Request $request, StockDivers $stockDiver, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stockDiver->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stockDiver);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stock_divers_index', [], Response::HTTP_SEE_OTHER);
    }
}
