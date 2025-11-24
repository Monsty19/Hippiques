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
?>