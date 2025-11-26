<?php
require_once 'mConnexionBD.php';

function obtenirHippodromes() {
    $base = connecterBaseDeDonnees();  // Connexion à la base de données
    $requete = $base->prepare('SELECT * FROM hippodrome ORDER BY id_hippodrome'); 
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC); 
}

function ajouterHippodrome($localisation, $capacite) { 
    $base = connecterBaseDeDonnees();  // Connexion à la base de données
    $requete = $base->prepare('INSERT INTO hippodrome (localisation_hippodrome, capacite_hippodrome) VALUES (?, ?)');
    return $requete->execute([$localisation, $capacite]); // Exécute la requête avec les valeurs fournies
}

function supprimerHippodrome($idHippodrome) {
    $base = connecterBaseDeDonnees();
    
    // Vérifier d'abord s'il y a des courses associées
    if (!hippodromePeutEtreSupprime($idHippodrome)) {
        return false; // Ne pas supprimer si des courses existent
    }
    
    // Si pas de courses, on peut supprimer
    $requete = $base->prepare('DELETE FROM hippodrome WHERE id_hippodrome = ?');
    return $requete->execute([$idHippodrome]);
}

function modifierHippodrome($idHippodrome, $localisation, $capacite) {  // Modifie les détails d’un hippodrome existant.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('UPDATE hippodrome SET localisation_hippodrome = ?, capacite_hippodrome = ? WHERE id_hippodrome = ?'); // Prépare la requête de mise à jour
    return $requete->execute([$localisation, $capacite, $idHippodrome]);
}

function obtenirHippodromeParId($idHippodrome) {  // Récupère les détails d’un hippodrome spécifique par son ID.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM hippodrome WHERE id_hippodrome = ?');
    $requete->execute([$idHippodrome]); // Exécute la requête avec l'ID de l'hippodrome fourni 
    return $requete->fetch(PDO::FETCH_ASSOC);
}

/**
 * Vérifie si un hippodrome peut être supprimé (pas de courses associées)
 */
function hippodromePeutEtreSupprime($idHippodrome) { // Vérifie s'il y a des courses associées à l'hippodrome
    $base = connecterBaseDeDonnees();  // Connexion à la base de données
    $requete = $base->prepare('SELECT COUNT(*) as nb_courses FROM course WHERE id_hippodrome = ?'); // Prépare une requête pour compter les courses associées
    $requete->execute([$idHippodrome]); 
    $resultat = $requete->fetch(PDO::FETCH_ASSOC); 
    return $resultat['nb_courses'] == 0;  // Retourne true si aucune course n'est associée donc peut être supprimé
}

/**
 * Récupère le nombre de courses associées à un hippodrome
 */
function obtenirNbCoursesHippodrome($idHippodrome) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT COUNT(*) as nb_courses FROM course WHERE id_hippodrome = ?');
    $requete->execute([$idHippodrome]);
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    return $resultat['nb_courses'];
}
?>