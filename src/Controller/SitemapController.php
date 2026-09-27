<?php

namespace App\Controller;

use App\Repository\ArticleBlogRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SitemapController extends AbstractController
{
    #[Route('/sitemap.xml', name: 'app_sitemap', methods: ['GET'])]
    public function index(
        ArticleBlogRepository $articleRepository,
        ProjetRepository $projetRepository
    ): Response {
        $articles = $articleRepository->findAll();
        $projets = $projetRepository->findAll();

        $response = $this->render('sitemap/index.xml.twig', [
            'articles' => $articles,
            'projets' => $projets,
        ]);

        $response->headers->set('Content-Type', 'application/xml');

        return $response;
    }
}
