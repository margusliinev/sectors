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
        $filePath = $this->getAngularIndexPath();

        if (!file_exists($filePath)) {
            return new Response('Angular app not found', Response::HTTP_NOT_FOUND);
        }

        return new Response(file_get_contents($filePath), Response::HTTP_OK, ['Content-Type' => 'text/html']);
    }

    private function getAngularIndexPath(): string
    {
        return dirname(__DIR__, 2) . '/public/app/browser/index.html';
    }
}
