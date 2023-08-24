<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'client_home')]
    public function index(): Response
    {
        return $this->render('client/home.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
