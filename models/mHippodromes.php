<?php
require_once 'mConnexionBD.php';

function obtenirHippodromes() {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM hippodrome ORDER BY id_hippodrome');
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterHippodrome($localisation, $capacite) { 
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('INSERT INTO hippodrome (localisation_hippodrome, capacite_hippodrome) VALUES (?, ?)');
    return $requete->execute([$localisation, $capacite]);
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

function modifierHippodrome($idHippodrome, $localisation, $capacite) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('UPDATE hippodrome SET localisation_hippodrome = ?, capacite_hippodrome = ? WHERE id_hippodrome = ?');
    return $requete->execute([$localisation, $capacite, $idHippodrome]);
}

function obtenirHippodromeParId($idHippodrome) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM hippodrome WHERE id_hippodrome = ?');
    $requete->execute([$idHippodrome]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

/**
 * Vérifie si un hippodrome peut être supprimé (pas de courses associées)
 */
function hippodromePeutEtreSupprime($idHippodrome) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT COUNT(*) as nb_courses FROM course WHERE id_hippodrome = ?');
    $requete->execute([$idHippodrome]);
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    return $resultat['nb_courses'] == 0;
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