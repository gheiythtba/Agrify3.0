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
use App\Service\PdfService;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

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

    #[Route('/pdf', name: 'app_stock_divers.pdf')]
    public function generatePdfStockDivers(StockDivers $stockDivers = null, PdfService $pdf, StockDiversRepository $stockDiversRepository) {
        $stockDivers = $stockDiversRepository->findAllWithSelectedColumns();

        $html = $this->renderView('stock_divers/pdf_template.html.twig', [
            'stock_divers' => $stockDivers,
        ]);

        $outputFile = tempnam(sys_get_temp_dir(), 'Listessd').'.pdf';

        $pdfFilePath = $pdf->generatePdfFile($html, $outputFile);

        $pdfFileName = pathinfo($pdfFilePath, PATHINFO_FILENAME).'.pdf';
        $pdfFileNameWithPath = sys_get_temp_dir().'/'.$pdfFileName;
        rename($pdfFilePath, $pdfFileNameWithPath);

         return $this->file($pdfFileNameWithPath, 'Listessd.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
}

#[Route('/stockevolution', name: 'app_stock_divers_evolution', methods: ['GET'])]
    public function stockEvolution(StockDiversRepository $stockDiversRepository): Response
    {
        $stockEvolutionData = $stockDiversRepository->getStockEvolutionData();

        return $this->render('plante_stock/stats.html.twig', [
            'stockEvolutionData' => json_encode($stockEvolutionData),
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
