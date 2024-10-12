<?php

namespace App\Controller;

use App\Entity\Zone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/zone')]
class ZoneController extends AbstractController
{
    #[Route('/', name: 'app_zone')]
    public function all(): Response
    {
        $response = $this->forward('App\Controller\CRUD\Zone\AllZonesController::index');
        return $response;
    }

    #[Route('/add', name: 'app_zone_add')]
    public function addZone(): Response
    {
        if(!empty($_POST)){
            $response = $this->forward('App\Controller\CRUD\Zone\AddZoneController::add',[
                'zone'=>$_POST['zone']
            ]);
            return $response;
        }
        $response = $this->forward('App\Controller\CRUD\Zone\AddZoneController::form');
        return $response;
    }

    #[Route('/{id}', name: 'app_zone_id')]
    public function getZone(int $id): Response
    {
        if(!empty($_POST) && isset($_POST['zone']['_token'])){
            unset($_POST['zone']['_token']);
            $response = $this->forward('App\Controller\CRUD\Zone\ZoneIdController::modify',[
                'zone'=>$_POST['zone'],
                "id"=>$id
            ]);
            return $response;
        }
        $response = $this->forward('App\Controller\CRUD\Zone\ZoneIdController::index',[
            "zone"=>$id
        ]);
        return $response;
    }
}
