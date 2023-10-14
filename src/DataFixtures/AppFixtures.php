<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Cars;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();

        for($i=1; $i<=15; $i++)
        {
            $cars = new Cars();
            $nom = $faker->sentence();
            // $slug=$slugify->slugify($nom);
            $coverImage = 'https://picsum.photos/seed/picsum/1000/350';
            $introduction= $faker->paragraph(2);
            $content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>';
            $marque=$faker->sentence();
            $model=$faker->sentence();

           

            $cars->setNom($nom)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(rand(40,200))
                ->setMarque($marque)
                ->setModel($model)
                ->setKm(rand(1,500000));


            $manager->persist($cars);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}