<?php

namespace App\Controller\CRUD\Zone;

use App\Entity\Zone;
use App\Form\ZoneType;
use App\Repository\TypeZoneRepository;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddZoneController extends AbstractController
{
    public function form(ZoneRepository $zoneRepo): Response
    {
        $zones=$zoneRepo->findAll();
        $data=[];
        foreach ($zones as $zone) {
            $data[$zone->getId()]=[
                "nom"=>$zone->getNom(),
                "latitude"=>$zone->getLatitude(),
                "longitude"=>$zone->getLongitude(),
            ];
        }
        $zone=new Zone();
        $form = $this->createForm(ZoneType::class, $zone);
        return $this->render('crud/zone/add/form.html.twig',[
            'form'=>$form,
            "zone"=>$zone,
            "zonePlace"=>$data
        ]);
    }

    public function add(array $zone, TypeZoneRepository $typeRepo, EntityManagerInterface $em): Response
    {
        $newZone=new Zone();
        $newZone->setNom($zone['nom']);
        $newZone->setLatitude(explode(",",$zone['latitude']));
        $newZone->setLongitude(explode(",",$zone['longitude']));
        $newZone->setType($typeRepo->find($zone['type']));
        $em->persist($newZone);
        $em->flush();
        return $this->redirectToRoute('app_home');
    }
}