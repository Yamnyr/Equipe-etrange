<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\User;
use App\Repository\ClasseRepository;
use App\Repository\HistoriqueRepository;
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
    public function index(Security $security, MissionRepository $missionRepository, EntityManagerInterface $entityManager, HistoriqueRepository $historiqueRepository): Response
    {
        $user = $this->getUser();

        $classe = $user ? $user->getClasse() : null;
        $mdj = $classe ? $classe->getMdj() : null;
        $dateajout = $classe ? $classe->getDateAjout() : null;

        if ($mdj === null || (new \DateTime())->diff($dateajout)->s > 20) {

            //si rien dans historique
            //user perd 1 pv
            //+ajout dans historique ->resultat->0

            $hist = $historiqueRepository->findBy(['user' => $user]);
//            dd($hist);
//            dd($user->getId());
//            dd($hist[0]->getUser()->getId(), $user->getId());
//            dd($classe->getMdj()->getId(), $hist[0]->getMission()->getId());
//            dd($classe->getDateAjout(),$hist[0]->getDateAjoutMdj());

            if (!isset($histe) || $user->getId() !== $hist[0]->getUser()->getId() && $classe->getMdj()->getId() !== $hist[0]->getMission()->getId() && $classe->getDateAjout() !== $hist[0]->getDateAjoutMdj())
                {
                    $historique = new Historique();

                    $historique->setUser($user);
                    $historique->setMission($classe->getMdj());
                    $historique->setDateAjoutMdj($classe->getDateAjout());
                    $historique->setResultat(False);

                    $entityManager->persist($historique);
                    $entityManager->flush();

                }



//si id_user != historique && id mission != hitorique && date_ajout...

            $relatedMissions = $missionRepository->findBy(['classe' => $classe]);
            if (!empty($relatedMissions)) {
                $randomKey = array_rand($relatedMissions);
                $randomMission = $relatedMissions[$randomKey];

                $classe->setMdj($randomMission);
                $classe->setDateAjout(new \DateTime());
                $entityManager->persist($classe);
                $entityManager->flush();

//                $mdj = $classe->getMdj();
//                dd($classe);
            }
        }


        return $this->render('mdj/index.html.twig', [
            'classe' => $classe,
        ]);
    }

    #[Route('/mdj/{id}/valide', name: 'app_mdj_valid')]
    public function add($id, MissionRepository $missionRepository, EntityManagerInterface $entityManager, ClasseRepository $classeRepository,): Response
    {

        $user = $this->getUser();

        $classe = $classeRepository->find($id);
        $historique = new Historique();

        $historique->setUser($user);
        $historique->setMission($classe->getMdj());
        $historique->setDateAjoutMdj($classe->getDateAjout());
        $historique->setResultat(True);

        $entityManager->persist($historique);
        $entityManager->flush();

        return $this->redirectToRoute('app_mdj', [], Response::HTTP_SEE_OTHER);
    }
}
