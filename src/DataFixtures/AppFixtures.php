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
        $manager->persist($classe1);

        $classe2 = new Classe();
        $classe2->setNom('Elèves');
        $classe2->setImage('images/eleves.png');
        $manager->persist($classe2);

        $classe3 = new Classe();
        $classe3->setNom('Administration');
        $classe3->setImage('images/administration.png');
        $manager->persist($classe3);


        $user1 = new User();
        $user1->setEmail('admin@admin');
        $user1->setPv(3);
        $user1->setRoles(array('ROLE_ADMIN'));
        $user1->setPassword(
            $this->password->hashPassword(
                $user1,
                'test'
            )
        );
        $user1->setClasse($classe2);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('test@test');
        $user2->setPv(3);
        $user2->setPassword(
            $this->password->hashPassword(
                $user2,
                'test'
            )
        );
        $user2->setClasse($classe2);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setEmail('test2@test');
        $user3->setPv(3);
        $user3->setPassword(
            $this->password->hashPassword(
                $user3,
                'test'
            )
        );
        $user3->setClasse($classe3);
        $manager->persist($user3);

        $mission1 = new Mission();
        $mission1->setNom('Mettre un 20/20 au groupe 3 :');
        $mission1->setDescription('Mettre un 20/20 sur le projet du groupe 3 (svp) #lesmeilleurs.');
        $mission1->setClasse($classe1);
        $manager->persist($mission1);

        $mission2 = new Mission();
        $mission2->setNom('Arriver à l\'heure :');
        $mission2->setDescription('Tout simplement.');
        $mission2->setClasse($classe2);
        $manager->persist($mission2);

        $mission3 = new Mission();
        $mission3->setNom('Évaluer les performances des élèves :');
        $mission3->setDescription("Examiner et noter 10 travaux des élèves, identifier les besoins individuels et préparer des rapports de progrès.");
        $mission3->setClasse($classe3);
        $manager->persist($mission3);

        $mission4 = new Mission();
        $mission4->setNom('Animation d\'un Festival Magique');
        $mission4->setDescription("Organiser un festival magique pour divertir la communauté et renforcer les liens sociaux.");
        $mission4->setClasse($classe3);
        $manager->persist($mission4);

        $mission5 = new Mission();
        $mission5->setNom('Création d\'un Élixir de Guérison');
        $mission5->setDescription("Préparer un élixir puissant pour guérir une maladie qui afflige un village voisin.");
        $mission5->setClasse($classe1);
        $manager->persist($mission5);


        $manager->flush();
    }
}
