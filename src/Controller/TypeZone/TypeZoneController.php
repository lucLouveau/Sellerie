<?php

namespace App\Controller\TypeZone;

use App\Entity\TypeZone;
use App\Form\TypeZoneType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/typezones')]
class TypeZoneController extends AbstractController
{
    #[Route('/', name: 'app_typezone')]
    public function all(): Response
    {
        $response = $this->forward('App\Controller\TypeZone\CRUD\AllTypeZonesController::index');
        return $response;
    }

    #[Route('/add', name: "app_typezone_add", methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: "app_typezone_edit", methods: ['GET', 'POST'], requirements: ['id' => '\d+'], defaults: ['id' => null])]
    public function edit(Request $request, ?TypeZone $typeZone, EntityManagerInterface $em): Response
    {
        if ($typeZone === null) {
            $typeZone = new TypeZone();
            $em->persist($typeZone); // Persister la nouvelle entité
        }

        $form = $this->createForm(TypeZoneType::class, $typeZone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_typezone', [], Response::HTTP_SEE_OTHER);
        }

        $response = $this->forward('App\Controller\TypeZone\CRUD\OneTypeZoneController::edit', [
            'form' => $form
        ]);

        return $response;
    }

    #[Route('/{id}', name: "app_typezone_show", methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(TypeZone $typeZone): Response
    {
        $response = $this->forward('App\Controller\TypeZone\CRUD\OneTypeZoneController::index', [
            'typeZone' => $typeZone
        ]);
        return $response;
    }
}