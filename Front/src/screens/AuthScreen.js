import React, { useState } from 'react';
import { View, Text, TextInput, TouchableOpacity, StyleSheet, Alert } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { registerUser, loginUser } from '../api/api';

export default function AuthScreen({ navigation }) {
  const [isLogin, setIsLogin] = useState(true);
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');

  const handleAuth = async () => {
    try {
      if (isLogin) {
        const response = await loginUser({ email, password });
        console.log('Réponse de connexion :', response);
  
        if (response.userId !== undefined) {
          console.log('ID utilisateur reçu :', response.userId);
          await AsyncStorage.setItem('userId', response.userId.toString());
          console.log('ID utilisateur stocké dans AsyncStorage');
  
          if (response.userName) {
            await AsyncStorage.setItem('userName', response.userName);
          }
  
          navigation.navigate('Home');
        } else {
          console.warn('Aucun ID utilisateur reçu dans la réponse');
          Alert.alert('Erreur', 'Impossible de récupérer les informations de l\'utilisateur');
        }
      } else {
        await registerUser({ name, email, password });
        Alert.alert('Succès', 'Inscription réussie !');
        setIsLogin(true); // Passer à l'écran de connexion après l'inscription
      }
    } catch (error) {
      console.error('Erreur lors de l\'authentification :', error);
      Alert.alert('Erreur', 'Une erreur est survenue.');
    }
  };  

  return (
    <View style={styles.container}>
      <Text style={styles.title}>{isLogin ? 'Connexion' : 'Inscription'}</Text>
      {!isLogin && (
        <TextInput
          style={styles.input}
          placeholder="Nom"
          value={name}
          onChangeText={setName}
        />
      )}
      <TextInput
        style={styles.input}
        placeholder="Email"
        value={email}
        onChangeText={setEmail}
        keyboardType="email-address"
      />
      <TextInput
        style={styles.input}
        placeholder="Mot de passe"
        secureTextEntry
        value={password}
        onChangeText={setPassword}
      />
      <TouchableOpacity style={styles.button} onPress={handleAuth}>
        <Text style={styles.buttonText}>{isLogin ? 'Se connecter' : 'S\'inscrire'}</Text>
      </TouchableOpacity>
      <TouchableOpacity style={styles.switchButton} onPress={() => setIsLogin(!isLogin)}>
        <Text style={styles.switchButtonText}>
          {isLogin ? 'Pas encore de compte? Inscrivez-vous' : 'Déjà un compte? Connectez-vous'}
        </Text>
      </TouchableOpacity>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    padding: 20,
    backgroundColor: '#fff',
  },
  title: {
    fontSize: 24,
    fontWeight: 'bold',
    marginBottom: 20,
  },
  input: {
    height: 40,
    borderColor: 'gray',
    borderBottomWidth: 1,
    marginBottom: 20,
    paddingHorizontal: 10,
  },
  button: {
    backgroundColor: '#007BFF',
    padding: 15,
    borderRadius: 5,
    alignItems: 'center',
    marginBottom: 10,
  },
  buttonText: {
    color: '#fff',
    fontSize: 16,
  },
  switchButton: {
    backgroundColor: '#6c757d',
    padding: 15,
    borderRadius: 5,
    alignItems: 'center',
  },
  switchButtonText: {
    color: '#fff',
    fontSize: 16,
  },
});