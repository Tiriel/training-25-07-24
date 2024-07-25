<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HelloController extends AbstractController
{
    #[Route('/hello/{name?World}', name: 'app_hello', requirements: ['name' => '(?:\p{L}|[- ])+'])]
    public function index(string $name, string $sfVersion): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            dump($sfVersion);
        }

        return $this->render('hello/index.html.twig', [
            'controller_name' => $name,
        ]);
    }
}
