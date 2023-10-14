<?php

namespace App\Controller;

use App\Entity\Cars;
use App\Repository\CarsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarsController extends AbstractController
{
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
