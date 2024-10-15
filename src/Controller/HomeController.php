<?php

namespace App\Controller;

use App\Repository\EmplacementsRepository;
use App\Repository\EquipementRepository;
use App\Repository\TypeZoneRepository;
use App\Repository\ZoneRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ZoneRepository $zoneRepo, EquipementRepository $equipementRepo, TypeZoneRepository $typeZoneRepo, EmplacementsRepository $emplacementRepo): Response
    {
        //Récupération emplacements
        $zones=$zoneRepo->findBy([],['nom'=>'ASC']);
        $dataZones=[
        ];
        foreach ($zones as $key => $zone){
            $dataZones[$key]=[
                "equipementIn"=>$zoneRepo->findEquipementInZone($zone->getId()),
                "id"=>$zone->getId(),
                "nom"=>$zone->getNom(),
                "coord"=>[],
                "rayons"=>[],
            ];
            //récupération des coordonées
            $longs=$zone->getLongitude();
            $lats=$zone->getLatitude();
            foreach($longs as $cle=>$valeur){
                $dataZones[$key]['coord'][$cle]=[$lats[$cle],$valeur];
            }
            //récupération des équipements devant être dans cette zone
            $rayons=$zone->getRayons();
            foreach ($rayons as $cle => $rayon) {
                $emplacements=$rayon->getEmplacements();
                $dataZones[$key]["rayons"][$cle]=[
                    "nom"=>$rayon->getNom(),
                    "dimension"=>[$rayon->getLargeur(), $rayon->getHauteur()],
                ];
                foreach ($emplacements as $keyEmplacement => $emplacement) {
                    $dataZones[$key]["rayons"][$cle]['emplacements'][$keyEmplacement]=[
                        "nom"=>$emplacement->getNom(),
                        "etage"=>$emplacement->getEtage(),
                        "colone"=>$emplacement->getColone(),
                        "equipement"=>$emplacement->getEquipement()->getId()
                    ];
                }
            }
        };
        $equipements=$equipementRepo->findAll();
        $dataEquipements=[];
        foreach ($equipements as $key => $equipement) {
            $historiques=$equipement->getHistoriques();
            if(count($historiques)!=0){
                $pos=$historiques[count($historiques)-1]->getZone()->getNom();
            }
            else{
                $pos=$emplacementRepo->findOneBy(['equipement'=>$equipement])
                    ->getRayon()->getZone()->getNom();
            }
            $dataEquipements[$key]=[
                "id"=>$equipement->getId(),
                "nom"=>$equipement->getNom(),
                "position"=>$pos
            ];
        }
        $typesZone= $typeZoneRepo->findAll();
        return $this->render('home/index.html.twig', [
            'dataZones'=>$dataZones,
            'dataEquipements'=>$dataEquipements,
            'typesZone'=>$typesZone,
        ]);
    }
}
