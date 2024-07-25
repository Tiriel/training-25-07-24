<?php

namespace App\Controller;

use App\Notifier\AppNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class HelloController extends AbstractController
{
    #[Route('/hello/{name?World}', name: 'app_hello', requirements: ['name' => '(?:\p{L}|[- ])+'])]
    public function index(string $name, string $sfVersion): Response
    {
        dump($sfVersion);

        return $this->render('hello/index.html.twig', [
            'controller_name' => $name,
        ]);
    }

    #[Route('/notify/{message}', name: 'app_hello_notify', methods: ['GET'])]
    public function notify(string $message, AppNotifier $notifier): Response
    {
        $notifier->sendNotification($message);

        return $this->json([
            'status' => 'success',
            'message' => $message,
        ]);
    }
}
