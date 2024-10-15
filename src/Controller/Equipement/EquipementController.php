<?php

namespace App\Controller\Equipement;

use App\Entity\Equipement;
use App\Form\EquipementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/equipements')]
class EquipementController extends AbstractController
{
    #[Route('/', name: 'app_equipement')]
    public function all(): Response
    {
        $response = $this->forward('App\Controller\Equipement\CRUD\AllEquipementsController::index');
        return $response;
    }


    #[Route('/add', name:"app_equipement_add", methods: ['GET','POST'])]
    #[Route('/{id}/edit', name:"app_equipement_edit", methods: ['GET','POST'], requirements: ['id' => '\d+'], defaults: ['id' => null])]
    public function edit(Request $request, ?Equipement $equipement, EntityManagerInterface $em): Response
    {
        if ($equipement === null) {
            $equipement = new Equipement();
            $em->persist($equipement); // Persist the new entity
        }

        $form = $this->createForm(EquipementType::class, $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_equipement', [], Response::HTTP_SEE_OTHER);
        }

        $response = $this->forward('App\Controller\Equipement\CRUD\OneEquipementController::edit', [
            'form' => $form
        ]);
        
        return $response;
    }

    
    #[Route('/{id}', name: "app_equipement_show", methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Equipement  $equipement): Response
    {
        $response = $this->forward('App\Controller\Equipement\CRUD\OneEquipementController::index',[
            'equipement'=>$equipement
        ]);
        return $response;
    }

}