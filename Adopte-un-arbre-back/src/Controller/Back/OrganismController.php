<?php

namespace App\Controller\Back;

use App\Entity\Organism;
use App\Form\Organism1Type;
use App\Form\OrganismType;
use App\Repository\OrganismRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/organism')]
class OrganismController extends AbstractController
{
    #[Route('/', name: 'app_back_organism_index', methods: ['GET'])]
    public function index(OrganismRepository $organismRepository): Response
    {
        return $this->render('back/organism/index.html.twig', [
            'organisms' => $organismRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_back_organism_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OrganismRepository $organismRepository): Response
    {
        $organism = new Organism();
        $form = $this->createForm(OrganismType::class, $organism);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organismRepository->add($organism, true);

            return $this->redirectToRoute('app_back_organism_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/organism/new.html.twig', [
            'organism' => $organism,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_organism_show', methods: ['GET'])]
    public function show(Organism $organism): Response
    {
        return $this->render('back/organism/show.html.twig', [
            'organism' => $organism,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_organism_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Organism $organism, OrganismRepository $organismRepository): Response
    {
        $form = $this->createForm(OrganismType::class, $organism);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $organismRepository->add($organism, true);

            return $this->redirectToRoute('app_back_organism_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/organism/edit.html.twig', [
            'organism' => $organism,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_organism_delete', methods: ['POST'])]
    public function delete(Request $request, Organism $organism, OrganismRepository $organismRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$organism->getId(), $request->request->get('_token'))) {
            $organismRepository->remove($organism, true);
        }

        return $this->redirectToRoute('app_back_organism_index', [], Response::HTTP_SEE_OTHER);
    }
}
