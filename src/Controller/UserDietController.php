<?php

namespace App\Controller;

use App\Services\IngestionService;
use App\Services\UserDayService;
use App\Services\UserDietService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserDietController extends AbstractController
{
    /**
     * @Route("/profile/diet", name="profile.diet")
     */
    public function diet(Request $request, UserDietService $userDietService, UserDayService $dayService)
    {
        $user = $this->getUser();

        $today = new \DateTime('now');

        $startDay = $userDietService->getStartDay($request, $today);
        $lastDay = $userDietService->getLastDay($startDay);

        $prevDate = $userDietService->prevDay($startDay);
        $nextDate = $userDietService->nextDay($startDay);

        $week = [];
        for (; $startDay < $lastDay; $startDay->modify('+1 day')) {
            $day = $dayService->searchDayByDate($startDay, $user->getUserDiet());
            if (empty($day)){
                $week[] = [
                    'date' => (new \DateTime())->setTimestamp($startDay->getTimestamp()),
                ];
            } else {
                $week[] = $day[0];
            }
        }

        return $this->render('user_diet/index.html.twig', [
            'today' => $today,
            'week' => $week,
            'prevDate' => $prevDate,
            'nextDate' => $nextDate
        ]);
    }

    /**
     * @Route("/profile/ingestions", name="profile.ingestions")
     */
    public function ingestions(Request $request,
                               IngestionService $ingestionService,
                               UserDietService $userDietService)
    {
        $user = $this->getUser();

        $requestIngestion = $request->request->get('ingestion-select');
        if($requestIngestion) {
            $userDietService->addAllRequestIngestion(
                $user->getUserDiet(),
                $requestIngestion,
                $ingestionService);
            $this->addFlash('success', 'Ingestion changed successfully');
        }

        if ($user->getUserDiet()->getIngestions()->count() == 0) {
            $userDietService->addAllIngestion(
                $user->getUserDiet()                ,
                $ingestionService);
        }

        $ingestions = $ingestionService->getAllIngestions();

        return $this->render('user_diet/ingestions.html.twig', [
            'user' => $user,
            'ingestions' => $ingestions
        ]);
    }

}
