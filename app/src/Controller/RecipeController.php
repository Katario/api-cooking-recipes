<?php

namespace App\Controller;

use App\Api\JsonResponse;
use App\Document\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecipeController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private DocumentManager $documentManager
    ) { }

    #[Route('/recipes', name: 'app_get_recipes', methods: 'GET')]
    public function getRecipesAction(): Response
    {
        $recipes = $this->documentManager->getRepository(Recipe::class)->findAll();

        // @TODO: need to move it to the JsonResponse Class (but need to instance it there...)
        // return new JsonResponse($this->serializer->serialize($recipes, JsonEncoder::FORMAT));
        return new Response(
            $this->serializer->serialize($recipes, JsonEncoder::FORMAT),
            200,
            ['Content-Type' => 'application/json;charset=UTF-8']
        );
    }

    #[Route('/recipes/{id}', name: 'app_get_recipe_id', methods: 'GET')]
    public function getRecipeByIdAction(
        string $id
    ): Response
    {
        $recipe = $this->documentManager->getRepository(Recipe::class)->find($id);

        if(!$recipe) {
            return new Response(
                null,
                404,
                ['Content-Type' => 'application/json;charset=UTF-8']
            );
        }

        return new Response(
            $this->serializer->serialize($recipe, JsonEncoder::FORMAT),
            200,
            ['Content-Type' => 'application/json;charset=UTF-8']
        );
    }

    #[Route('/recipes', name: 'app_post_recipe_id', methods: 'POST')]
    public function postRecipeByIdAction(): Response
    {
        $recipe = new Recipe();
        $recipe->setName('this is a test');
        $recipe->setOrigin('france');

        $this->documentManager->persist($recipe);
        $this->documentManager->flush();

        return new Response(
            $this->serializer->serialize($recipe, JsonEncoder::FORMAT),
            201,
            ['Content-Type' => 'application/json;charset=UTF-8']
        );
    }

    // Reminder: PUT replace completely the resource. If needs to update partially the resource, use PATCH 
    #[Route('/recipes/{id}', name: 'app_put_recipe_id', methods: 'PUT')]
    public function putRecipeByIdAction(
        string $id
    ): Response
    {
        // @TODO
        return new JsonResponse('');
    }

    // Reminder: PATCH update partially the resource. If needs to replace completely the resource, use PATCH
    #[Route('/recipes/{id}', name: 'app_patch_recipe_id', methods: 'PATCH')]
    public function patchRecipeByIdAction(
        string $id
    ): Response
    {
        // @TODO
        return new JsonResponse('');
    }

    #[Route('/recipes/{id}', name: 'app_delete_recipe_id', methods: 'DELETE')]
    public function deleteRecipeByIdAction(
        string $id
    ): Response
    {
        $recipe = $this->documentManager->getRepository(Recipe::class)->find($id);

        if(!$recipe) {
            throw $this->createNotFoundException('No Recipe found with the id ' . $id);
        }

        $this->documentManager->remove($recipe);
        $this->documentManager->flush();

        return new JsonResponse($id);
    }

}