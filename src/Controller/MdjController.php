<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ClasseRepository;
use App\Repository\MissionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MdjController extends AbstractController
{
    #[Route('/mdj', name: 'app_mdj')]
    public function index(Security $security, MissionRepository $missionRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $classe = $user ? $user->getClasse() : null;
        $mdj = $classe ? $classe->getMdj() : null;
        $dateajout = $classe ? $classe->getDateAjout() : null;

        if ($mdj === null || (new \DateTime())->diff($dateajout)->s > 10) {
            $relatedMissions = $missionRepository->findBy(['classe' => $classe]);

            if (!empty($relatedMissions)) {
                $randomKey = array_rand($relatedMissions);
                $randomMission = $relatedMissions[$randomKey];

                $classe->setMdj($randomMission);
                $classe->setDateAjout(new \DateTime());
                $entityManager->persist($classe);
                $entityManager->flush();

                $mdj = $classe->getMdj();
            }
        }


        return $this->render('mdj/index.html.twig', [
            'mdj' => $mdj,
        ]);
    }
}
