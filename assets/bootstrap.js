// assets/bootstrap.js
import { startStimulusApp } from '@symfony/stimulus-bridge';
import './styles/app.css'; // Importer votre CSS principal

// Démarrer l'application Stimulus en passant le contexte des contrôleurs
const app = startStimulusApp(require.context(
    './controllers', // Répertoire contenant vos contrôleurs
    true,            // Rechercher récursivement
    /\.js$/          // Fichiers à inclure
));

// Exemple de code additionnel
console.log('Stimulus et Webpack Encore fonctionnent correctement!');

