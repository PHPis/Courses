<?php

namespace App\Controller;

use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="user.profile")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/profile/settings", name="user.profile.settings")
     */
    public function settings(Request $request, UserService $userService)
    {
        $user = $this->getUser();
        if ($request->files->get("photo")){
            $userService->uploadPhoto($user, $request->files->get("photo"));
        }

        return $this->render('user/settings.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
