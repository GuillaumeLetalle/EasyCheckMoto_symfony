<?php

namespace App\Controller\Technicien;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/technicien')]
class TechnicienController extends AbstractController
{
    #[Route('/', name: 'technicien_home')]
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'TechnicienController',
        ]);
    }
}
