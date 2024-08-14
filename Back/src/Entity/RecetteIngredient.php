<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class RecetteIngredient
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Recettes::class, inversedBy: 'recetteIngredients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recettes $recette = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Ingredients::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingredients $ingredient = null;

    #[ORM\Column(type: 'float')]
    private ?float $quantity = null;

    public function getRecette(): ?Recettes
    {
        return $this->recette;
    }

    public function setRecette(?Recettes $recette): self
    {
        $this->recette = $recette;

        return $this;
    }

    public function getIngredient(): ?Ingredients
    {
        return $this->ingredient;
    }

    public function setIngredient(?Ingredients $ingredient): self
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
