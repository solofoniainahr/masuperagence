<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="app_property_index")
     */
    public function index(EntityManagerInterface $entityManagerInterface, 
                        PropertyRepository $propertyRepository
                        ): Response
    {
        /* $property = new Property;
        $property->setTitle('Mon deuxieme bien')
                 ->setAddress('355 Boulevard Paris')
                 ->setRooms(2)
                 ->setBedrooms(3)
                 ->setSurface(40)
                 ->setHeat(2)
                 ->setFloor(4)
                 ->setPrice(120000)
                 ->setCity('Paris')
                 ->setPostalCode("36500")
                 ->setDescription("Une petite deuxieme description");
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush(); */

        $properties = $propertyRepository->findAllVisible();
        dd($properties);
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
        ]);
    }

    /**
     * @Route("/biens/{slug}/{id}", name="app_property_show", requirements={"slug": "[a-z0-9\-]*", "id": "[0-9]"})
     */
    public function show(Property $property, string $slug): Response
    {
        if ( $property->getSlug() !== $slug) {
            return $this->redirectToRoute('app_property_show', [
                'current_menu' => 'properties',
                'property'     => $property
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'current_menu' => 'properties',
            'property'     => $property
        ]);
    }
}
