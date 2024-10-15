<?php

namespace App\Controller\Equipement\CRUD;

use App\Entity\Equipement;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;

class OneEquipementController extends AbstractController
{
    public function index(Equipement $equipement): Response
    {
        return $this->render('crud/equipement/one.html.twig', [
            "equipement"=>$equipement
        ]);
    }

    public function edit(Form $form): Response
    {
        return $this->render('crud/equipement/edit.html.twig',[
            'form'=>$form,
        ]);
    }
}