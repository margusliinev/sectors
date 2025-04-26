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
        $data = json_decode($request->getContent(), true);

        if (!$data['name'] || !$data['sectors'] || !$data['agreeTerms']) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setAgreeTerms($data['agreeTerms']);

        foreach ($data['sectors'] as $sectorId) {
            $sector = $em->getRepository(Sector::class)->find($sectorId);
            if ($sector) {
                $user->addSector($sector);
            }
        }

        $em->persist($user);
        $em->flush();

        $sectors = [];
        foreach ($user->getSectors() as $sector) {
            $sectors[] = [
                'id' => $sector->getId(),
                'name' => $sector->getName(),
            ];
        }

        return $this->json(['id' => $user->getId(), 'name' => $user->getName(), 'sectors' => $sectors], 201);
    }

    #[Route('/api/users/{id}', name: 'update_user', methods: ['PUT'])]
    public function updateUser(Request $request, User $user, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data['name'] || !$data['sectors'] || !isset($data['agreeTerms'])) {
            return $this->json(['error' => 'Missing required fields'], 400);
        }

        $user->setName($data['name']);
        $user->setAgreeTerms($data['agreeTerms']);

        foreach ($user->getSectors() as $sector) {
            $user->removeSector($sector);
        }

        foreach ($data['sectors'] as $sectorId) {
            $sector = $em->getRepository(Sector::class)->find($sectorId);
            if ($sector) {
                $user->addSector($sector);
            }
        }

        $em->persist($user);
        $em->flush();

        $sectors = [];
        foreach ($user->getSectors() as $sector) {
            $sectors[] = [
                'id' => $sector->getId(),
                'name' => $sector->getName(),
            ];
        }

        return $this->json([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'agreeTerms' => $user->isAgreeTerms(),
            'sectors' => $sectors,
        ]);
    }


    #[Route('/api/users/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function getUserById(User $user): JsonResponse
    {
        $sectors = [];
        foreach ($user->getSectors() as $sector) {
            $sectors[] = $sector->getId();
        }

        return $this->json([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'agreeTerms' => $user->isAgreeTerms(),
            'sectors' => $sectors,
        ]);
    }
}
