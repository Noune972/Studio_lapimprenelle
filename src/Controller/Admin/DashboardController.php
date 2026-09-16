<?php

namespace App\Controller\Admin;

use App\Controller\Admin\ArticleBlogCrudController;
use App\Controller\Admin\ProjetCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->redirectToRoute('admin_article_blog_index');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tempo — Administration');
    }

       public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');
        yield MenuItem::linkTo(ArticleBlogCrudController::class, 'Articles', 'fa fa-newspaper');
        yield MenuItem::linkTo(ProjetCrudController::class, 'Projets', 'fa fa-folder');
        yield MenuItem::linkToUrl('Voir le site', 'fa fa-external-link-alt', '/');
    }
}