<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\TaskStatus;
use App\Form\Task1Type;
use App\Form\TaskFilterType;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;

#[Route('/AdminDashboard/task')]
class TaskController extends AbstractController
{
  #[Route('/', name: 'app_task_index', methods: ['GET'])]
  public function index(TaskRepository $taskRepository , Request $request): Response
  {

    $filters = $request->query->all();
    $form = $this->createForm(TaskFilterType::class);
    if(isset($filters['task_filter'])){
      // $form->setData($filters['task_filter']);
    }
    $form->handleRequest($request);

    $tasks = $taskRepository->findByFilters($filters);

    return $this->render('task/back/index.html.twig', [
        'tasks' => $tasks,
        'form' => $form->createView(),
    ]);
    
  }

  #[Route('/all', name: 'app_task_index_all', methods: ['GET'])]
  public function index2(TaskRepository $taskRepository , Request $request): Response
  {
      return $this->render('task/front/index.html.twig', [
          'tasks' => $taskRepository->findAll(),
      ]);
  }

  #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
  public function new(Request $request , MailerInterface $mailer): Response
  {
    $task = new Task();
    $form = $this->createForm(Task1Type::class, $task);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

      foreach ($task->getTodos() as $todo) {
        $todo->setParentTask($task);
      }

      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($task);
      $entityManager->flush();

      
        
       // Prepare email content
        $email = (new TemplatedEmail())
        ->from('tbagheiyth@gmail.com')
        ->to($task->getAssignedChef()->getUserEmail())
        ->subject('New Task Created')
        ->htmlTemplate('email/task_created.html.twig')
        ->context([
            'task' => $task, // Pass the newly created task to the template
        ]);

        // Send the email
        $mailer->send($email);

      return $this->redirectToRoute('app_task_show', ['id' => $task->getId()]);
    }

    return $this->render('task/back/new.html.twig', [
      'form' => $form->createView(),
      'button_label'=>'Add task'
    ]);
  }

  #[Route('/export', name: 'app_task_export')]
  public function exportTasks(TaskRepository $taskRepository): BinaryFileResponse
    {
        // Get all tasks from the repository
        $tasks = $taskRepository->findAll();

        // Create a new spreadsheet instance
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Task Title');
        $sheet->setCellValue('C1', 'Creation Date');
        $sheet->setCellValue('D1', 'Deadline');
        $sheet->setCellValue('E1', 'Status');

        // Add more columns for other properties if needed

        // Populate tasks data
        $row = 2;
        foreach ($tasks as $task) {
            $sheet->setCellValue('A' . $row, $task->getId());
            $sheet->setCellValue('B' . $row, $task->getTaskTitle());
            $sheet->setCellValue('C' . $row, $task->getCreationDate()->format('Y-m-d'));
            $sheet->setCellValue('D' . $row, $task->getDeadline()->format('Y-m-d'));
            $sheet->setCellValue('E' . $row, $task->getStatus()->value);
            // Add more cells for other properties if needed

            $row++;
        }

        // Create the Excel file
        $writer = new Xlsx($spreadsheet);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'tasks_') . '.xlsx';
        $writer->save($tempFilePath);

        // Create a response with the Excel file
        $response = new BinaryFileResponse($tempFilePath);
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'tasks_export.xlsx'
        );

        // Return the response to download the file
        return $response;
    }

  #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
  public function show(Task $task): Response
  {
    return $this->render('task/back/show.html.twig', [
      'task' => $task,
    ]);
  }

  #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
  public function edit(Request $request,$id, Task $task, EntityManagerInterface $entityManager , MailerInterface $mailer): Response
  {
    if (null === $task) {
      throw $this->createNotFoundException('No task found for id '.$id);
  }

  $originalTodos = new ArrayCollection();

  // Create an ArrayCollection of the current Tag objects in the database
  foreach ($task->getTodos() as $todo) {
      $originalTodos->add($todo);
  }

  $editForm = $this->createForm(Task1Type::class, $task);

  $editForm->handleRequest($request);

  if ($editForm->isSubmitted() && $editForm->isValid()) {
      // remove the relationship between the tag and the Task

      foreach ($task->getTodos() as $todo) {
        $todo->setParentTask($task);
      }

      foreach ($originalTodos as $todo) {
          if (false === $task->getTodos()->contains($todo)) {
              // remove the Task from the Tag
              $todo->getTasks()->removeTodo($task);

              // if it was a many-to-one relationship, remove the relationship like this
              $todo->setParentTask(null);

              $entityManager->persist($todo);

              // if you wanted to delete the Tag entirely, you can also do that
              $entityManager->remove($todo);
          }
      }

      $entityManager->persist($task);
      $entityManager->flush();

      // Prepare email content
      $email = (new TemplatedEmail())
      ->from('tbagheiyth@gmail.com')
      ->to($task->getAssignedChef()->getUserEmail())
      ->subject('Task updated')
      ->htmlTemplate('email/task_updated.html.twig')
      ->context([
          'task' => $task, // Pass the newly created task to the template
      ]);

      // Send the email
      $mailer->send($email);

      // redirect back to some edit page
      return $this->redirectToRoute('app_task_show', ['id' => $task->getId()]);
  }
    return $this->renderForm('task/back/edit.html.twig', [
      'task' => $task,
      'form' => $editForm,
      'button_label'=>'Update task'
    ]);
  }

  #[Route('/{id}', name: 'app_task_delete', methods: ['POST'])]
  public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
  {
    if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token'))) {
      $entityManager->remove($task);
      $entityManager->flush();
    }

    return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
  }

  #[Route('/update_task_status/{id}', name: 'update_task_status', methods: ['POST'])]
  public function updateTaskStatus($id, Request $request, TaskRepository $taskRepository, EntityManagerInterface $entityManager): Response
  {   
   
      $task = $taskRepository->find($id);
      
      if (!$task) {
          return new JsonResponse(['error' => 'Task not found'], JsonResponse::HTTP_NOT_FOUND);
      }
  
      $newStatus = $request->request->get('newStatus');
      $newStatus="Completed";
      // Update the status as needed
      $task->setStatus(TaskStatus::COMPLETED);
      $entityManager->persist($task);
      $entityManager->flush();
  
      return $this->redirectToRoute('app_task_index_all', [], Response::HTTP_SEE_OTHER);
  }

  

}
