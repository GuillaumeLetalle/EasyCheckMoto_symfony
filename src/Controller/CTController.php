<?php

namespace App\Controller;

use App\Entity\Client;
use DateTime;
use DateInterval;
use App\Entity\CT;
use App\Entity\Technicien;
use Carbon\Carbon;
use App\Form\CTType;
use DateTimeInterface;
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
    
    // Route pour client list leur CT
    #[Route('/index/{id?}', name: 'app_ct_index', methods: ['GET'])]
    public function index(CTRepository $cTRepository, $id): Response
    {
        $user = $this->getUser();
        //$userId = $user->getId();
        
            return $this->render('ct/index.html.twig', [
                'cts' => $cTRepository->findby(['client' => $id]),
            ]);
    }

    // Route pour technicien list leur CT
    #[Route('/indexTechnicien/{id?}', name: 'app_ct_indexTechnicien', methods: ['GET'])]
    public function indexTechnicien(CTRepository $cTRepository, $id): Response
    {
            return $this->render('ct/ctok.html.twig', [
                'cts' => $cTRepository->findby(['technicien_controle' => $id]),
            ]);
    }

    // Route pour admin vois tout les CTs
    #[Route('/indexAdmin', name: 'app_ct_indexAdmin', methods: ['GET'])]
    public function indexAdmin(CTRepository $cTRepository): Response
    {
            return $this->render('ct/index.html.twig', [
                'cts' => $cTRepository->findAll(),
            ]);
    }


    // Création d'un nouveau CT
    #[Route('/new', name: 'app_ct_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $ct = new CT();

        if ($user instanceof Client){
            $form = $this->createForm(CreateCTType::class, $ct);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $endHour = $ct->getDebut();
                $endHour->modify('+1 hour');
                $ct->setFin($endHour);
                $ct->setClient($user);
                $ct->setTitreRdv('RDV');
                $entityManager->persist($ct);
                $entityManager->flush();
                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);     
                }
            }

            if ($user instanceof Technicien){
                $form = $this->createForm(CreateCTTechnicienType::class, $ct);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $endHour = $ct->getDebut();
                    $endHour->modify('+1 hour');
                    $ct->setFin($endHour);
                    $ct->setTechnicienControle($user);
                    $ct->setTitreRdv('RDV');
                    $entityManager->persist($ct);
                    $entityManager->flush();
            
                    return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
                }
            }

        return $this->render('ct/new.html.twig', [
            'ct' => $ct,
            'form' => $form,
        ]);
    }

    //Regarder un CT en détail
    #[Route('/{id}/show', name: 'app_ct_show', methods: ['GET'])]
    public function show(CT $ct): Response
    {
        return $this->render('ct/show.html.twig', [
            'ct' => $ct,
        ]);
    }


    //modifier un CT
    #[Route('/{id}/edit', name: 'app_ct_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CT $ct, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(CTType::class, $ct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            
            $ct->setTechnicienControle($user);
            $entityManager->persist($ct);
            $entityManager->flush();

            return $this->redirectToRoute('app_ct_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ct/edit.html.twig', [
            'ct' => $ct,
            'form' => $form,
        ]);
    }


    //Supprimer un CT
    #[Route('/{id}/delete', name: 'app_ct_delete', methods: ['POST'])]
    public function delete(Request $request, CT $ct, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ct->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ct);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ct_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route(path: '/calendar', name: "app_ct_calendar", methods: ['GET'])]
    public function calendar(): Response
    {
        return $this->render('calendar.html.twig');
    }
}
