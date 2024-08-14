import axios from 'axios';

const API_URL = 'http://localhost:8000/api';

// Fonction pour obtenir les recettes
export function getRecipes() {
  return axios.get(`${API_URL}/recettes`)
    .then(response => response.data)
    .catch(error => {
      console.error('Erreur lors de la récupération des recettes:', error);
      throw error;
    });
}

// Fonction pour obtenir une recette par ID
export function getRecipeById(id) {
  return axios.get(`${API_URL}/recettes/${id}`)
    .then(response => response.data)
    .catch(error => {
      console.error(`Erreur lors de la récupération de la recette avec l'ID ${id}:`, error);
      throw error;
    });
}

// Fonction pour rechercher des recettes
export function searchRecipes(query) {
  return axios.get(`${API_URL}/recettes/search`, { params: { query } })
    .then(response => response.data)
    .catch(error => {
      console.error('Erreur lors de la recherche des recettes:', error);
      throw error;
    });
}

// Fonction pour inscrire un nouvel utilisateur
export function registerUser(data) {
  return axios.post(`${API_URL}/users/register`, data)
    .then(response => response.data)
    .catch(error => {
      console.error('Erreur lors de l\'inscription de l\'utilisateur:', error);
      throw error;
    });
}

export function loginUser(data) {
  console.log('Envoi de la requête de connexion avec:', data);
  return axios.post(`${API_URL}/users/login`, data, {
    headers: {
      'Content-Type': 'application/json'
    }
  })
  .then(response => {
    console.log('Réponse complète de l\'API:', response.data);
    if (response.data.userId === undefined) {
      console.warn('La réponse de l\'API ne contient pas d\'ID utilisateur');
      console.log('Structure de la réponse:', JSON.stringify(response.data, null, 2));
    } else {
      console.log('ID utilisateur reçu:', response.data.userId);
    }
    return response.data;
  })
  .catch(error => {
    console.error('Erreur lors de la connexion de l\'utilisateur:', error.response ? error.response.data : error.message);
    throw error;
  });
}

export const fetchTypesRecettes = async () => {
  try {
    const response = await axios.get(`${API_URL}/types-recettes`);
    return response.data;
  } catch (error) {
    console.error('Erreur lors de la récupération des types:', error);
    throw error;
  }
};

export function createRecipe(data) {
  console.log('Données envoyées:', data);
  return axios.post(`${API_URL}/recettes`, data, {
    headers: {
      'Content-Type': 'application/ld+json',
      'Accept': 'application/ld+json'
    }
  })
  .then(response => response.data)
  .catch(error => {
    console.error('Erreur lors de la création de la recette:', error);
    throw error;
  });
}

export function searchIngredients(query) {
  return axios.get(`${API_URL}/ingredients/search`, { params: { q: query } })
    .then(response => response.data)
    .catch(error => {
      console.error('Erreur lors de la recherche d\'ingrédients:', error);
      throw error;
    });
}

