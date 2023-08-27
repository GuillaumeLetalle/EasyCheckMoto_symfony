<?php

namespace App\Controller\Authentification;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{
    #[Route('/', name: 'user_home')]
    public function index(): Response
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
