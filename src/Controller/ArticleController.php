<?php

namespace App\Controller;

use App\Repository\ArticleBlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{
   #[Route('/blog', name: 'app_article_index')]
public function index(
    Request $request,
    ArticleBlogRepository $articleRepository
): Response {
    $page = max(1, $request->query->getInt('page', 1));
    $limit = 6;
    $offset = ($page - 1) * $limit;

    $articles = $articleRepository->findBy(
        [],
        ['publishedAt' => 'DESC'],
        $limit,
        $offset
    );

    $totalArticles = $articleRepository->count([]);
    $totalPages = (int) ceil($totalArticles / $limit);

    return $this->render('article/index.html.twig', [
        'articles' => $articles,
        'currentPage' => $page,
        'totalPages' => $totalPages,
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