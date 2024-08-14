import React from 'react';
import { View, Text, StyleSheet } from 'react-native';

export default function StepList({ steps }) {
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Étapes de Préparation</Text>
      {steps.map((step, index) => (
        <Text key={index} style={styles.step}>{index + 1}. {step}</Text>
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
  step: {
    fontSize: 16,
    marginBottom: 5,
  },
});
