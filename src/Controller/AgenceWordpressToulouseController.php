<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AgenceWordpressToulouseController extends AbstractController
{
    #[Route('/agence-wordpress-toulouse', name: 'app_agence_wordpress_toulouse', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('agence_wordpress_toulouse/index.html.twig');
    }
}
