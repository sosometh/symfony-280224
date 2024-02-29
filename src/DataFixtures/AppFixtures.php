<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\Article;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /*-Créer 30 catégories,
        -Créer 50 Utilisateurs,
        -Créer 200 articles,
        */
        $faker = Faker\Factory::create('fr_FR');
        //créer un tableau pour stocker les catégories
        $categories = [];

        //boucle pour créer 30 catégories
        for ($i = 0; $i < 30; $i++) {
            $cat = new Categorie();
            $cat->setNom($faker->jobTitle());
            //ajouter la catégorie au tableau categories
            $categories[] = $cat;
            //persister la catégorie
            $manager->persist($cat);
        }

        $utilisateurs = [];
        //boucle pour créer 50 utilisateurs
        for ($i = 0; $i < 50; $i++) {
            $user = new Utilisateur();
            $user
                ->setNom($faker->lastName())
                ->setPrenom($faker->firstName('male' | 'female'))
                ->setEmail($faker->freeEmail())
                ->setPassword($faker->md5())
                ->setUrlImage("https://www.wikichat.fr/wp-content/uploads/sites/2/BENGAL.png");
            $utilisateurs[] = $user;
            $manager->persist($user);
        }

        //boucle pour ajouter 200 article
        for ($i = 0; $i < 200; $i++) {
            $article = new Article();
            $article
                ->setTitre($faker->words(3, true))
                ->setContenu($faker->paragraph(2, false))
                ->setDateCreation(new \DateTimeImmutable($faker->date('Y-m-d')))
                ->setUtilisateur($utilisateurs[$faker->numberBetween(0, 49)])
                ->addCategory($categories[$faker->numberBetween(0, 9)])
                ->addCategory($categories[$faker->numberBetween(10, 19)])
                ->addCategory($categories[$faker->numberBetween(20, 29)])
                ->setImageUrl("https://www.sciencesetavenir.fr/assets/img/2022/05/25/cover-r4x3w1200-628e2f6688732-particularites-chien-border-collie.jpg");
            $manager->persist($article);
        }
        $manager->flush();
    }
}