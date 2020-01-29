<?php
namespace App\Controller;

use App\Form\IngestionType;
use App\Services\IngestionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IngestionController extends AbstractController
{
    /**
     * @Route("/admin/ingestion/create", name="admin.ingestion.create")
     */
    public function addIngestion(Request $request, IngestionService $ingestionService)
    {
        $ingestionForm = $this->createForm(IngestionType::class);
        $ingestionForm->handleRequest($request);

        if ($ingestionForm->isSubmitted() && $ingestionForm->isValid()) {
            $ingestionService->addIngestion($ingestionForm);
            $this->addFlash('success', 'Ingestion added successfully');
            return $this->redirectToRoute('admin.ingestion');
        }

        return $this->render('admin/ingestion/create.html.twig', [
            'createForm' => $ingestionForm->createView(),
            'title' => 'Create ingestion'
        ]);
    }


    /**
     * @Route("/admin/ingestion", name="admin.ingestion")
     */
    public function showIngestions(IngestionService $ingestionService)
    {
        $ingestions = $ingestionService->getAllIngestions();

        return $this->render('admin/ingestion/show.html.twig', [
            'ingestions' => $ingestions
        ]);
    }

    /**
     * @Route("/admin/ingestion/{id}/edit", name="admin.ingestion.edit")
     */
    public function editIngestion(int $id, Request $request, IngestionService $ingestionService)
    {
        $ingestion = $ingestionService->findById($id);

        $ingestionForm = $this->createForm(IngestionType::class, $ingestion);
        $ingestionForm->handleRequest($request);

        if ($ingestionForm->isSubmitted() && $ingestionForm->isValid()) {
            $ingestionService->editIngestion($ingestionForm, $ingestion);
            $this->addFlash('success', 'Ingestion edited successfully');
            return $this->redirectToRoute('admin.ingestion');
        }

        return $this->render('admin/ingestion/create.html.twig', [
            'createForm' => $ingestionForm->createView(),
            'title' => 'Edit ingestion'
        ]);
    }

    /**
     * @Route("/admin/ingestion/{id}/delete", name="admin.ingestion.delete")
     */
    public function deleteIngestion(int $id, IngestionService $ingestionService)
    {
        if ($ingestionService->deleteIngestion($id)) {
            return $this->redirectToRoute('admin.ingestion');
        }
        throw new \Exception('Delete ingestion failed.');
    }
}