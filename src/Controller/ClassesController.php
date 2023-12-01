<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassesController extends AbstractController
{
    #[Route('/', name: 'app_classes')]
    public function index(ClasseRepository $classeRepository): Response
    {
        $classes = $classeRepository->findAll();

        return $this->render('classes/index.html.twig', [
            'classes' => $classes,
        ]);
    }
}
