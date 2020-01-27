<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursesController extends AbstractController
{
    /**
     * @Route("/", name="courses")
     */
    public function index(): Response
    {
        return $this->render('courses/index.html.twig', [

        ]);
    }

    /**
     * @Route("/admin/create", name="admin.create")
     */
    public function createCourse(): Response
    {
        return $this->render('admin/courses/create.courses.html.twig', [
        ]);
    }
}
