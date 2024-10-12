// webpack.config.js
const Encore = require('@symfony/webpack-encore');
const path = require('path');

Encore
    // Définir le répertoire de sortie des fichiers compilés
    .setOutputPath('public/build/')
    
    // Définir le chemin public utilisé par le serveur web pour accéder au répertoire de sortie
    .setPublicPath('/build')
    
    // Ajouter un point d'entrée pour votre application
    .addEntry('app', './assets/app.js')
    
    // Activer le découpage des chunks pour une meilleure optimisation
    .splitEntryChunks()
    
    // Activer un runtime unique pour éviter les problèmes de duplication
    .enableSingleRuntimeChunk()
    
    // Nettoyer le répertoire de sortie avant chaque build
    .cleanupOutputBeforeBuild()
    
    // Activer les notifications de build (optionnel)
    .enableBuildNotifications()
    
    // Activer les source maps en développement
    .enableSourceMaps(!Encore.isProduction())
    
    // Activer la versioning des fichiers en production
    .enableVersioning(Encore.isProduction())
    
    // Configurer Babel pour supporter les fonctionnalités modernes de JavaScript
    .configureBabel(() => {}, {
        useBuiltIns: 'usage',
        corejs: 3
    })
    
    // Activer PostCSS et Tailwind CSS
    .enablePostCssLoader()

    // Ajouter un alias pour controllers.json
    .addAliases({
        '@symfony/stimulus-bridge/controllers.json': path.resolve(__dirname, 'assets/controllers.json'),
    })
;

module.exports = Encore.getWebpackConfig();