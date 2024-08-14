<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\TypeRecette;
use App\Repository\RecettesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecettesRepository::class)]
#[ApiResource]
class Recettes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', enumType: TypeRecette::class)]
    private TypeRecette $typeRecette;

    #[ORM\OneToMany(targetEntity: RecetteIngredient::class, mappedBy: 'recette')]
    private Collection $recetteIngredients;

    #[ORM\Column(length: 10000)]
    private ?string $instructions = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'recipesAdded')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $addedBy = null;

    public function __construct()
    {
        $this->recetteIngredients = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): self
    {
        $this->instructions = $instructions;
        return $this;
    }

    public function getAddedBy(): ?User
    {
        return $this->addedBy;
    }

    public function setAddedBy(?User $addedBy): self
    {
        $this->addedBy = $addedBy;
        return $this;
    }

    public function getTypeRecette(): TypeRecette
    {
        return $this->typeRecette;
    }

    public function setTypeRecette(TypeRecette $typeRecette): self
    {
        $this->typeRecette = $typeRecette;
        return $this;
    }

    /**
     * @return Collection<int, RecetteIngredient>
     */
    public function getRecetteIngredients(): Collection
    {
        return $this->recetteIngredients;
    }

    public function addRecetteIngredient(RecetteIngredient $recetteIngredient): self
    {
        if (!$this->recetteIngredients->contains($recetteIngredient)) {
            $this->recetteIngredients->add($recetteIngredient);
            $recetteIngredient->setRecette($this);
        }
        return $this;
    }

    public function removeRecetteIngredient(RecetteIngredient $recetteIngredient): self
    {
        if ($this->recetteIngredients->removeElement($recetteIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recetteIngredient->getRecette() === $this) {
                $recetteIngredient->setRecette(null);
            }
        }
        return $this;
    }
}