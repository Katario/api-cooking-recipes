<?php

namespace App\Factory;

use App\Document\Aliment;
use App\Document\Ingredient;
use App\Document\Recipe;
use App\Document\Step;
use Symfony\Component\HttpFoundation\Request;

class RecipeFactory
{
    static function create(
        $name,
        $origin,
        $presentation,
        $cookingTime,
        $preparationTime
    ): Recipe
    {
        $recipe = new Recipe;

        // TO BE MOVED - ONLY FOR TESTS
        // $step = new Step;
        $aliment = new Aliment;
        // $ingredient = new Ingredient;
        $aliment->setName('Eggplant')->setPresentation('This is the story of an eggplant');

        $recipe->setName($name);
        $recipe->setOrigin($origin);
        $recipe->setPresentation($presentation);
        $recipe->setCookingTime($cookingTime);
        $recipe->setPreparationTime($preparationTime);
        // $recipe->addStep(
        //     $step->setName('firstStep')
        //         ->setContent('This is the content of my  first step')
        //         ->setNumber(1)
        // );
        // $recipe->addIngredient(
        //     $ingredient->setAliment($aliment)
        //         ->setAmount(35)
        //         ->setMeasureUnit('g')
        // );

        return $recipe;
    }
}