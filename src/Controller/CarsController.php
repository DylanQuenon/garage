<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarsType;
use App\Repository\CarsRepository;
use App\Service\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarsController extends AbstractController
{
    #[Route("/cars/new", name:"cars_create")]
    public function create(Request $request, EntityManagerInterface $manager): Response{
        $cars=new Cars();
        $form = $this->createForm(CarsType::class, $cars);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            foreach($cars->getImages() as $image)
            {
                $image->setCars($cars);
                $manager->persist($image);
            }
     
            $manager->persist($cars);
       
            $manager->flush();

            $this->addFlash('success', "L'annonce <strong>".$cars->getNom()."</strong> a bien été enregistrée");

            return $this->redirectToRoute('cars_show',[
                'slug' => $cars->getSlug()
            ]);

        }

        return $this->render("cars/new.html.twig",[
        
            'myForm' => $form->createView()
        ]);


    }
    /**
     * Permet d'éditer une voiture
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Cars $cars
     * @return Response
     */
    #[Route('/cars/{slug}/edit', name:"cars_edit")]
    public function edit(Request $request, EntityManagerInterface $manager, Cars $cars): Response
    {
        $form = $this->createForm(CarsType::class, $cars);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            // si je veux que le slug soit automatique 
            // $ad->setSlug("");

              // gestion des images 
              foreach($cars->getImages() as $image)
              {
                  $image->setCars($cars);
                  $manager->persist($image);
              }

              $manager->persist($cars);
              $manager->flush();

              $this->addFlash(
                'success',
                "L'annonce <strong>".$cars->getNom()."</strong> a bien été modifiée!"
              );

              return $this->redirectToRoute('cars_show',[
                'slug' => $cars->getSlug()
              ]);

        }
        return $this->render("cars/edit.html.twig", [
            "cars" => $cars,
            "myForm" => $form->createView()
        ]);
        
    }
    #[Route('/cars/{page<\d+>?1}', name: 'cars_index')]
    public function index(CarsRepository $repo,$page,PaginationService $pagination): Response
    {
        $pagination->setEntityClass(Cars::class)
                    ->setPage($page);
        return $this->render('cars/index.html.twig', [
            'pagination' => $pagination
        ]);
        dump($pagination);
    }


    #[Route("/cars/{slug}", name:"cars_show")]
    public function show(string $slug, Cars $car): Response
    {
        // $ad = $repo->findby(["slug"=>$slug])

        return $this->render("cars/show.html.twig", [
            'car' => $car
        ]);
    }
}
