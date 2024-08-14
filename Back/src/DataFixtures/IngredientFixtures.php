<?php

namespace App\DataFixtures;

use App\Entity\Ingredients;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Liste d'ingrédients réels
        $ingredientsData = [
            ['name' => 'Farine', 'type' => 'Céréale', 'unit' => 'g'],
            ['name' => 'Sucre', 'type' => 'Condiment', 'unit' => 'g'],
            ['name' => 'Lait', 'type' => 'Produit laitier', 'unit' => 'ml'],
            ['name' => 'Œufs', 'type' => 'Produit animal', 'unit' => 'pièce'],
            ['name' => 'Tomate', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Poulet', 'type' => 'Viande', 'unit' => 'g'],
            ['name' => 'Huile d\'olive', 'type' => 'Huile', 'unit' => 'ml'],
            ['name' => 'Sel', 'type' => 'Condiment', 'unit' => 'g'],
            ['name' => 'Poivre', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Ail', 'type' => 'Aromate', 'unit' => 'gousse'],
            ['name' => 'Carotte', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Céleri', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Oignon', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Pomme de terre', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Brocoli', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Chou-fleur', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Épinard', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Concombre', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Poivron', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Aubergine', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Champignon', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Maïs', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Haricot vert', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Radis', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Artichaut', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Asperge', 'type' => 'Légume', 'unit' => 'g'],
            ['name' => 'Fraise', 'type' => 'Fruit', 'unit' => 'g'],
            ['name' => 'Banane', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Pomme', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Orange', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Citron', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Kiwi', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Melon', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Pastèque', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Raisin', 'type' => 'Fruit', 'unit' => 'g'],
            ['name' => 'Pêche', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Poire', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Cerise', 'type' => 'Fruit', 'unit' => 'g'],
            ['name' => 'Prune', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Abricot', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Figue', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Mangue', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Ananas', 'type' => 'Fruit', 'unit' => 'pièce'],
            ['name' => 'Gingembre', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Cumin', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Paprika', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Cannelle', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Muscade', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Coriandre', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Thym', 'type' => 'Aromate', 'unit' => 'g'],
            ['name' => 'Basilic', 'type' => 'Aromate', 'unit' => 'g'],
            ['name' => 'Persil', 'type' => 'Aromate', 'unit' => 'g'],
            ['name' => 'Menthe', 'type' => 'Aromate', 'unit' => 'g'],
            ['name' => 'Oregano', 'type' => 'Aromate', 'unit' => 'g'],
            ['name' => 'Sel', 'type' => 'Condiment', 'unit' => 'g'],
            ['name' => 'Poivre', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Vinaigre', 'type' => 'Condiment', 'unit' => 'ml'],
            ['name' => 'Moutarde', 'type' => 'Condiment', 'unit' => 'g'],
            ['name' => 'Mayonnaise', 'type' => 'Condiment', 'unit' => 'ml'],
            ['name' => 'Beurre', 'type' => 'Produit laitier', 'unit' => 'g'],
            ['name' => 'Crème', 'type' => 'Produit laitier', 'unit' => 'ml'],
            ['name' => 'Fromage', 'type' => 'Produit laitier', 'unit' => 'g'],
            ['name' => 'Yaourt', 'type' => 'Produit laitier', 'unit' => 'g'],
            ['name' => 'Riz', 'type' => 'Céréale', 'unit' => 'g'],
            ['name' => 'Pâtes', 'type' => 'Céréale', 'unit' => 'g'],
            ['name' => 'Quinoa', 'type' => 'Céréale', 'unit' => 'g'],
            ['name' => 'Avoine', 'type' => 'Céréale', 'unit' => 'g'],
            ['name' => 'Orge', 'type' => 'Céréale', 'unit' => 'g'],
            ['name' => 'Semoule', 'type' => 'Céréale', 'unit' => 'g'],
            ['name' => 'Millet', 'type' => 'Céréale', 'unit' => 'g'],
            ['name' => 'Sésame', 'type' => 'Graines', 'unit' => 'g'],
            ['name' => 'Cacahuète', 'type' => 'Fruit sec', 'unit' => 'g'],
            ['name' => 'Amande', 'type' => 'Fruit sec', 'unit' => 'g'],
            ['name' => 'Noix', 'type' => 'Fruit sec', 'unit' => 'g'],
            ['name' => 'Pistache', 'type' => 'Fruit sec', 'unit' => 'g'],
            ['name' => 'Noisette', 'type' => 'Fruit sec', 'unit' => 'g'],
            ['name' => 'Noix de cajou', 'type' => 'Fruit sec', 'unit' => 'g'],
            ['name' => 'Curry', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Safran', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Piment', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Cacao', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Chocolat', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Café', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Thé', 'type' => 'Épice', 'unit' => 'g'],
            ['name' => 'Miel', 'type' => 'Condiment', 'unit' => 'ml'],
            ['name' => 'Sirop d\'érable', 'type' => 'Condiment', 'unit' => 'ml'],
            ['name' => 'Sauce soja', 'type' => 'Condiment', 'unit' => 'ml'],
            ['name' => 'Ketchup', 'type' => 'Condiment', 'unit' => 'ml'],
            ['name' => 'Sauce barbecue', 'type' => 'Condiment', 'unit' => 'ml'],
            ['name' => 'Sauce tomate', 'type' => 'Condiment', 'unit' => 'ml'],
            ['name' => 'Pâte à tartiner', 'type' => 'Condiment', 'unit' => 'g'],
            ];

        foreach ($ingredientsData as $ingredientData) {
            $ingredient = new Ingredients();
            $ingredient->setName($ingredientData['name']);
            $ingredient->setType($ingredientData['type']);
            $ingredient->setUnit($ingredientData['unit']);
            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}