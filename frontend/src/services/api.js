// On importe la bibiothèque axios pour faire des requêtes HTTP
import axios from 'axios';

// On crée une instance axios personnalisée

const api = axios.create({

    // L'URLde base pour toute les requêtes API
    baseURL: 'http://0.0.0.0/api',

    // Les en-têtes par défaut pour chaque requête
    headers: {
        'Content-type': 'application/json', // Indique qu'on envoie des données JSON
        'Accept': 'application/json'
    },
});

// On exporte cette instance pour pouvoir l'utiliser ailleurs dans le projet
export default api;