<?php

namespace App\Controller;

use App\Entity\Equipement;
use App\Entity\Historiques;
use App\Entity\Mouvements;
use App\Form\HistoriquesType;
use App\Repository\EquipementRepository;
use App\Repository\MouvementsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmprintController extends AbstractController
{
    #[Route('/emprint', name: 'app_emprint')]
    public function index(MouvementsRepository $mouvRepo,EquipementRepository $equipementRepo,Request $request,EntityManagerInterface $em): Response
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
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($historique);
            $em->flush();

            return $this->redirectToRoute('app_emprint', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emprint/index.html.twig', [
            'form'=>$form,
            'mouvement'=>$mouvement,
            'equipements'=>$equipements,
        ]);
    }

    
}