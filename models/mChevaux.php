<?php
require_once 'mConnexionBD.php';

function obtenirChevaux() {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM cheval ORDER BY IFCE');
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterCheval($ifce, $nom, $dateNaissance, $race) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('INSERT INTO cheval (IFCE, nom_cheval, dateNaissance_cheval, race_cheval) VALUES (?, ?, ?, ?)');
    return $requete->execute([$ifce, $nom, $dateNaissance, $race]);
}
?>