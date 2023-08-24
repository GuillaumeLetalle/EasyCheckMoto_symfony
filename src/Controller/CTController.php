<?php

namespace App\Controller;

use App\Entity\CT;
use App\Form\CTType;
use App\Repository\CTRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ct')]
class CTController extends AbstractController
{
    #[Route('/index', name: 'app_ct_index', methods: ['GET'])]
    public function index(CTRepository $cTRepository): Response
    {

        return $this->render('ct/index.html.twig', [
            'cts' => $cTRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ct_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ct = new CT();
        $form = $this->createForm(CTType::class, $ct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ct);
            $entityManager->flush();

            return $this->redirectToRoute('app_ct_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ct/new.html.twig', [
            'ct' => $ct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_ct_show', methods: ['GET'])]
    public function show(CT $ct): Response
    {
        return $this->render('ct/show.html.twig', [
            'ct' => $ct,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ct_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CT $ct, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CTType::class, $ct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ct_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ct/edit.html.twig', [
            'ct' => $ct,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_ct_delete', methods: ['POST'])]
    public function delete(Request $request, CT $ct, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ct->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ct_index', [], Response::HTTP_SEE_OTHER);
    }
}
