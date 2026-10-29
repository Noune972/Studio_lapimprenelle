<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CreationSiteToulouseController extends AbstractController
{
    #[Route('/creation-site-internet-toulouse', name: 'app_creation_site_toulouse', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('creation_site_toulouse/index.html.twig');
    }
}

