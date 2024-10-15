<?php

namespace App\Controller\Categories\CRUD;

use App\Entity\Categories;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;

class OneCategoriesController extends AbstractController
{
    public function index(Categories $categorie): Response
    {
        return $this->render('crud/categories/one.html.twig', [
            "categorie" => $categorie
        ]);
    }

    public function edit(Form $form): Response
    {
        return $this->render('crud/categories/edit.html.twig', [
            'form' => $form,
        ]);
    }
}