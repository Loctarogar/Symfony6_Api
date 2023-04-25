<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SymphonyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use App\Entity\Symphony;

class SymphonyController extends AbstractController
{#[Route('/symphony', name: 'app_symphony_index', methods: ['GET'])]
public function index(SymphonyRepository $repo): JsonResponse
{

    return $this->json($repo->findAll());
}

    #[Route('/symphony/{id}', name: 'app_symphony_show', methods: ['GET'])]
    public function show(Symphony $symphony): JsonResponse
    {

        return $this->json($symphony);
    }

    #[Route('/symphony', name: 'app_symphony_create', methods: ['POST'])]
    public function create(SymphonyRepository $repo,SerializerInterface $serializer, Request $request): JsonResponse
    {
        $symphony = $serializer->deserialize($request->getContent(), Symphony::class, 'json', []);
        $repo->save($symphony, true);
        print_r($symphony);
        return $this->json($symphony, 201);
    }

    #[Route('/symphony/{id}', name: 'app_symphony_update', methods: ['PUT'])]
    public function update(SymphonyRepository $repo, SerializerInterface $serializer, Symphony $symphony, Request $request): JsonResponse
    {
        $symphony = $serializer->deserialize($request->getContent(), Symphony::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $symphony
        ]);
        $repo->save($symphony, true);
        return $this->json($symphony);
    }

    #[Route('/symphony/{id}', name: 'app_symphony_delete', methods: ['DELETE'])]
    public function delete(SymphonyRepository $repo, Symphony $symphony): JsonResponse
    {
        $repo->remove($symphony, true);
        return $this->json('', 204);
    }
}
