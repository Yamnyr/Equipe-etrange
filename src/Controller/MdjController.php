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


        // If $mdj is null, let's find a mission related to the class and assign it as the $mdj
        if ($mdj === null) {

            $relatedMission = $missionRepository->findOneBy(['classe' => $classe]);
            // Assuming $relatedMission is the mission you want to assign as $mdj
            if ($relatedMission !== null) {
                $classe->setMdj($relatedMission);
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
