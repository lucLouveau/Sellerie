<?php

namespace App\Controller\Categories\CRUD;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AllCategoriesController extends AbstractController
{
    public function index(CategoriesRepository $catRepo): Response
    {
        $categories = $catRepo->findAll();
        return $this->render('crud/categories/all.html.twig', [
            "categories" => $categories
        ]);
    }
}