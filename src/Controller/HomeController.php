<?php

namespace App\Controller;

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
    public function index(): Response
    {
        $myMap= (new Map())
            ->center(new Point(49.118480, -1.066835))
            ->zoom(20)
            // Or automatically fit the bounds to the markers
        ;

        $myMap
            ->addMarker(new Marker(
                position: new Point(48.8566, 2.3522), 
                title: 'Paris',
                infoWindow: new InfoWindow(
                    headerContent: '<b>Paris</b>',
                    content: 'The French town in the historic Rhône-Alpes region, located at the junction of the Rhône and Saône rivers.'
                )
            ));

        $myMap
        ->addPolygon(new Polygon(
            points:[
                new Point(49.118091, -1.068382),
                new Point(49.118499, -1.068541),
                new Point(49.118720, -1.067261),
                new Point(49.118232, -1.066878),
            ]
        ))
        ->addPolygon(new Polygon(
            points:[
                new Point(49.118731, -1.065521),
                new Point(49.118782, -1.064993),
                new Point(49.118353, -1.064878),
                new Point(49.118304, -1.065393),
            ]
        ));
        return $this->render('home/index.html.twig', [
            'my_map'=> $myMap,
        ]);
    }
}
