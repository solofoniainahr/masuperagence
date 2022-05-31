<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
    private $repository;
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/property", name="app_admin_index", methods={"GET"})
     *
     * @return void
     */
    public function index()
    {
        $properties = $this->repository->findAll();

        return $this->render('Admin/property/index.html.twig', [
            'properties'   => $properties,
            'current_menu' => 'admin'
        ]);
    }

     /**
     * @Route("/admin/property/create", name="app_admin_create", methods="POST")
     *
     * @return void
     */
    public function new(EntityManagerInterface $em, Request $request)
    {
        $property = new Property;
        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            $em->persist($property);
            $em->flush();
            $this->addFlash('success', 'Ajout reussi avec succèes');

            return $this->redirectToRoute('app_admin_index');
        }

        return $this->render('Admin/property/new.html.twig', [
            'form'     => $form->createView(),
            'current_menu' => 'admin'
        ]);
    }

     /**
     * @Route("/admin/property/{id}/edit", name="app_admin_edit", methods={"GET|POST"})
     *
     * @return void
     */
    public function edit(Property $property, 
                        Request $request,
                        EntityManagerInterface $em): Response
    {
        
        $form = $this->createForm(PropertyType::class, $property);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            $em->flush();
            $this->addFlash('success', 'Modification reussi');

            return $this->redirectToRoute('app_admin_index');
        }

        return $this->render('Admin/property/edit.html.twig', [
            'form'     => $form->createView(),
            'property' => $property,
            'current_menu' => 'admin'
        ]);
    }
    
    /**
     * @Route("/admin/property/{id}/delete", name="app_admin_delete", methods={"DELETE"})
     *
     * @return void
     */
    public function delete(Property $property, 
                        Request $request,
                        EntityManagerInterface $em): Response
    {
        dd($property);
        $em->remove($property);
        $em->flush;

        return $this->render('Admin/property/index.html.twig');

    }

}