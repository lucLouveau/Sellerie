<?php

namespace App\Controller\Historique;

use App\Entity\Equipement;
use App\Repository\CategoriesRepository;
use App\Repository\EquipementRepository;
use App\Repository\HistoriquesRepository;
use App\Repository\UserRepository;
use App\Repository\ZoneRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/historique')]
class HistoriqueController extends AbstractController
{
    private $equipRepo;
    private $zoneRepo;
    private $userRepo;
    private $histoRepo;
    public function __construct(HistoriquesRepository $histoRepo,EquipementRepository $equipRepo, ZoneRepository $zoneRepo, UserRepository $userRepo)
    {
        $this->equipRepo=$equipRepo;
        $this->zoneRepo=$zoneRepo;
        $this->userRepo=$userRepo;
        $this->histoRepo=$histoRepo;
    }
    #[Route('/', name: 'app_historique')]
    public function index(): Response
    {
        $historiques=  $this->histoRepo->findAll();

        return $this->render('historique/index.html.twig', [
            'historiques'=>$historiques
        ]);
    }

    #[Route('/employe/{id}', name: 'app_historique_employe')]
    #[Route('/date/{date}', name: 'app_historique_date')]
    #[Route('/zone/{id}', name: 'app_historique_zone')]
    #[Route('/equipement/{id}', name: 'app_historique_equipement')]
    public function show(Request $request,int $id=null, string $date=null): Response
    {
        if($date!=null){
            $historiques=  $this->histoRepo->findAllByDate($date);
        }
        else{
            if(str_contains($request->getRequestUri(),"zone")) $historiques= $this->zoneRepo->find($id)->getHistoriques();
            else if(str_contains($request->getRequestUri(),"equipement")) $historiques= $this->equipRepo->find($id)->getHistoriques();
            else if(str_contains($request->getRequestUri(),"employe")) $historiques= $this->histoRepo->findBy(['user'=>$this->userRepo->find($id)]);
        }

        return $this->render('historique/index.html.twig', [
            'historiques'=>$historiques
        ]);
    }
}