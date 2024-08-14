import React from 'react';
import { TouchableOpacity, Text, StyleSheet } from 'react-native';

export default function ButtonRedirection({ text, url, navigation }) {
  return (
    <TouchableOpacity style={styles.menuItem} onPress={() => navigation.navigate(url)}>
      <Text style={styles.menuText}>{text}</Text>
    </TouchableOpacity>
  );
}

const styles = StyleSheet.create({
  menuItem: {
    padding: 16,
    borderBottomWidth: 1,
    borderBottomColor: '#333',
  },
  menuText: {
    color: 'white',
    fontSize: 18,
  },
});