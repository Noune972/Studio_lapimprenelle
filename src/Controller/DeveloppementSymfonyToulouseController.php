<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DeveloppementSymfonyToulouseController extends AbstractController
{
    #[Route(
        '/developpement-application-symfony-toulouse',
        name: 'app_developpement_symfony_toulouse',
        methods: ['GET']
    )]
    public function index(): Response
    {
        return $this->render('developpement_symfony_toulouse/index.html.twig');
    }
}

