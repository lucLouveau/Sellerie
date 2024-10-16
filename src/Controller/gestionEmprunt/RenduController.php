<?php

namespace App\Controller\gestionEmprunt;

use DateTime;
use DateTimeZone;
use App\Entity\User;
use App\Form\RendreType;
use App\Entity\Historiques;
use App\Repository\EquipementRepository;
use App\Repository\MouvementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EmplacementsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EquipementEmprunteRepository;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RenduController extends AbstractController
{
    #[Route('/rend', name: 'app_rend')]
    public function index(Request $request,#[CurrentUser] User $user, EquipementEmprunteRepository $equiEmprunRepo, EquipementRepository $equipRepo,MouvementsRepository $mouveRepo ,EmplacementsRepository $emplacementRepo,EntityManagerInterface $em): Response
    {
        $equipARendre=$user->getEquipementEmpruntes();
        $equip=[];
        foreach ($equipARendre as $key => $equipement) {
            $equip[]=$equipement->getEquipement();
        }
        $form = $this->createForm(RendreType::class,null, [
            "equipements"=>$equip
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equip=$equipRepo->find($_POST['rendre']['equipement']);

            $historique = new Historiques();
            $historique->setEquipement($equip);
            $historique->setUser($user);
            $date=new DateTime();
            $timezone=new DateTimeZone('Europe/Paris');
            $date->setTimezone($timezone); 
            $historique->setDate($date);
            $historique->setMouvement($mouveRepo->findOneBy(['nom'=>'Retour']));
            $historique->setZone($emplacementRepo->findOneBy(['equipement'=>$equip])->getRayon()->getZone());

            $em->remove($equiEmprunRepo->findOneBy(['equipement'=>$equip]));
            $em->persist($historique);
            $em->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }
        
        

        return $this->render('gestionEmprunt/rend/index.html.twig', [
            'form'=>$form,
        ]);
    }
}