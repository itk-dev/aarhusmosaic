<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        // TODO: Replace exampleProp with required values.
        return $this->render('index.html.twig', [
            'exampleProp' => "exampleValue"
        ]);
    }
}
