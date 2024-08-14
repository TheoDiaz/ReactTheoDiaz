import React from 'react';
import { TouchableOpacity, Text, StyleSheet } from 'react-native';

export default function Button({url, textButton, color, navigation}) {
  return (
    <TouchableOpacity className={color+" text-white font-bold py-2 px-4 rounded shadow-lg mb-5"} onPress={() => navigation.navigate(url)}>
        <Text className="text-center text-white text-lg">{textButton}</Text>
    </TouchableOpacity>
  );
}