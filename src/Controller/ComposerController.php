<?php

namespace App\Controller;

use App\Entity\Composer;
use App\Repository\ComposerRepository;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ComposerController extends AbstractController
{
    #[Route('/composer', name: 'app_composer_index', methods: ['GET'])]
    public function index(ComposerRepository $repo): JsonResponse
    {

        return $this->json($repo->findAll());
    }

    #[Route('/composer/{id}', name: 'app_composer_show', methods: ['GET'])]
    public function show(Composer $composer): JsonResponse
    {

        return $this->json($composer);
    }

    #[Route('/composer', name: 'app_composer_create', methods: ['POST'])]
    public function create(ComposerRepository $repo, Request $request): JsonResponse
    {
        return $this->json();
    }

    #[Route('/composer/{id}', name: 'app_composer_update', methods: ['PUT'])]
    public function update(ComposerRepository $repo): JsonResponse
    {

        return $this->json($repo->findAll());
    }

    #[Route('/composer/{id}', name: 'app_composer_delete', methods: ['DELETE'])]
    public function delete(ComposerRepository $repo, Composer $composer): JsonResponse
    {
        $repo->remove($composer, true);
        return $this->json('', 204);
    }
}
