<?php

namespace App\Controller\TypeZone\CRUD;

use App\Entity\TypeZone;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;

class OneTypeZoneController extends AbstractController
{
    public function index(TypeZone $typeZone): Response
    {
        return $this->render('crud/typezone/one.html.twig', [
            "typeZone" => $typeZone
        ]);
    }

    public function edit(Form $form): Response
    {
        return $this->render('crud/typezone/edit.html.twig', [
            'form' => $form,
        ]);
    }
}