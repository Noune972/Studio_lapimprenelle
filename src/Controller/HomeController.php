<?php

namespace App\Controller;

use App\Repository\ArticleBlogRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        ProjetRepository $projetRepository,
        ArticleBlogRepository $articleBlogRepository
    ): Response {
        return $this->render('home/index.html.twig', [
            'projets' => $projetRepository->findBy(
                [],
                ['createdAt' => 'DESC'],
                3
            ),
            'latestArticles' => $articleBlogRepository->createQueryBuilder('a')
                ->andWhere('a.publishedAt IS NOT NULL')
                ->andWhere('a.publishedAt <= :now')
                ->setParameter('now', new \DateTimeImmutable())
                ->orderBy('a.publishedAt', 'DESC')
                ->setMaxResults(3)
                ->getQuery()
                ->getResult(),
        ]);
    }
}
