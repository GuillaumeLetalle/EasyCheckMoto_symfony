<?php

namespace App\Controller;

use App\Entity\Moto;
use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\MotoRepository;
use App\Repository\ClientRepository;
use App\Repository\CTRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/index', name: 'app_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new( Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $client->getPassword();
            $hasedPassword = $passwordHasher->hashPassword(
                $client,
                $plaintextPassword
            );
            $client->setPassword($hasedPassword);
            $client->setRoles(['ROLE_CLIENT']);
            $client->setUsername($client->getEmail());
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/new.html.twig', [
            'client' => $client,
            'form' => $form
        ]);
    }

    #[Route('/{id}/show', name: 'app_client_show', methods: ['GET'])]
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Client $client,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {
        
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $client->getPassword();
            $hasedPassword = $passwordHasher->hashPassword(
                $client,
                $plaintextPassword
            );
            $client->setPassword($hasedPassword);
            $client->setRoles(['ROLE_CLIENT']);
            $client->setUsername($client->getEmail());
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('client_home',  [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, EntityManagerInterface $entityManager, MotoRepository $motoRepository, $id): Response
    {
        if ($this->isCsrfTokenValid('delete' . $client->getId(), $request->request->get('_token'))) {
            //$motoRepository->setCommentsToNull($id);
            $entityManager->remove($client);
            $entityManager->flush();
            $this->container->get('security.token_storage')->setToken(null);
        }

        return $this->redirectToRoute('app_home');
    }
}
