<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enum\UserRole;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', enumType: UserRole::class)]
    private UserRole $role;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Recettes::class)]
    #[ORM\JoinTable(name: 'user_favorite_recipes')]
    private Collection $favoriteRecipes;

    #[ORM\OneToMany(targetEntity: Recettes::class, mappedBy: 'addedBy')]
    private Collection $recipesAdded;

    public function __construct()
    {
        $this->favoriteRecipes = new ArrayCollection();
        $this->recipesAdded = new ArrayCollection();
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

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function setRole(UserRole $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return Collection<int, Recettes>
     */
    public function getFavoriteRecipes(): Collection
    {
        return $this->favoriteRecipes;
    }

    public function addFavoriteRecipe(Recettes $recette): self
    {
        if (!$this->favoriteRecipes->contains($recette)) {
            $this->favoriteRecipes[] = $recette;
        }

        return $this;
    }

    public function removeFavoriteRecipe(Recettes $recette): self
    {
        $this->favoriteRecipes->removeElement($recette);
        return $this;
    }

    /**
     * @return Collection<int, Recettes>
     */
    public function getRecipesAdded(): Collection
    {
        return $this->recipesAdded;
    }

    public function addRecipeAdded(Recettes $recette): self
    {
        if (!$this->recipesAdded->contains($recette)) {
            $this->recipesAdded[] = $recette;
            $recette->setAddedBy($this);
        }

        return $this;
    }

    public function removeRecipeAdded(Recettes $recette): self
    {
        if ($this->recipesAdded->removeElement($recette)) {
            if ($recette->getAddedBy() === $this) {
                $recette->setAddedBy(null);
            }
        }

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getSalt(): ?string
    {
        return null; // Utilisez null si vous n'utilisez pas de salage
    }

    public function eraseCredentials(): void
    {
        // Implémentez cette méthode si vous avez des données sensibles temporaires à effacer
    }

    public function getRoles(): array
    {
        // Retournez un tableau des rôles associés à l'utilisateur
        return [$this->role->value]; // Suppose que UserRole est une énumération avec une propriété `value`
    }

    public function getUserIdentifier(): string
    {
        // Utilisez l'email ou tout autre identifiant unique
        return $this->email ?? '';
    }
}
