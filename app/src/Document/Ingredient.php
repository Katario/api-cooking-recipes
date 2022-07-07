<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\EmbeddedDocument]
class Ingredient
{
    #[MongoDB\ReferenceOne(targetDocument:Aliment::class, cascade:'persist')]
    private Aliment $aliment;

    #[MongoDB\Field(type: 'int')]
    private int $amount;

    #[MongoDB\Field(type: 'string')]
    private string $measureUnit;

    public function getAliment(): ?Aliment
    {
        return $this->aliment;
    }

    public function setAliment(Aliment $aliment): self
    {
        $this->aliment = $aliment;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getMeasureUnit(): ?string
    {
        return $this->measureUnit;
    }

    public function setMeasureUnit(string $measureUnit): self
    {
        $this->measureUnit = $measureUnit;

        return $this;
    }
}