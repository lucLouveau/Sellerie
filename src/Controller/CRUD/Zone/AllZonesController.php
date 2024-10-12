<?php

namespace App\Controller\CRUD\Zone;

use App\Repository\ZoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AllZonesController extends AbstractController
{
    public function index(ZoneRepository $zoneRepo): Response
    {
        $zones=$zoneRepo->findAll();
        return $this->render('crud/zone/all.html.twig', [
            "zones"=>$zones
        ]);
    }
}