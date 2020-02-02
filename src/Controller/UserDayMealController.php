<?php

namespace App\Controller;

use App\Services\IngestionService;
use App\Services\MealService;
use App\Services\UserDayService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserDayMealController extends AbstractController
{
    /**
     * @Route("/profile/diet/day/{dayId}/{ingestionId}", name="profile.diet.day.meal.create")
     */
    public function formDayMeal(int $dayId, int $ingestionId, Request $request,
                                IngestionService $ingestionService,
                                UserDayService $userDayService,
                                MealService $mealService)
    {
        $day = $userDayService->findById($dayId);
        $ingestion = $ingestionService->findById($ingestionId);

        $mealName = $request->query->get('meal');
        $meals = $mealService->searchMeal($mealName?$mealName:'', [$ingestion]);
        return $this->render('user_day_meal/add.html.twig', [
            'day' => $day,
            'ingestion' => $ingestion,
            'meals' => $meals
        ]);
    }
}
