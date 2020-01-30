<?php

namespace App\Controller;

use App\Services\IngestionService;
use App\Services\UserDietService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserDietController extends AbstractController
{
    /**
     * @Route("/profile/diet", name="profile.diet")
     */
    public function diet(Request $request, UserDietService $userDietService, IngestionService $ingestionService)
    {
        $user = $this->getUser();

        $today = new \DateTime('now');

        $startDay = $userDietService->getStartDay($request, $today);
        $lastDay = $userDietService->getLastDay($startDay);

        $prevDate = $userDietService->prevDay($startDay);
        $nextDate = $userDietService->nextDay($startDay);

        $week = [];
        for (; $startDay < $lastDay; $startDay->modify('+1 day')) {
            $week[] = [
                'day' => $startDay->format('d \of\ F, D'),
                'date' => (new \DateTime())->setTimestamp($startDay->getTimestamp()),
                'ingestions' => $userDietService->getIngestionsOfDate(
                    (new \DateTime())->setTimestamp($startDay->getTimestamp()),
                    $today,
                    $user->getUserDiet()
                )
            ];
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
                $user->getUserDiet(),
                $ingestionService->getAllIngestionsArray(),
                $ingestionService);
        }

        $ingestions = $ingestionService->getAllIngestions();

        return $this->render('user_diet/ingestions.html.twig', [
            'user' => $user,
            'ingestions' => $ingestions
        ]);
    }

}
