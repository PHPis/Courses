<?php
namespace App\Controller;

use App\Entity\Meal;
use App\Form\MealType;
use App\Services\IngestionService;
use App\Services\MealService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MealController extends AbstractController
{
    /**
     * @Route("/admin/meal/create", name="admin.meal.create")
     */
    public function createMeal(Request $request, MealService $mealService)
    {
        $meal = new Meal();

        $mealForm = $this->createForm(MealType::class, $meal);
        $mealForm->handleRequest($request);

        if ($mealForm->isSubmitted() && $mealForm->isValid()) {
            $mealService->createMeal($mealForm, $this->getUser());
            $this->addFlash('success', 'Meal added successfully');
            return $this->redirectToRoute('admin.meal');
        }

        return $this->render('admin/meal/create.html.twig', [
            'mealForm' => $mealForm->createView(),
            'title' => 'Create meal'
        ]);
    }

    /**
     * @Route("/admin/meal/{id}/edit", name="admin.meal.edit")
     */
    public function editMeal(int $id, MealService $mealService, Request $request)
    {
        $meal = $mealService->findById($id);

        $mealForm = $this->createForm(MealType::class, $meal);
        $mealForm->handleRequest($request);

        if ($mealForm->isSubmitted() && $mealForm->isValid()) {
            $mealService->editMeal($mealForm, $meal);
            $this->addFlash('success', 'Meal edited successfully');
            return $this->redirectToRoute('admin.meal');
        }

        return $this->render('admin/meal/create.html.twig', [
            'mealForm' => $mealForm->createView(),
            'title' => 'Edit meal'
        ]);
    }

    /**
     * @Route("/admin/meal", name="admin.meal")
     */
    public function showMeals(MealService $mealService, IngestionService $ingestionService, Request $request)
    {
        $meals = $mealService->getAllMeal();
        $ingestions = $ingestionService->getAllIngestions();

        $nameMeal = $request->query->get('name');
        $idIngestion = $request->query->get('ingestion-select');

        if ($nameMeal || $idIngestion) {
            $meals = $mealService->searchMeal($nameMeal, $idIngestion);
        }

        return $this->render('admin/meal/show.html.twig', [
            'meals' => $meals,
            'ingestions' => $ingestions,
            'idIngestion' => $idIngestion
        ]);
    }
}