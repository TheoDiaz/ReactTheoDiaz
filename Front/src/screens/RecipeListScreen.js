import React, { useEffect, useState } from 'react';
import { View, Text, StyleSheet, FlatList, TouchableOpacity, ActivityIndicator } from 'react-native';
import { getRecipes } from '../api/api';

export default function RecipeListScreen({ navigation }) {
  const [recipes, setRecipes] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    fetchRecipes();
  }, []);

  const fetchRecipes = async () => {
    try {
      setLoading(true);
      const response = await getRecipes();
      console.log('Réponse complète:', response);
      
      // Vérifiez si la réponse est un tableau
      if (Array.isArray(response)) {
        setRecipes(response);
        console.log('Recettes récupérées:', response);
      } else {
        throw new Error('Format de réponse inattendu');
      }
    } catch (error) {
      console.error('Erreur lors de la récupération des recettes:', error);
      setError('Impossible de charger les recettes');
    } finally {
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <View style={styles.container}>
        <ActivityIndicator size="large" color="#0000ff" />
      </View>
    );
  }

  if (error) {
    return (
      <View style={styles.container}>
        <Text style={styles.error}>{error}</Text>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <Text style={styles.title}>Toutes les Recettes</Text>
      {recipes.length === 0 ? (
        <Text>Aucune recette trouvée</Text>
      ) : (
        <FlatList
          data={recipes}
          keyExtractor={(item) => item.id.toString()}
          renderItem={({ item }) => (
            <TouchableOpacity onPress={() => navigation.navigate('RecipeDetail', { id: item.id })}>
              <Text style={styles.recipeName}>{item.name}</Text>
            </TouchableOpacity>
          )}
        />
      )}
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#f0f0f0',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  recipeName: {
    fontSize: 18,
    padding: 10,
    backgroundColor: '#fff',
    marginBottom: 10,
    borderRadius: 5,
  },
  error: {
    fontSize: 18,
    color: 'red',
  },
});
