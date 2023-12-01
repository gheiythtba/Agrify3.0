<?php

namespace App\Controller;

use App\Entity\AnimalStock;
use App\Form\AnimalStockType;
use App\Repository\AnimalStockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route; 
use App\Service\PdfService;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Knp\Component\Pager\PaginatorInterface;





#[Route('/animal/stock')]
class AnimalStockController extends AbstractController
{
    #[Route('/', name: 'app_animal_stock_index', methods: ['GET'])]
    public function index(AnimalStockRepository $animalStockRepository, PaginatorInterface $paginator, Request $request): Response
{
    // Récupérez les critères de recherche depuis la requête
    $nomAnimal = $request->query->get('nomAnimal');
    $sexeAnimal = $request->query->get('sexeAnimal');

    // Créez un tableau de critères à passer à la méthode de recherche
    $criteria = [
        'nomAnimal' => $nomAnimal,
        'sexeAnimal' => $sexeAnimal,
        // Ajoutez d'autres critères ici en fonction de vos besoins
    ];

    // Utilisez la méthode de recherche du repository avec les critères
    $animalStocks = $animalStockRepository->filterAnimalStocks($criteria);

    // Créez la requête pour la pagination avec les critères
    $query = $animalStockRepository->createQueryBuilder('a')
        ->where('a.nomAnimal LIKE :nomAnimal')
        ->setParameter('nomAnimal', '%' . $nomAnimal . '%')
        ->andWhere('a.sexeAnimal = :sexeAnimal')
        ->setParameter('sexeAnimal', $sexeAnimal)
        ->getQuery();

    // Paginez les résultats avec la requête
    $pagination = $paginator->paginate(
        $query, /* query NOT result */
        $request->query->getInt('page', 1), /* page number */
        2 /* limit per page */
    );

    // Passez les résultats paginés à la vue
    return $this->render('animal_stock/index.html.twig', [
        'animal_stocks' => $pagination,
    ]);
}

    #[Route('/search', name: 'app_animal_stock_search', methods: ['POST'])]
public function search(Request $request, AnimalStockRepository $animalStockRepository): JsonResponse
{
    $searchTerm = $request->request->get('search');
    $animalStocks = $animalStockRepository->findBySearchTerm($searchTerm);

    $data = $this->renderView('animal_stock/animal_stocks_table.html.twig', [
        'animal_stocks' => $animalStocks,
    ]);

    return $this->json(['html' => $data]);
}



    #[Route('/pdf', name: 'app_animal_stock.pdf')]
    public function generatePdfAnimalStock(AnimalStock $animalStock = null, PdfService $pdf, AnimalStockRepository $animalStockRepository) {
        $animalStocks = $animalStockRepository->findAllWithSelectedColumns();

        $html = $this->renderView('animal_stock/pdf_template.html.twig', [
            'animal_stocks' => $animalStocks,
        ]);

        $outputFile = tempnam(sys_get_temp_dir(), 'Listes').'.pdf';

        $pdfFilePath = $pdf->generatePdfFile($html, $outputFile);

        $pdfFileName = pathinfo($pdfFilePath, PATHINFO_FILENAME).'.pdf';
        $pdfFileNameWithPath = sys_get_temp_dir().'/'.$pdfFileName;
        rename($pdfFilePath, $pdfFileNameWithPath);

         return $this->file($pdfFileNameWithPath, 'Listes.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }

    #[Route('/stockevolution', name: 'app_animal_stock_evolution', methods: ['GET'])]
    public function stockEvolution(AnimalStockRepository $animalStockRepository): Response
    {
        $stockEvolutionData = $animalStockRepository->getStockEvolutionData();

        return $this->render('animal_stock/stats.html.twig', [
            'stockEvolutionData' => json_encode($stockEvolutionData),
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