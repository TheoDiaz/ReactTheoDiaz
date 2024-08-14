import React, { useEffect, useState } from 'react';
import { fetchTypesRecettes } from './api/api'; // Ajustez le chemin en fonction de votre structure

const RecipeForm = () => {
    const [types, setTypes] = useState([]);
    const [selectedType, setSelectedType] = useState('');

    useEffect(() => {
        const getTypes = async () => {
            try {
                const typesData = await fetchTypesRecettes();
                setTypes(typesData);
            } catch (error) {
                console.error('Error fetching types:', error);
            }
        };

        getTypes();
    }, []);

    const handleSubmit = async (event) => {
        event.preventDefault();
        // Ajoutez la logique pour soumettre le formulaire
    };

    return (
        <form onSubmit={handleSubmit}>
            <label>
                Type de Recette:
                <select
                    value={selectedType}
                    onChange={(e) => setSelectedType(e.target.value)}
                >
                    <option value="">--Choisissez un type--</option>
                    {Object.entries(types).map(([key, value]) => (
                        <option key={key} value={key}>
                            {value}
                        </option>
                    ))}
                </select>
            </label>
            {/* Ajoutez les autres champs du formulaire ici */}
            <button type="submit">Créer</button>
        </form>
    );
};

export default RecipeForm;
