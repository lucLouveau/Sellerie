<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Equipement;
use App\Entity\EquipementEmprunte;
use App\Entity\Mouvements;
use App\Entity\Historiques;
use App\Form\HistoriquesType;
use App\Repository\EquipementRepository;
use App\Repository\MouvementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class EmprintController extends AbstractController
{
    #[Route('/emprunt', name: 'app_emprunt')]
    public function index(MouvementsRepository $mouvRepo,EquipementRepository $equipementRepo,Request $request,EntityManagerInterface $em,#[CurrentUser] User $user): Response
    {
        $mouvement= $mouvRepo->findOneBy(["nom"=>"Sortie"]);
        $equipements=$equipementRepo->findAll();
        $equipements=array_filter($equipements, function($v){
            $historiques=$v->getHistoriques();
            return count($historiques)==0 or $historiques[count($historiques)-1]->getMouvement()->getNom() == "Retour";
        });
        $historique=new Historiques();

        $form = $this->createForm(HistoriquesType::class, $historique);
        $form->add('equipement', EntityType::class,[
            'class'=> Equipement::class,
            'choices'=>$equipements,
            'choice_label'=>'nom',
        ]);
        $form->add('mouvement', EntityType::class,[
            'class'=> Mouvements::class,
            'choices'=>[$mouvement],
            'choice_label'=>'nom',
        ]);
        $historique->setUser($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipEmprunt=new EquipementEmprunte();
            $equipEmprunt->setEquipement($historique->getEquipement());
            $equipEmprunt->setUser($user);
            $em->persist($equipEmprunt);
            $em->persist($historique);
            $em->flush();

            return $this->redirectToRoute('app_emprunt', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emprint/index.html.twig', [
            'form'=>$form,
            'mouvement'=>$mouvement,
            'equipements'=>$equipements,
        ]);
    }
}