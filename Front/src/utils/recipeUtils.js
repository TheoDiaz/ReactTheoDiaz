export function formatRecipeType(typeRecette) {
    // Supprime le préfixe "TYPE_" et met la première lettre en majuscule
    return typeRecette
      .replace('TYPE_', '')
      .toLowerCase()
      .replace(/^\w/, (c) => c.toUpperCase());
  }