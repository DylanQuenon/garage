<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Form\CarsType;
use App\Repository\CarsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarsController extends AbstractController
{
    #[Route("/cars/new", name:"cars_create")]
    public function create():Response{
        $cars=new Cars();
        $form = $this->createForm(CarsType::class, $cars);
        return $this->render("cars/new.html.twig",[
        
            'myForm' => $form->createView()
        ]);
    }
    #[Route('/cars', name: 'cars_index')]
    public function index(CarsRepository $repo): Response
    {
        $cars=$repo->findAll();
        return $this->render('cars/index.html.twig', [
            'cars' => $cars,
        ]);
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
