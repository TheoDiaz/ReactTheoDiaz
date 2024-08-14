import React from 'react';
import { View, Text, StyleSheet } from 'react-native';

export default function IngredientList({ ingredients }) {
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Ingrédients</Text>
      {ingredients.map((ingredient, index) => (
        <Text key={index} style={styles.ingredient}>{ingredient}</Text>
      ))}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    marginTop: 20,
  },
  title: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 10,
  },
  ingredient: {
    fontSize: 16,
    marginBottom: 5,
  },
});
