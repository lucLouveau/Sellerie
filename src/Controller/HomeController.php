<?php

namespace App\Controller;

use App\Repository\EmplacementsRepository;
use App\Repository\EquipementRepository;
use App\Repository\ZoneRepository;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Point;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\InfoWindow;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\Map\Polygon;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ZoneRepository $zoneRepo, EquipementRepository $equipementRepo, EmplacementsRepository $emplacementRepo): Response
    {
        //Récupération emplacements
        $equipements=$equipementRepo->findAll();
        $emplacementProduits=[];
        for($i=0;$i<count($equipements);$i++){
            $historique=$equipements[$i]->getHistoriques();
            $emplacementProduits[]=[
                "equipement"=>$equipements[$i]->getNom(),
                "endroit"=>$historique[count($historique)-1]->getZone()->getNom(),
                "emplacement"=>$emplacementRepo->findOneBy(["equipement"=>$equipements[$i]])->getZone()->getNom()
            ];
        }

        //Récupération des zones
        $zones=$zoneRepo->findAll();
        $coordonees=[];
        $types=[];
        $names=[];
        for ($i=0; $i < count($zones); $i++) { 
            $coordonees[$i]=[$zones[$i]->getLatitude(),$zones[$i]->getLongitude()];
            $types[$i]=$zones[$i]->getType()->getNom();
            $names[$i]=$zones[$i]->getNom();
        }
        return $this->render('home/index.html.twig', [
            'coordonees'=> $coordonees,
            'types'=>$types,
            "names"=>$names,
            "emplacementProduits"=>$emplacementProduits
        ]);
    }
}
