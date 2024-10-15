<?php

namespace App\Controller\Equipement\CRUD;

use App\Repository\EquipementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AllEquipementsController extends AbstractController
{
    public function index(EquipementRepository $equipRepo): Response
    {
        $equipements=$equipRepo->findAll();
        return $this->render('crud/equipement/all.html.twig', [
            "equipements"=>$equipements
        ]);
    }
}