<?php

namespace App\Controller;

use App\Services\UserDayService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserDayController extends AbstractController
{
    /**
     * @Route("/profile/diet/day/create", name="user.day.create")
     */
    public function dayCreate(Request $request, UserDayService $userDayService)
    {
        $ingestions = $this->getUser()->getUserDiet()->getIngestions();

        $date = $request->query->get('date');
        if ($date) {
            $date = \DateTime::createFromFormat('Y-d-m', $date);
            $userDayService->create($this->getUser()->getUserDiet(), $date);
            return $this->redirectToRoute('profile.diet');
        }

        return $this->render('user_day/create.html.twig', [
            'date' => $date,
            'ingestions' => $ingestions,
        ]);
    }
}
