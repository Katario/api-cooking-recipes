<?php

namespace App\Factory;

use App\Document\Aliment;
use App\Document\Ingredient;
use App\Document\Recipe;
use App\Document\Step;

class RecipeFactory
{
    static function create(): Recipe
    {
        $recipe = new Recipe;

        // TO BE MOVED - ONLY FOR TESTS
        $step = new Step;
        $aliment = new Aliment;
        $ingredient = new Ingredient;
        $aliment->setName('Eggplant')->setPresentation('This is the story of an eggplant');

        $recipe->setName('nameTest1');
        $recipe->setOrigin('originTest');
        $recipe->setPresentation('## Presentation Test');
        $recipe->setTips('---- \n toto test');
        $recipe->setCookingTime(35);
        $recipe->setPreparationTime(23);
        $recipe->addStep(
            $step->setName('firstStep')
                ->setContent('This is the content of my  first step')
                ->setNumber(1)
        );
        $recipe->addIngredient(
            $ingredient->setAliment($aliment)
                ->setAmount(35)
                ->setMeasureUnit('g')
        );

        return $recipe;
    }
}