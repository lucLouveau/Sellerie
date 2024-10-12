<?php

namespace App\Controller\CRUD\Zone;

use App\Entity\Zone;
use App\Form\ZoneType;
use App\Repository\ZoneRepository;
use App\Repository\TypeZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ZoneIdController extends AbstractController
{
    public function index(Zone $zone,ZoneRepository $zoneRepo): Response
    {
        $zones=$zoneRepo->findAllNotId($zone->getId());
        $data=[];
        foreach ($zones as $zonePlace) {
            $data[$zonePlace->getId()]=[
                "nom"=>$zonePlace->getNom(),
                "latitude"=>$zonePlace->getLatitude(),
                "longitude"=>$zonePlace->getLongitude(),
            ];
        }
        $form = $this->createForm(ZoneType::class, $zone);
        return $this->render('crud/zone/one.html.twig', [
            'form'=>$form,
            'zone'=>$zone,
            'zonePlace'=>$data
        ]);
    }
    public function modify(int $id,array $zone, ZoneRepository $zoneRepo, TypeZoneRepository $typeRepo, EntityManagerInterface $em): Response
    {
        $zoneModif = $zoneRepo->find($id);
        $zoneModif->setNom($zone['nom']);
        $zoneModif->setLatitude(explode(",",$zone['latitude']));
        $zoneModif->setLongitude(explode(",",$zone['longitude']));
        $zoneModif->setType($typeRepo->find($zone['type']));
        $em->persist($zoneModif);
        $em->flush();
        return $this->redirectToRoute('app_home');
    }
}