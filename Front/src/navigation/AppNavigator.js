import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import HomeScreen from '../screens/HomeScreen';
import RecipeListScreen from '../screens/RecipeListScreen';
import RecipeDetailScreen from '../screens/RecipeDetailScreen';
import SearchScreen from '../screens/SearchScreen';
import AuthScreen from '../screens/AuthScreen';
import CreateRecipeScreen from '../screens/CreateRecipeScreen';

const Stack = createStackNavigator();

export default function AppNavigator() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="Auth">
        <Stack.Screen name="Home" component={HomeScreen} options={{ title: 'Accueil' }} />
        <Stack.Screen name="RecipeList" component={RecipeListScreen} options={{ title: 'Toutes les Recettes' }} />
        <Stack.Screen name="RecipeDetail" component={RecipeDetailScreen} options={{ title: 'Détails de la Recette' }} />
        <Stack.Screen name="Auth" component={AuthScreen} options={{ title: 'Connexion - Inscription' }} />
        <Stack.Screen name="CreateRecipe" component={CreateRecipeScreen} options={{ title: 'Ajouter une recette' }} />

      </Stack.Navigator>
    </NavigationContainer>
  );
}
