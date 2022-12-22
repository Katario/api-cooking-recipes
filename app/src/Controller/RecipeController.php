<?php

namespace App\Controller;

use App\Api\JsonResponse;
use App\Document\Recipe;
use App\Document\Aliment;
use Doctrine\ODM\MongoDB\DocumentManager;
use PhpParser\JsonDecoder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function postRecipeByIdAction(Request $request, SerializerInterface $serializer): Response
    {
        $alimentRepository = $this->documentManager->getRepository(Aliment::class);

        // @TODO: add a validator to assert that there is at least ONE ingredient in the recipe
        $recipe = $serializer->deserialize($request->getContent(), Recipe::class, 'json');
        $countAlimentPersisted = 0;

        foreach ($recipe->getIngredients() as $ingredient) {
            $aliment = $ingredient->getAliment();
            $alimentsFound = $alimentRepository->findBy(['name' => $aliment->getName()]);
            if (sizeof($alimentsFound) > 0) {
                $ingredient->setAliment($alimentsFound[0]);

                continue;
            }
            ++$countAlimentPersisted;

            $this->documentManager->persist($aliment);
        }

        if ($countAlimentPersisted > 0) {
            $this->documentManager->flush();
        }

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

    // Reminder: PATCH update partially the resource. If needs to replace completely the resource, use PUT
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