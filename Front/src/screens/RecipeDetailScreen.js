import React, { useEffect, useState } from 'react';
import { View, Text, StyleSheet, ScrollView } from 'react-native';
import { getRecipeById } from '../api/api';
import { formatRecipeType } from '../utils/recipeUtils';

export default function RecipeDetailScreen({ route }) {
  const { id } = route.params;
  const [recipe, setRecipe] = useState(null);

  useEffect(() => {
    fetchRecipeDetail();
  }, []);

  const fetchRecipeDetail = async () => {
    try {
      const response = await getRecipeById(id);
      setRecipe(response);
    } catch (error) {
      console.error('Erreur lors de la récupération de la recette:', error);
    }
  };

  if (!recipe) {
    return (
      <View style={styles.container}>
        <Text>Chargement de la recette...</Text>
      </View>
    );
  }

  return (
    <ScrollView contentContainerStyle={styles.container}>
      <Text style={styles.title}>{recipe.name}</Text>
      <Text style={styles.sectionTitle}>Type de Recette</Text>
      <Text>{formatRecipeType(recipe.typeRecette)}</Text>
      <Text style={styles.sectionTitle}>Ingrédients</Text>
      {recipe.recetteIngredients && recipe.recetteIngredients.map((item, index) => (
        <View key={index} style={styles.ingredientItem}>
          <Text style={styles.ingredientText}>
            • {item.quantity} {item.ingredient.unit} {item.ingredient.name}
          </Text>
        </View>
      ))}
      <Text style={styles.sectionTitle}>Étapes</Text>
      <Text>{recipe.instructions}</Text>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flexGrow: 1,
    padding: 20,
    backgroundColor: '#f0f0f0',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  sectionTitle: {
    fontSize: 20,
    fontWeight: 'bold',
    marginTop: 20,
    marginBottom: 10,
  },
  ingredientItem: {
    marginBottom: 5,
  },
  ingredientText: {
    fontSize: 16,
  },
});
