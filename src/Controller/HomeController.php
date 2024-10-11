<?php

namespace App\Controller;

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
    public function index(ZoneRepository $zoneRepo): Response
    {
        $myMap= (new Map())
            ->center(new Point(49.118480, -1.066835))
            ->zoom(20)
            // Or automatically fit the bounds to the markers
        ;
        $zones=$zoneRepo->findAll();
        for ($i=0; $i < count($zones); $i++) { 
            $points=[];
            $lats=$zones[$i]->getLatitude();
            $longs=$zones[$i]->getLongitude();
            for ($j=0; $j < count($lats); $j++) { 
                $points[]=new Point($lats[$j], $longs[$j]);
            }
            $myMap
                ->addPolygon(new Polygon(
                    points:$points,
                    title:  $zones[$i]->getNom(),
                ));
        }
        return $this->render('home/index.html.twig', [
            'my_map'=> $myMap,
        ]);
    }
}
