<?php

namespace App\Controller;


use App\Service\Maillingservice;


use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;

use App\Service\Messageservice;
use App\Service\pdfservice;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(Request $request,ReclamationRepository $reclamationRepository): Response
    {

        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
    #[Route('/pdf', name: 'pdf')]
    public function generatePdfRec(pdfService $pdf, ReclamationRepository $reclamationRepository) {
        $reclamation1 = $reclamationRepository->findAll();

        $html = $this->renderView('basepdf.html.twig', [
            'rec' => $reclamation1,
        ]);

        $outputFile = tempnam(sys_get_temp_dir(), 'Listes').'.pdf';

        $pdfFilePath = $pdf->generatePdfFile($html, $outputFile);

        $pdfFileName = pathinfo($pdfFilePath, PATHINFO_FILENAME).'.pdf';
        $pdfFileNameWithPath = sys_get_temp_dir().'/'.$pdfFileName;
        rename($pdfFilePath, $pdfFileNameWithPath);

        return $this->file($pdfFileNameWithPath, 'Listes.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }
    #[Route('/newReclamation', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }


    #[Route('/Stat', name: 'app_reclamation_stat')]
    public function statisticsAction(ReclamationRepository $reclamationRepository): Response
    {
        $statsPie = $reclamationRepository->getTypeRecCount();


        return $this->render('reclamation/stat.html.twig', [
            'statsPie' => json_encode($statsPie), // Pass data to Twig as JSON
        ]);
    }
    #[Route('/Adm', name: 'app_reclamation_indexAdmin', methods: ['GET'])]
    public function indexAdmin(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('reclamation/indexAdmin.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
    #[Route('/calendar', name: 'app_calendar')]
    public function displayCalendar(ReclamationRepository $reclamationRepository): Response
    {
        $reclamations = $reclamationRepository->findAll(); // Fetch all reclamation data

        return $this->render('reclamation/cala.html.twig', [
            'reclamations' => json_encode($reclamations), // Pass reclamation data to Twig as JSON
        ]);
    }



    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    /**
     * @param Reclamation $reclamation
     * @param Maillingservice $mailerService
     * @param Messageservice $messageService
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     */
    #[Route('/{id}/SendReclamation', name: 'app_reclamation_send', methods: ['GET'])]
    public function sendReclamationByMail(reclamationRepository $reclamationRepository,Reclamation $reclamation , Maillingservice $mailerService, Messageservice $messageService)
    {
        $mailerService->send(
            "Tache" ."  " . $reclamation->getUrgency(),
            "hadil03sghair@gmail.com", ///  $reclamation->getTarget !!!!!!!change it to the target
            "hadil.sghair@esprit.tn",
            "reclamation/mail.html.twig",
            [
                "REC_EMP"=>$reclamation->getRecEmp(),
                "REC_DATE"=>$reclamation->getRecDate(),
                "REC_DESCRIPTION"=>$reclamation->getRecDescription(),
                "REC_TARGET"=>$reclamation->getRecTarget(),
                "URGENCY"=>$reclamation->getUrgency(),
                "type_Rec"=>$reclamation->getTypeRec()->getType(),
            ]

        );
        $messageService->addSuccess(' Votre mail a bien eté envoyer');
        return $this->render('reclamation/indexAdmin.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
        ]);
    }
    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }

}
