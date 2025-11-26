<?php
require_once 'mConnexionBD.php';

function obtenirJockeys() {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM jockey ORDER BY matricule_jockey');
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterJockey($matricule, $nom, $dateNaissance, $genre) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('INSERT INTO jockey (matricule_jockey, nom_jockey, dateNaissance_jockey, genre_jockey) VALUES (?, ?, ?, ?)');
    return $requete->execute([$matricule, $nom, $dateNaissance, $genre]);
}

function supprimerJockey($matricule) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('DELETE FROM jockey WHERE matricule_jockey = ?');
    return $requete->execute([$matricule]);
}

function modifierJockey($matricule, $nom, $dateNaissance, $genre) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('UPDATE jockey SET nom_jockey = ?, dateNaissance_jockey = ?, genre_jockey = ? WHERE matricule_jockey = ?');
    return $requete->execute([$nom, $dateNaissance, $genre, $matricule]);
}

function obtenirJockeyParMatricule($matricule) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM jockey WHERE matricule_jockey = ?');
    $requete->execute([$matricule]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}
?>