<?php
require_once 'mConnexionBD.php';

function verifierConnexion($identifiant, $motDePasse) { 
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM utilisateur WHERE identifiant = ? AND mdp = ?');
    $requete->execute([$identifiant, $motDePasse]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}

function estGestionnaireFederation() {  //vérifie si l’utilisateur connecté est un gestionnaire de fédération.
    return isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 1;   //Vérifie si la variable $_SESSION['type_utilisateur'] existe et si sa valeur est égale à 1.
}

function estGestionnaireHippodrome() {
    return isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 0;  //Vérifie si la variable $_SESSION['type_utilisateur'] existe et si sa valeur est égale à 0.
}
?>