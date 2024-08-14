import React, { useEffect, useState } from 'react';
import { View, Text, TextInput, Button, Picker, StyleSheet, Alert, FlatList, TouchableOpacity, ScrollView, Dimensions } from 'react-native';
import { fetchTypesRecettes, createRecipe, searchIngredients } from '../api/api';
import AsyncStorage from '@react-native-async-storage/async-storage';

export default function CreateRecipeScreen({ navigation }) {
  const [types, setTypes] = useState([]);
  const [selectedType, setSelectedType] = useState('');
  const [name, setName] = useState('');
  const [instructions, setInstructions] = useState('');
  const [ingredients, setIngredients] = useState([]);
  const [currentIngredient, setCurrentIngredient] = useState('');
  const [currentQuantity, setCurrentQuantity] = useState('');
  const [currentUnit, setCurrentUnit] = useState('g');
  const [suggestions, setSuggestions] = useState([]);
  const [windowWidth, setWindowWidth] = useState(Dimensions.get('window').width);

  useEffect(() => {
    const getTypes = async () => {
      try {
        const typesData = await fetchTypesRecettes();
        setTypes(Object.entries(typesData).map(([label, value]) => ({ label, value })));
      } catch (error) {
        console.error('Erreur lors de la récupération des types:', error);
      }
    };

    getTypes();

    const updateLayout = () => {
      setWindowWidth(Dimensions.get('window').width);
    };

    Dimensions.addEventListener('change', updateLayout);
    return () => {
      Dimensions.removeEventListener('change', updateLayout);
    };
  }, []);

  const handleIngredientSearch = async (text) => {
    setCurrentIngredient(text);
    if (text.length > 1) {
      try {
        const results = await searchIngredients(text);
        setSuggestions(results || []);
      } catch (error) {
        console.error('Erreur lors de la recherche d\'ingrédients:', error);
        setSuggestions([]);
      }
    } else {
      setSuggestions([]);
    }
  };

  const addIngredient = (ingredient) => {
    if (currentIngredient && currentQuantity) {
      setIngredients([...ingredients, { 
        name: ingredient.name || currentIngredient, 
        quantity: currentQuantity, 
        unit: ingredient.unit || currentUnit 
      }]);
      setCurrentIngredient('');
      setCurrentQuantity('');
      setCurrentUnit('g');
      setSuggestions([]);
    }
  };

  const handleCreateRecipe = async () => {
    try {
      const userId = await AsyncStorage.getItem('userId');
      if (!userId) {
        Alert.alert('Erreur', 'Utilisateur non identifié.');
        return;
      }
  
      await createRecipe({
        name,
        typeRecette: selectedType,
        instructions,
        addedBy: parseInt(userId),
        ingredients: ingredients
      });
  
      Alert.alert('Succès', 'Recette créée avec succès!');
      navigation.goBack();
    } catch (error) {
      console.error('Erreur lors de la création de la recette:', error);
      Alert.alert('Erreur', 'Une erreur est survenue.');
    }
  };

  return (
    <ScrollView style={styles.container}>
      <Text style={styles.title}>Créer une Recette</Text>
      <TextInput
        style={styles.input}
        placeholder="Nom de la recette"
        value={name}
        onChangeText={setName}
      />
      <Text>Type de Recette:</Text>
      <Picker
        selectedValue={selectedType}
        onValueChange={(itemValue) => setSelectedType(itemValue)}
        style={[styles.picker, { width: windowWidth * 0.9 }]}
      >
        <Picker.Item label="--Choisissez un type--" value="" />
        {types.map((type) => (
          <Picker.Item key={type.value} label={type.label} value={type.value} />
        ))}
      </Picker>
      <TextInput
        style={styles.input}
        placeholder="Instructions"
        value={instructions}
        onChangeText={setInstructions}
        multiline
      />
      <Text style={styles.sectionTitle}>Ingrédients:</Text>
      <View style={styles.ingredientInput}>
        <TextInput
          style={[styles.ingredientName, { width: windowWidth * 0.4 }]}
          placeholder="Ingrédient"
          value={currentIngredient}
          onChangeText={handleIngredientSearch}
        />
        <TextInput
          style={[styles.ingredientQuantity, { width: windowWidth * 0.2 }]}
          placeholder="Quantité"
          value={currentQuantity}
          onChangeText={setCurrentQuantity}
          keyboardType="numeric"
        />
        <Picker
          selectedValue={currentUnit}
          onValueChange={(itemValue) => setCurrentUnit(itemValue)}
          style={[styles.unitPicker, { width: windowWidth * 0.15 }]}
        >
          <Picker.Item label="g" value="g" />
          <Picker.Item label="ml" value="ml" />
          <Picker.Item label="pièce" value="pièce" />
        </Picker>
        <TouchableOpacity style={styles.addButton} onPress={() => addIngredient({})}>
          <Text style={styles.addButtonText}>+</Text>
        </TouchableOpacity>
      </View>
      {suggestions.length > 0 && (
        <FlatList
          data={suggestions}
          renderItem={({ item }) => (
            <TouchableOpacity 
              style={styles.suggestionItem} 
              onPress={() => {
                setCurrentIngredient(item.name);
                setCurrentUnit(item.unit || 'g');
                addIngredient(item);
              }}
            >
              <Text>{`${item.name} (${item.unit || 'unité non spécifiée'})`}</Text>
            </TouchableOpacity>
          )}
          keyExtractor={(item, index) => (item.id ? item.id.toString() : index.toString())}
        />
      )}
      <FlatList
        data={ingredients}
        renderItem={({ item }) => (
          <Text style={styles.ingredientListItem}>{`${item.name} - ${item.quantity} ${item.unit}`}</Text>
        )}
        keyExtractor={(item, index) => index.toString()}
      />
      <Button title="Créer la Recette" onPress={handleCreateRecipe} />
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: 20,
    backgroundColor: '#fff',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  sectionTitle: {
    fontSize: 18,
    fontWeight: 'bold',
    marginTop: 10,
    marginBottom: 5,
  },
  input: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 1,
    marginBottom: 10,
    paddingHorizontal: 10,
    borderRadius: 5,
  },
  picker: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 1,
    marginRight: 10,
    paddingHorizontal: 10,
    borderRadius: 5,
    marginBottom : 20,
  },
  ingredientInput: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 10,
    width: '100%',
  },
  ingredientName: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 1,
    marginRight: 10,
    paddingHorizontal: 10,
    borderRadius: 5,
  },
  ingredientQuantity: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 1,
    marginRight: 10,
    paddingHorizontal: 10,
    borderRadius: 5,
  },
  unitPicker: {
    height: 40,
    borderColor: 'gray',
    borderWidth: 1,
    marginRight: 10,
    paddingHorizontal: 10,
    borderRadius: 5,
  },
  addButton: {
    width: 40,
    height: 40,
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#007bff',
    borderRadius: 20,
  },
  addButtonText: {
    color: 'white',
    fontSize: 24,
  },
  suggestionItem: {
    padding: 10,
    borderBottomWidth: 1,
    borderBottomColor: '#ddd',
    backgroundColor: 'lightgrey',
  },
  ingredientListItem: {
    padding: 5,
    marginBottom: 5,
    backgroundColor: '#f0f0f0',
    borderRadius: 5,
  },
});