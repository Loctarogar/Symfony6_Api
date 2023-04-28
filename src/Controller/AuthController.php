<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AuthController extends AbstractController
{
    #[Route('/login', name: 'app_auth_login')]
    public function login(#[CurrentUser] User $user): JsonResponse
    {
        if (!$user) {
            return $this->json([
                'Invalid credentials',
                Response::HTTP_UNAUTHORIZED,
            ]);
        }

        $token = '123';

        return $this->json([
            'token' => $token,
        ]);
    }
}