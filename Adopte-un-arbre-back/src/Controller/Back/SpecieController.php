<?php

namespace App\Controller\Back;

use App\Entity\Specie;
use App\Form\SpecieType;
use App\Repository\SpecieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/specie')]
class SpecieController extends AbstractController
{
    #[Route('/', name: 'app_back_specie_index', methods: ['GET'])]
    public function index(SpecieRepository $specieRepository): Response
    {
        return $this->render('back/specie/index.html.twig', [
            'species' => $specieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_specie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SpecieRepository $specieRepository): Response
    {
        $specie = new Specie();
        $form = $this->createForm(SpecieType::class, $specie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specieRepository->add($specie, true);

            return $this->redirectToRoute('app_back_specie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/specie/new.html.twig', [
            'specie' => $specie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_specie_show', methods: ['GET'])]
    public function show(Specie $specie): Response
    {
        return $this->render('back/specie/show.html.twig', [
            'specie' => $specie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_specie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Specie $specie, SpecieRepository $specieRepository): Response
    {
        $form = $this->createForm(SpecieType::class, $specie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $specieRepository->add($specie, true);

            return $this->redirectToRoute('app_back_specie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/specie/edit.html.twig', [
            'specie' => $specie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_specie_delete', methods: ['POST'])]
    public function delete(Request $request, Specie $specie, SpecieRepository $specieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specie->getId(), $request->request->get('_token'))) {
            $specieRepository->remove($specie, true);
        }

        return $this->redirectToRoute('app_back_specie_index', [], Response::HTTP_SEE_OTHER);
    }
}
