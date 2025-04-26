<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Sector;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/users', name: 'create_user', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = $this->validateRequestData($request);
        if (!$data) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setAgreeTerms($data['agreeTerms']);
        $this->handleSectors($user, $data['sectors'], $em);

        $em->persist($user);
        $em->flush();

        return $this->json($this->formatUserResponse($user), 201);
    }

    #[Route('/api/users/{id}', name: 'update_user', methods: ['PUT'])]
    public function updateUser(Request $request, User $user, EntityManagerInterface $em): JsonResponse
    {
        $data = $this->validateRequestData($request);
        if (!$data) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        $user->setName($data['name']);
        $user->setAgreeTerms($data['agreeTerms']);
        $this->handleSectors($user, $data['sectors'], $em);

        $em->persist($user);
        $em->flush();

        return $this->json($this->formatUserResponse($user));
    }


    #[Route('/api/users/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function getUserById(User $user): JsonResponse
    {
        return $this->json($this->formatUserResponse($user));
    }

    private function validateRequestData(Request $request): ?array
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['name']) || empty($data['sectors']) || !isset($data['agreeTerms'])) {
            return null;
        }

        return $data;
    }

    private function handleSectors(User $user, array $sectorIds, EntityManagerInterface $em): void
    {
        foreach ($user->getSectors() as $sector) {
            $user->removeSector($sector);
        }

        foreach ($sectorIds as $sectorId) {
            $sector = $em->getRepository(Sector::class)->find($sectorId);
            if ($sector) {
                $user->addSector($sector);
            }
        }
    }

    private function formatUserResponse(User $user): array
    {
        $sectors = array_map(fn($sector) => [
            'id' => $sector->getId(),
            'name' => $sector->getName(),
        ], $user->getSectors()->toArray());

        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'agreeTerms' => $user->isAgreeTerms(),
            'sectors' => $sectors,
        ];
    }
}
