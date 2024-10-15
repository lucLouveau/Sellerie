<?php

namespace App\Controller\TypeZone\CRUD;

use App\Repository\TypeZoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AllTypeZonesController extends AbstractController
{
    public function index(TypeZoneRepository $typeZoneRepo): Response
    {
        $typeZones = $typeZoneRepo->findAll();
        return $this->render('crud/typezone/all.html.twig', [
            "typeZones" => $typeZones
        ]);
    }
}