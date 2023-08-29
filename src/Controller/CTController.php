<?php

namespace App\Controller;

use App\Entity\CT;
use Carbon\Carbon;
use App\Form\CTType;
use App\Form\CreateCTType;
use App\Repository\CTRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/ct')]
class CTController extends AbstractController
{
    #[Route('/index/{id?}', name: 'app_ct_index', methods: ['GET'])]
    public function index(CTRepository $cTRepository, $id): Response
    {
        if ($id === null) {
            return $this->render('ct/index.html.twig', [
                'cts' => $cTRepository->findAll(),
            ]);
        } else {
            return $this->render('ct/index.html.twig', [
                'cts' => $cTRepository->findby(['client' => $id]),
            ]);
        }
    }

    #[Route('/indexTechnicien/{id?}', name: 'app_ct_indexTechnicien', methods: ['GET'])]
    public function indexTechnicien(CTRepository $cTRepository, $id): Response
    {
        if ($id === null) {
            return $this->render('ct/ctok.html.twig', [
                'cts' => $cTRepository->findAll(),
            ]);
        } else {
            // dd( $cTRepository->findby(['technicien_controle' => $id]));
            return $this->render('ct/ctok.html.twig', [
                'cts' => $cTRepository->findby(['technicien_controle' => $id]),
            ]);
        }
    }

    #[Route('/new', name: 'app_ct_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ct = new CT();
        $form = $this->createForm(CreateCTType::class, $ct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ct);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
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
        $now = Carbon::now();
        $user = $this->getUser();
        $form = $this->createForm(CTType::class, $ct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $ct->setFin($now);
            $ct->setTechnicienControle($user);
            // dd($ct);
            $entityManager->persist($ct);
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
