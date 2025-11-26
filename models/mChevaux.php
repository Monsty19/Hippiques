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

function supprimerCheval($ifce) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('DELETE FROM cheval WHERE IFCE = ?');
    return $requete->execute([$ifce]);
}

function modifierCheval($ifce, $nom, $dateNaissance, $race) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('UPDATE cheval SET nom_cheval = ?, dateNaissance_cheval = ?, race_cheval = ? WHERE IFCE = ?');
    return $requete->execute([$nom, $dateNaissance, $race, $ifce]);
}

function obtenirChevalParIFCE($ifce) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM cheval WHERE IFCE = ?');
    $requete->execute([$ifce]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}
?>