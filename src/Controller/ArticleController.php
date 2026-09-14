<?php

namespace App\Controller;

use App\Repository\ArticleBlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    #[Route('/blog', name: 'app_article_index')]
    public function index(ArticleBlogRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findBy([], ['publishedAt' => 'DESC']),
        ]);
    }

    #[Route('/blog/{slug}', name: 'app_article_show')]
    public function show(string $slug, ArticleBlogRepository $articleRepository): Response
    {
        $article = $articleRepository->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw $this->createNotFoundException('Article introuvable');
        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }
}