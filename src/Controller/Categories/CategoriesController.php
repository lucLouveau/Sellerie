<?php

namespace App\Controller\Categories;

use App\Entity\Categories;
use App\Form\CategoriesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'app_categorie')]
    public function all(): Response
    {
        $response = $this->forward('App\Controller\Categories\CRUD\AllCategoriesController::index');
        return $response;
    }

    #[Route('/add', name: "app_categorie_add", methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: "app_categorie_edit", methods: ['GET', 'POST'], requirements: ['id' => '\d+'], defaults: ['id' => null])]
    public function edit(Request $request, ?Categories $categorie, EntityManagerInterface $em): Response
    {
        if ($categorie === null) {
            $categorie = new Categories();
            $em->persist($categorie); // Persister la nouvelle entité
        }

        $form = $this->createForm(CategoriesType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_categorie', [], Response::HTTP_SEE_OTHER);
        }

        $response = $this->forward('App\Controller\Categories\CRUD\OneCategoriesController::edit', [
            'form' => $form
        ]);

        return $response;
    }

    #[Route('/{id}', name: "app_categorie_show", methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Categories $categorie): Response
    {
        $response = $this->forward('App\Controller\Categories\CRUD\OneCategoriesController::index', [
            'categorie' => $categorie
        ]);
        return $response;
    }
}