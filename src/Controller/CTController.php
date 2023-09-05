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
use App\Form\CreateCTTechnicienType;
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
        $user = $this->getUser();

        if ($user instanceof Client){
        
            return $this->render('ct/index.html.twig', [
                'cts' => $cTRepository->findby(['client' => $id]),
            ]);

        }

        if ($user instanceof Technicien){
        
            return $this->render('ct/ctok.html.twig', [
                'cts' => $cTRepository->findby(['technicien_controle' => $id]),
            ]);
            
        }

        return $this->render('ct/index.html.twig', [
            'cts' => $cTRepository->findAll(),
        ]);

    }

    #[Route('/tous', name: 'app_ct_tous', methods: ['GET'])]
    public function ctTous(CTRepository $cTRepository): Response
    {
            return $this->render('ct/allCt.html.twig', [
                'cts' => $cTRepository->findAll(),
            ]);
    }

    #[Route('/a_faire', name: 'app_ct_a_faire', methods: ['GET'])]
    public function indexCTAFaire(CTRepository $cTRepository): Response
    {
            return $this->render('ct/ctafaire.html.twig', [
                'cts' => $cTRepository->findAll(),
            ]);
    }


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
                $ct->setCTEffectue(false);
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
                    $ct->setCTEffectue(false);
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
        $user = $this->getUser();
        $form = $this->createForm(CTType::class, $ct);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ct->setTechnicienControle($user);
            $entityManager->persist($ct);
            $entityManager->flush();

            return $this->redirectToRoute('app_ct_a_faire', [], Response::HTTP_SEE_OTHER);
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
