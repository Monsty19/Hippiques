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
?>