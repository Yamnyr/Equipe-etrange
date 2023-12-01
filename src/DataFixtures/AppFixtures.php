<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Mission;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $password
    ){
    }
    public function load(ObjectManager $manager): void
    {


        // Création d'une classe
        $classe1 = new Classe();
        $classe1->setNom('Enseignants');
        $classe1->setImage('images/enseignants.png');
        $classe1->setDescription('Les enseignants.');
        $manager->persist($classe1);

        $classe2 = new Classe();
        $classe2->setNom('Elèves');
        $classe2->setImage('images/eleves.png');
        $classe2->setDescription('Les élèves.');
        $manager->persist($classe2);

        $classe3 = new Classe();
        $classe3->setNom('Administration');
        $classe3->setImage('images/administration.png');
        $classe3->setDescription('L\'administration.');
        $manager->persist($classe3);


        $user1 = new User();
        $user1->setEmail('eleves@admin');
        $user1->setPv(3);
        $user1->setRoles(array('ROLE_ADMIN'));
        $user1->setPassword(
            $this->password->hashPassword(
                $user1,
                'eleves.admin'
            )
        );
        $user1->setClasse($classe2);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('enseignants@admin');
        $user2->setPv(3);
        $user2->setRoles(array('ROLE_ADMIN'));
        $user2->setPassword(
            $this->password->hashPassword(
                $user2,
                'enseignants.admin'
            )
        );
        $user2->setClasse($classe1);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setEmail('admin@admin');
        $user3->setPv(3);
        $user3->setRoles(array('ROLE_ADMIN'));
        $user3->setPassword(
            $this->password->hashPassword(
                $user3,
                'admin.admin'
            )
        );
        $user3->setClasse($classe3);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setEmail('eleves@user');
        $user4->setPv(3);
        $user4->setPassword(
            $this->password->hashPassword(
                $user1,
                'eleves.user'
            )
        );
        $user4->setClasse($classe1);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setEmail('enseignants@user');
        $user5->setPv(3);
        $user5->setPassword(
            $this->password->hashPassword(
                $user2,
                'enseignants.user'
            )
        );
        $user5->setClasse($classe2);
        $manager->persist($user5);

        $user6 = new User();
        $user6->setEmail('admin@user');
        $user6->setPv(3);
        $user6->setPassword(
            $this->password->hashPassword(
                $user3,
                'admin.user'
            )
        );
        $user6->setClasse($classe3);
        $manager->persist($user6);

        

        $mission1 = new Mission();
        $mission1->setNom('Concevoir des leçons innovantes :');
        $mission1->setDescription('Créer et planifier 3 leçons stimulantes qui intègrent des approches pédagogiques novatrices.');
        $mission1->setClasse($classe1);
        $manager->persist($mission1);

        $mission2 = new Mission();
        $mission2->setNom('Évaluer des copies :');
        $mission2->setDescription('Examiner et évaluer 20 copies d\'examens pour fournir des retours constructifs aux élèves.');
        $mission2->setClasse($classe1);
        $manager->persist($mission2);
        
        $mission3 = new Mission();
        $mission3->setNom('Organiser un débat éducatif :');
        $mission3->setDescription('Faciliter un débat entre les élèves sur un sujet d\'actualité, encourageant la pensée critique.');
        $mission3->setClasse($classe1);
        $manager->persist($mission3);

        $mission4 = new Mission();
        $mission4->setNom('Mettre un 20/20 au groupe 3 :');
        $mission4->setDescription('Mettre un 20/20 sur le projet du groupe 3 (svp) #lesmeilleurs.');
        $mission4->setClasse($classe1);
        $manager->persist($mission4);
        
        $mission5 = new Mission();
        $mission5->setNom('Répondre aux courriels étudiants :');
        $mission5->setDescription('Répondre aux questions des étudiants et fournir des conseils personnalisés par le biais de la correspondance électronique.');
        $mission5->setClasse($classe1);
        $manager->persist($mission5);
        
        $mission6 = new Mission();
        $mission6->setNom('Participer aux activités d\'apprentissage collaboratif :');
        $mission6->setDescription('Participer activement à 3 activités en groupe pour favoriser la collaboration et l\'apprentissage mutuel.');
        $mission6->setClasse($classe2);
        $manager->persist($mission6);
        
        $mission7 = new Mission();
        $mission7->setNom('Explorer de nouveaux sujets :');
        $mission7->setDescription('Se plonger dans 2 sujets nouveaux ou inexplorés pour stimuler la curiosité intellectuelle.');
        $mission7->setClasse($classe2);
        $manager->persist($mission7);
        
        $mission8 = new Mission();
        $mission8->setNom('Présenter un projet créatif :');
        $mission8->setDescription('Concevoir et présenter un projet créatif démontrant la compréhension approfondie d\'un concept.');
        $mission8->setClasse($classe2);
        $manager->persist($mission8);
        
        $mission9 = new Mission();
        $mission9->setNom('Rédiger des article :');
        $mission9->setDescription('Écrire deux articles sur des sujets choisis pour développer la capacité à communiquer de manière claire et concise.');
        $mission9->setClasse($classe2);
        $manager->persist($mission9);

        $mission10 = new Mission();
        $mission10->setNom('Arriver à l\'heure :');
        $mission10->setDescription('Tout simplement.');
        $mission10->setClasse($classe2);
        $manager->persist($mission10);

        $mission11 = new Mission();
        $mission11->setNom('Organiser une réunion de planification :');
        $mission11->setDescription("Coordonner les activités pédagogiques du mois en cours, définir les priorités et allouer les ressources nécessaires.");
        $mission11->setClasse($classe3);
        $manager->persist($mission11);

        $mission12 = new Mission();
        $mission12->setNom('Évaluer les performances des élèves :');
        $mission12->setDescription("Examiner et noter 10 travaux des élèves, identifier les besoins individuels et préparer des rapports de progrès.");
        $mission12->setClasse($classe3);
        $manager->persist($mission12);

        $mission13 = new Mission();
        $mission13->setNom('Répondre aux demandes des parents :');
        $mission13->setDescription("Répondre à 20 parents, fournir des informations sur le progrès académique de leurs enfants et offrir un soutien en cas de besoin.");
        $mission13->setClasse($classe3);
        $manager->persist($mission13);

        $mission14 = new Mission();
        $mission14->setNom('Coordonner un atelier pédagogique :');
        $mission14->setDescription("Effectuer une session de développement professionnel pour partager les meilleures pratiques pédagogiques, introduire de nouvelles méthodologies et renforcer les compétences des enseignants.");
        $mission14->setClasse($classe3);
        $manager->persist($mission14);

        $mission15 = new Mission();
        $mission15->setNom('Analyser les dossiers scolaires :');
        $mission15->setDescription("Examiner 10 dossiers de performance scolaire, identifier les problèmes, et proposer des ajustements stratégiques pour améliorer l'apprentissage des élèves.");
        $mission15->setClasse($classe3);
        $manager->persist($mission15);


        $manager->flush();
    }
}
