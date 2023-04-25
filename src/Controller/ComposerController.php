<?php
namespace App\Controller;

use App\Entity\Composer;
use App\Repository\ComposerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ComposerController extends AbstractController
{
    #[Route('/composer', name: 'app_composer_index', methods:['GET'])]
    public function index(ComposerRepository $repo): JsonResponse
    {
        return $this->json($repo->findAll());
    }

    #[Route('/composer/{id}', name: 'app_composer_show', methods:['GET'])]
    public function show(Composer $composer): JsonResponse
    {
        return $this->json($composer);
    }

    #[Route('/composer', name: 'app_composer_create', methods:['POST'])]
    public function create(
        ComposerRepository $repo,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Request $request
    ): JsonResponse
    {
        $composer = $serializer->deserialize($request->getContent(), Composer::class, 'json', []);
        $errors = $validator->validate($composer);
        if (count($errors) > 0) {
            return $this->json($errors, 422);
        }

        $repo->save($composer, true);
        return $this->json($composer, 201);
    }

    #[Route('/composer/{id}', name: 'app_composer_update', methods:['PUT'])]
    public function update(
        ComposerRepository $repo,
        SerializerInterface $serializer,
        Composer $composer,
        ValidatorInterface $validator,
        Request $request
    ): JsonResponse
    {
        $composer = $serializer->deserialize($request->getContent(), Composer::class, 'json', [
            AbstractNormalizer::OBJECT_TO_POPULATE => $composer,
        ]);
        $errors = $validator->validate($composer);
        if (count($errors) > 0) {
            return $this->json($errors, 422);
        }

        $repo->save($composer, true);
        return $this->json($composer);
    }

    #[Route('/composer/{id}', name: 'app_composer_delete', methods:['DELETE'])]
    public function delete(ComposerRepository $repo, Composer $composer): JsonResponse
    {
        $repo->remove($composer, true);
        return $this->json('', 204);
    }
}

