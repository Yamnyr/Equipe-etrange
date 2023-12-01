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
        $classe1->setNom('Développement');
        $classe1->setImage('images/developpement.jpg');
        $classe1->setDescription('Les Développeurs.');
        $manager->persist($classe1);

        $classe2 = new Classe();
        $classe2->setNom('Reseaux');
        $classe2->setImage('images/reseaux.jpg');
        $classe2->setDescription('Les Réseaux.');
        $manager->persist($classe2);

        /*$classe3 = new Classe();
        $classe3->setNom('Administration');
        $classe3->setImage('images/administration.png');
        $classe3->setDescription('L\'administration.');
        $manager->persist($classe3);*/


        $user1 = new User();
        $user1->setEmail('dev@admin');
        $user1->setPv(30);
        $user1->setRoles(array('ROLE_ADMIN'));
        $user1->setPassword(
            $this->password->hashPassword(
                $user1,
                'dev.admin'
            )
        );
        $user1->setClasse($classe1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('res@admin');
        $user2->setPv(3);
        $user2->setRoles(array('ROLE_USER'));
        $user2->setPassword(
            $this->password->hashPassword(
                $user2,
                'res.admin'
            )
        );
        $user2->setClasse($classe2);
        $manager->persist($user2);

        /*$user3 = new User();
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
        $manager->persist($user3);*/

        $user4 = new User();
        $user4->setEmail('dev@user');
        $user4->setPv(3);
        $user4->setPassword(
            $this->password->hashPassword(
                $user1,
                'dev.user'
            )
        );
        $user4->setClasse($classe1);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setEmail('res@user');
        $user5->setPv(3);
        $user5->setPassword(
            $this->password->hashPassword(
                $user2,
                'res.user'
            )
        );
        $user5->setClasse($classe2);
        $manager->persist($user5);

        /*$user6 = new User();
        $user6->setEmail('admin@user');
        $user6->setPv(3);
        $user6->setPassword(
            $this->password->hashPassword(
                $user3,
                'admin.user'
            )
        );
        $user6->setClasse($classe3);
        $manager->persist($user6);*/

        

        $mission1 = new Mission();
        $mission1->setNom('Entrée Théâtrale Épique');
        $mission1->setDescription('Fais une entrée théâtrale à chaque fois que tu entres en classe, avec une musique de fond dramatique.');
        $mission1->setClasse($classe1);
        $manager->persist($mission1);

        $mission2 = new Mission();
        $mission2->setNom('Mystère en Classe');
        $mission2->setDescription('Amène un objet mystérieux en classe et refuse de dire ce que c\'est, en créant des théories farfelues à son sujet.');
        $mission2->setClasse($classe1);
        $manager->persist($mission2);
        
        $mission3 = new Mission();
        $mission3->setNom('Célébration Spontanée');
        $mission3->setDescription('Organise une mini-célébration à chaque fois que quelqu\'un prend la parole en classe, avec des applaudissements et des confettis');
        $mission3->setClasse($classe1);
        $manager->persist($mission3);

        $mission4 = new Mission();
        $mission4->setNom('Doigts Claquants Jazz');
        $mission4->setDescription('Commence chaque phrase en claquant des doigts et en disant "Oh, yeah!" à la manière d\'un artiste de jazz.');
        $mission4->setClasse($classe1);
        $manager->persist($mission4);

        $mission5 = new Mission();
        $mission5->setNom('Symphonie Royale en Silence');
        $mission5->setDescription('en cours pendant un silence met l\'opening de clash royal');
        $mission5->setClasse($classe1);
        $manager->persist($mission5);

        $mission5 = new Mission();
        $mission5->setNom('Jeu de Chaises Furtif');
        $mission5->setDescription('Change de place à chaque fois que le professeur détourne le regard, en essayant de ne pas te faire prendre.');
        $mission5->setClasse($classe1);
        $manager->persist($mission5);



        
        $mission6 = new Mission();
        $mission6->setNom('"Arc-en-ciel Éducatif');
        $mission6->setDescription('Écris tous tes cours avec un stylo de couleur différente pour chaque mot.');
        $mission6->setClasse($classe2);
        $manager->persist($mission6);
        
        $mission7 = new Mission();
        $mission7->setNom('Perruque en Fête');
        $mission7->setDescription('Utilise une perruque excentrique pendant toute une journée en classe.');
        $mission7->setClasse($classe2);
        $manager->persist($mission7);
        
        $mission8 = new Mission();
        $mission8->setNom('Le Grand Déplacement');
        $mission8->setDescription('en cours, deplace ta table et ta chaise le plus de fois possible');
        $mission8->setClasse($classe2);
        $manager->persist($mission8);
        
        $mission9 = new Mission();
        $mission9->setNom('Langage XVIIIe Siècle');
        $mission9->setDescription('Utilise uniquement des expressions du 18e siècle pendant toute une journée en classe.');
        $mission9->setClasse($classe2);
        $manager->persist($mission9);

        $mission10 = new Mission();
        $mission10->setNom('Sac Absurde Spectaculaire');
        $mission10->setDescription('vien en cours avec le sac le plus aburde.');
        $mission10->setClasse($classe2);
        $manager->persist($mission10);

        $mission10 = new Mission();
        $mission10->setNom('Citations Célèbres Décalées');
        $mission10->setDescription('Réponds à chaque question avec une citation célèbre, même si elle n\'a aucun lien avec la question posée.');
        $mission10->setClasse($classe2);
        $manager->persist($mission10);

        /*$mission11 = new Mission();
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
        $manager->persist($mission15);*/


        $manager->flush();
    }
}
