<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use App\Repository\HistoriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassesController extends AbstractController
{
    #[Route('/', name: 'app_classes')]
    public function index(ClasseRepository $classeRepository, HistoriqueRepository $historiqueRepository): Response
    {
        $classes = $classeRepository->findAll();
//        $historiqueCounts = $historiqueRepository->countSuccessfulMissionsForClass(2);



        $historiqueCounts=$historiqueRepository->countSuccessfulMissionsForClass2();
        return $this->render('classes/index.html.twig', [
            'classes' => $classes,
            'historiqueCounts' => $historiqueCounts
        ]);
    }
}
