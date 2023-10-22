<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Cars;
use App\Entity\User;
use App\Entity\Images;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $slugify = new Slugify();
        $users = []; // init d'un tableau pour récup des user pour les annonces
        $genres = ['male','femelle'];

        for($u=1 ; $u <= 10; $u++)
        {
            $user = new User();
            $genre = $faker->randomElement($genres);
        

            $hash = $this->passwordHasher->hashPassword($user, 'password');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>')
                ->setPassword($hash)
                ->setPicture('');

            $manager->persist($user);    

            $users[] = $user; // ajouter un user au tableau (pour les annonces)

        }

        for($i=1; $i<=15; $i++)
        {
            $cars = new Cars();
            $nom = $faker->sentence();
            // $slug=$slugify->slugify($nom);
            $coverImage = 'https://picsum.photos/seed/picsum/1000/350';
            $introduction= $faker->paragraph(2);
            $content = '<p>'.join('</p><p>', $faker->paragraphs(5)).'</p>';
            $marque=$faker->sentence();
            $user = $users[rand(0, count($users)-1)];
    

           

            $cars->setNom($nom)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(rand(40,200))
                ->setMarque($marque)
                ->setKm(rand(1,500000))
                ->setAuthor($user);

                for($g=1;$g<=rand(2,5);$g++)
                {
                    $images=new Images();
                    $images->setUrl('https://picsum.photos/id/'.$g.'/900')
                    ->setCaption($faker->sentence())
                    ->setCars($cars);
                    $manager->persist($images);
                }
            $manager->persist($cars);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
