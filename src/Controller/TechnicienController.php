<?php

namespace App\Controller;

use App\Entity\Technicien;
use App\Form\TechnicienType;
use App\Repository\CTRepository;
use App\Repository\TechnicienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/technicien')]
class TechnicienController extends AbstractController
{
    #[Route('/index', name: 'app_technicien_index', methods: ['GET'])]
    public function index(TechnicienRepository $technicienRepository): Response
    {
        return $this->render('technicien/index.html.twig', [
            'techniciens' => $technicienRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_technicien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $technicien = new Technicien();
        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $technicien->getPassword();
            $hasedPassword = $passwordHasher->hashPassword(
                $technicien,
                $plaintextPassword
            );
            $technicien->setPassword($hasedPassword);
            $technicien->setRoles(['ROLE_TECHNICIEN']);
            $entityManager->persist($technicien);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('technicien/new.html.twig', [
            'technicien' => $technicien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_technicien_show', methods: ['GET'])]
    public function show(Technicien $technicien): Response
    {
        return $this->render('technicien/show.html.twig', [
            'technicien' => $technicien,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_technicien_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Technicien $technicien,
        EntityManagerInterface
        $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {

        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $technicien->getPassword();
            $hasedPassword = $passwordHasher->hashPassword(
                $technicien,
                $plaintextPassword
            );
            $technicien->setPassword($hasedPassword);
            $technicien->setRoles(['ROLE_TECHNICIEN']);
            $entityManager->persist($technicien);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('technicien/edit.html.twig', [
            'technicien' => $technicien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_technicien_delete', methods: ['POST'])]
    public function delete(Request $request, Technicien $technicien, EntityManagerInterface $entityManager, CTRepository $cT, $id): Response
    {
        if ($this->isCsrfTokenValid('delete' . $technicien->getId(), $request->request->get('_token'))) {
            $cT->setCtToNull($id);
            $entityManager->remove($technicien);
            $entityManager->flush();
            $this->container->get('security.token_storage')->setToken(null);
        }

        return $this->redirectToRoute('app_technicien_index', [], Response::HTTP_SEE_OTHER);
    }
}
