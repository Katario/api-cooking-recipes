<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    #[Route('/recipes', name: 'app_recipe')]
    public function index(
        SerializerInterface $serializer,
        RecipeRepository $recipeRepository
    ): Response
    {
        $recipes = [];
        foreach ($recipeRepository->findAll() as $recipe) {
            $recipes[] = $recipe;
        }

        $headers = [];

        return new Response(
            $serializer->serialize($recipes[0], JsonEncoder::FORMAT),
            200,
            array_merge($headers, ['Content-Type' => 'application/json;charset=UTF-8'])
        );
    }
}