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

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mdj', name: 'app_mdj')]
    public function index(Security $security, MissionRepository $missionRepository, EntityManagerInterface $entityManager, HistoriqueRepository $historiqueRepository): Response
    {
        $user = $this->getUser();

        $classe = $user ? $user->getClasse() : null;
        $mdj = $classe ? $classe->getMdj() : null;
        $dateajout = $classe ? $classe->getDateAjout() : null;

        $status = false;
        if ($mdj === null || (new \DateTime())->diff($dateajout)->s > 15) {


            $hist = $historiqueRepository->findBy(['user' => $user]);
            //si la mission du jour n'est pas set
            if ($classe !== null && $classe->getMdj() !== null) {

                if (empty($hist) || !$historiqueRepository->doesEntryExist($user, $classe->getMdj(), $classe->getDateAjout())) {
                    $historique = new Historique();

                    $historique->setUser($user);
                    $historique->setMission($classe->getMdj());
                    $historique->setDateAjoutMdj($classe->getDateAjout());
                    $historique->setResultat(False);

                    $entityManager->persist($historique);

                    $user->setPv($user->getPv() - 1);

                    /*$userRepository = $this->entityManager->getRepository(User::class);
                    $usersToDelete = $userRepository->findBy(['pv' => -6]);
            
                    foreach ($usersToDelete as $user) {
                        $this->entityManager->remove($user);
                        
                    }
                    $this->entityManager->flush();
                    //return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);*/

                    $entityManager->persist($user);

                    //echo $user->getPv();

                    $entityManager->flush();

                    $this->addFlash('danger', "tu n'as validé ta mission à temps");
                }
                else{
                    $this->addFlash('réussit', "La mission précédente à bien été validé");
                }
            }

            $relatedMissions = $missionRepository->findBy(['classe' => $classe]);
            if (!empty($relatedMissions)) {
                $randomKey = array_rand($relatedMissions);
                $randomMission = $relatedMissions[$randomKey];

                $classe->setMdj($randomMission);
                $classe->setDateAjout(new \DateTime());
                $entityManager->persist($classe);
                $entityManager->flush();
                $this->addFlash('warning', "mission mis à jour");
            }
        }

        return $this->render('mdj/index.html.twig', [
            'classe' => $classe,
            'status' => $status,
        ]);
    }

    #[Route('/mdj/{id}/valide', name: 'app_mdj_valid')]
    public function add($id, MissionRepository $missionRepository, EntityManagerInterface $entityManager, ClasseRepository $classeRepository, HistoriqueRepository $historiqueRepository): Response
    {
        $user = $this->getUser();

        $classe = $user ? $user->getClasse() : null;
        if (!$historiqueRepository->doesEntryExist($user, $classe->getMdj(), $classe->getDateAjout())) {
            $classe = $classeRepository->find($id);
            $historique = new Historique();

            $historique->setUser($user);
            $historique->setMission($classe->getMdj());
            $historique->setDateAjoutMdj($classe->getDateAjout());
            $historique->setResultat(True);

            $entityManager->persist($historique);
            $entityManager->flush();
            $this->addFlash('réussit', "La mission a été validé");
        }
        else{
            $this->addFlash('réussit', "tu as déja validé cette mission");
        }
        return $this->redirectToRoute('app_mdj', [], Response::HTTP_SEE_OTHER);
    }
}
