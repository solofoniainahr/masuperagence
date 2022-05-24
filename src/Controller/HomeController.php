<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     * 
     * @param Propertyrepository $propertyRepository
     * @return Response
     */
    public function index(PropertyRepository $propertyRepository): Response
    {
        $lastProperties = $propertyRepository->findLatest();
        return $this->render('home/homepage.html.twig', [
            'current_menu' => 'homepage',
            'properties'   => $lastProperties
        ]);
    }
}
