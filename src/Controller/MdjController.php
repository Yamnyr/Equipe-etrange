<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ClasseRepository;
use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MdjController extends AbstractController
{
    #[Route('/mdj', name: 'app_mdj')]
    public function index(Security $security): Response
    {
        $user = $this->getUser();

        $classe = $user ? $user->getClasse() : null;
        $mdj = $classe ? $classe->getMdj() : null;

        return $this->render('mdj/index.html.twig', [
            'mdj' => $mdj,
        ]);
    }
}
