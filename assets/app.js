import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';
import './js/script.js';

// Récupérer tous les éléments avec la classe "textInput"
var textInputs = document.getElementsByClassName("textInput");

// Parcourir tous les éléments récupérés
for (var i = 0; i < textInputs.length; i++) {
    // Ajouter un écouteur d'événements pour chaque élément
    textInputs[i].addEventListener("focus", function() {
        this.style.borderBottomColor = "#1965c7";
        
        // Utiliser backgroundColor au lieu de background-color
        // Autres modifications de style si nécessaire
    });
}


// Récupérer tous les éléments avec la classe "textInput"
var textInputs = document.getElementsByClassName("textInput");

// Parcourir tous les éléments récupérés
for (var i = 0; i < textInputs.length; i++) {
    // Ajouter un écouteur d'événements pour chaque élément
    textInputs[i].addEventListener("blur", function() {
        this.style.borderBottomColor = "";
        // Remettre le style par défaut quand l'input perd le focus
        // Remettre d'autres styles par défaut si nécessaire
    });
}



console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
