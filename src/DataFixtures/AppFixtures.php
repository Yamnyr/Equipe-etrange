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
        $classe1->setNom('alchimistes');
        $classe1->setImage('images/alchimistes.png');
        $manager->persist($classe1);

        $classe2 = new Classe();
        $classe2->setNom('aventuriers');
        $classe2->setImage('images/aventuriers.png');
        $manager->persist($classe2);

        $classe3 = new Classe();
        $classe3->setNom('enchanteurs');
        $classe3->setImage('images/enchanteurs.png');
        $manager->persist($classe3);

        $classe4 = new Classe();
        $classe4->setNom('erudits');
        $classe4->setImage('images/erudits.png');
        $manager->persist($classe4);


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
        $mission1->setNom('Éradication des Gobelin');
        $mission1->setDescription('Eliminer 20 ennemies appartenant à la faction des Gobelins.');
        $mission1->setClasse($classe2);
        $manager->persist($mission1);

        $mission2 = new Mission();
        $mission2->setNom('Chasse au Dragon');
        $mission2->setDescription('Eliminer le dragon qui terrorise le village (peut être effectué à plusieurs).');
        $mission2->setClasse($classe2);
        $manager->persist($mission2);

        $mission3 = new Mission();
        $mission3->setNom('Traduction des Écritures Antiques');
        $mission3->setDescription("Décoder et traduire des parchemins anciens pour comprendre les secrets d'une civilisation perdue.");
        $mission3->setClasse($classe4);
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
