<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AngularController
{
    #[Route(
        '/{reactRouting}',
        name: 'angular',
        requirements: ['reactRouting' => '^(?!api).+'],
        defaults: ['reactRouting' => 'index.html']
    )]
    public function index(): Response
    {
        $filePath = dirname(__DIR__, 2) . '/public/app/browser/index.html';

        if (!file_exists($filePath)) {
            return new Response('Angular app not found', 404);
        }

        return new Response(file_get_contents($filePath), 200, ['Content-Type' => 'text/html']);
    }
}
