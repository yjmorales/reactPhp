<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LoopController extends AbstractController
{
    /**
     * @Route("/loop", name="app_loop")
     */
    public function index(): JsonResponse
    {
        return $this->json([
        ]);
    }
}
