<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document]
class Recipe
{
    #[MongoDB\Id(strategy: "AUTO")]
    private string $id;

    #[MongoDB\Field(type: 'string')]
    private string $name;

    #[MongoDB\Field(type: 'string')]
    private string $origin;

    #[MongoDB\Field(type: 'string')]
    private string $presentation;

    #[MongoDB\Field(type: 'string')]
    private string $tips;

    #[MongoDB\Field(type: 'int')]
    private int $cookingTime;

    #[MongoDB\Field(type: 'int')]
    private int $preparationTime;

    #[MongoDB\EmbedMany(targetDocument:Step::class)]
    private ArrayCollection $steps;

    #[MongoDB\EmbedMany(targetDocument:Ingredient::class)]
    private ArrayCollection $ingredients;

    public function __construct()
    {
        $this->steps = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getTips(): ?string
    {
        return $this->tips;
    }

    public function setTips(string $tips): self
    {
        $this->tips = $tips;

        return $this;
    }

    public function getCookingTime(): ?int
    {
        return $this->cookingTime;
    }

    public function setCookingTime(int $cookingTime): self
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getPreparationTime(): ?int
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(int $preparationTime): self
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    /** @return Step[] */
    public function getSteps(): array
    {
        return $this->steps->toArray();
    }

    public function addStep(Step $step): self
    {
        if (!$this->steps->contains($step)) {
            $this->steps->add($step);
        }

        return $this;
    }

    public function removeStep(Step $step): self
    {
        if ($this->steps->contains($step)) {
            $this->steps->remove($step);
        }

        return $this;
    }

    /** @return Ingredient[] */
    public function getIngredients(): array
    {
        return $this->ingredients->toArray();
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        if ($this->ingredients->contains($ingredient)) {
            $this->ingredients->remove($ingredient);
        }

        return $this;
    }
}
