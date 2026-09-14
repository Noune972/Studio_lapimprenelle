<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjetController extends AbstractController
{
    #[Route('/projets', name: 'app_projet_index')]
    public function index(ProjetRepository $projetRepository): Response
    {
        return $this->render('projet/index.html.twig', [
            'projets' => $projetRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/projets/{slug}', name: 'app_projet_show')]
    public function show(string $slug, ProjetRepository $projetRepository): Response
    {
        $projet = $projetRepository->findOneBy(['slug' => $slug]);

        if (!$projet) {
            throw $this->createNotFoundException('Projet introuvable');
        }

        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }
}