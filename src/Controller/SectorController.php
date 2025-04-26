<?php

namespace App\Controller;

use App\Repository\SectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SectorController extends AbstractController
{
    #[Route('/api/sectors', name: 'get_sectors', methods: ['GET'])]
    public function getSectors(SectorRepository $sectorRepository): JsonResponse
    {
        $sectors = $sectorRepository->findAll();

        $data = array_map(fn($sector) => [
            'id' => $sector->getId(),
            'name' => $sector->getName(),
        ], $sectors);

        return $this->json($data);
    }
}
