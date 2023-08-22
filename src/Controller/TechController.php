<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/technicien')]
class TechController extends AbstractController
{
    #[Route('/', name: 'app_tech')]
    public function index(): Response
    {
        return $this->render('tech/index.html.twig', [
            'controller_name' => 'TechController',
        ]);
    }
}
