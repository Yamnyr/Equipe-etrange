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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MdjController extends AbstractController
{
    private TokenStorageInterface $tokenStorage;
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
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
                    if ($user->getPv() <= 0) {
                        // Delete history entries associated with the user
                        $historiqueRepository->deleteEntriesByUser($user);
                        $this->tokenStorage->setToken(null);
                        // Log out the user before removing and flushing
                        $this->tokenStorage->setToken(null);

                        $entityManager->remove($user);
                        $entityManager->flush();
                        $this->addFlash('danger', "tu n'as plus de point de vies, ton compte à été supprimer");

                        return $this->redirectToRoute('app_logout', [], Response::HTTP_SEE_OTHER);

                    } else {
                        $historique = new Historique();

                        $historique->setUser($user);
                        $historique->setMission($classe->getMdj());
                        $historique->setDateAjoutMdj($classe->getDateAjout());
                        $historique->setResultat(False);

                        $entityManager->persist($historique);

                        $user->setPv($user->getPv() - 1);
                        $entityManager->persist($user);
                        $entityManager->flush();
                    }

                    $entityManager->flush();

                    $this->addFlash('danger', "tu n'as validé ta mission à temps, il te reste: " .$user->getPv()." points de vie");
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
