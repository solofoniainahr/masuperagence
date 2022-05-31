<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PropertyController extends AbstractController
{
    /**
     * @Route("/biens", name="app_property_index")
     */
    public function index(EntityManagerInterface $entityManagerInterface, 
                        PropertyRepository $propertyRepository,
                        PaginatorInterface $paginator, Request $request
                        ): Response
    {
        $search = new PropertySearch;
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);
        
        $properties = $paginator->paginate(
                        $propertyRepository->findAllVisible($search),
                        $request->query->getInt('page', 1), /*page number*/
                        12 /*limit per page*/
                    );

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties'   => $properties,
            'seacrhForm'   => $form->createView()
        ]);
    }

    /**
     * @Route("/biens/{slug}/{id}", name="app_property_show", requirements={"slug": "[a-z0-9\-]*"})
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
