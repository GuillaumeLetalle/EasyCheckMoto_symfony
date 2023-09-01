<?php

namespace App\Controller;

use App\Entity\Moto;
use App\Form\MotoType;
use App\Repository\MotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/moto')]
class MotoController extends AbstractController
{
    #[Route('/list/{id?}', name: 'app_moto_index', methods: ['GET'])]
    public function index(MotoRepository $motoRepository,  $id): Response
    {

        if ($id === null) {
            return $this->render('moto/index.html.twig', [
                'motos' => $motoRepository->findAll(),
            ]);
        } else {
            return $this->render('moto/index.html.twig', [
                'motos' => $motoRepository->findby(['client' => $id]),
            ]);
        }
    }

    #[Route('/new', name: 'app_moto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        $moto = new Moto();
        $form = $this->createForm(MotoType::class, $moto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moto->setClient($user);
            $entityManager->persist($moto);
            $entityManager->flush();

            return $this->redirectToRoute('app_moto_index', ['id' => $userId], Response::HTTP_SEE_OTHER);
        }

        return $this->render('moto/new.html.twig', [
            'moto' => $moto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_moto_show', methods: ['GET'])]
    public function show(Moto $moto): Response
    {
        return $this->render('moto/show.html.twig', [
            'moto' => $moto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_moto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Moto $moto, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        
        $form = $this->createForm(MotoType::class, $moto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_moto_index', ['id' => $userId], Response::HTTP_SEE_OTHER);
        }

        return $this->render('moto/edit.html.twig', [
            'moto' => $moto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_moto_delete', methods: ['POST'])]
    public function delete(Request $request, Moto $moto, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();
        
        if ($this->isCsrfTokenValid('delete' . $moto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($moto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_moto_index', ['id' => $userId], Response::HTTP_SEE_OTHER);
    }
}
