<?php
require_once 'mConnexionBD.php';

function obtenirCourses() {    //Récupère toutes les courses, avec le lieu de l’hippodrome, triées de la plus récente à la plus ancienne.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('
        SELECT c.*, h.localisation_hippodrome 
        FROM course c 
        JOIN hippodrome h ON c.id_hippodrome = h.id_hippodrome 
        ORDER BY c.date_course DESC
    ');
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC); // signifie que les résultats seront renvoyés sous forme de tableau associatif
}

function ajouterCourse($dateCourse, $idHippodrome) { // Ajoute une nouvelle course avec la date et l’hippodrome spécifiés.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('INSERT INTO course (date_course, id_hippodrome) VALUES (?, ?)');
    return $requete->execute([$dateCourse, $idHippodrome]);
}

function obtenirParticipantsCourse($idCourse) { // Recupère la liste de tout les participants (cheval et jockey) d’une course.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('
        SELECT p.*, e.id_equipe, ch.nom_cheval, j.nom_jockey 
        FROM participe p 
        JOIN equipe e ON p.id_equipe = e.id_equipe 
        JOIN cheval ch ON e.IFCE = ch.IFCE 
        JOIN jockey j ON e.matricule_jockey = j.matricule_jockey 
        WHERE p.id_course = ?
        ORDER BY p.num_dossard
    ');
    $requete->execute([$idCourse]);
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function obtenirResultatsCourse($idCourse) { 
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('
        SELECT p.*, ch.nom_cheval, j.nom_jockey
        FROM participe p
        JOIN equipe e ON p.id_equipe = e.id_equipe
        JOIN cheval ch ON e.IFCE = ch.IFCE
        JOIN jockey j ON e.matricule_jockey = j.matricule_jockey
        WHERE p.id_course = ?
        ORDER BY p.temps ASC
    ');
    $requete->execute([$idCourse]);
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function mettreAJourTempsParticipant($idCourse, $idEquipe, $temps) { // Permet de mettre à jour le temps d’un participant dans une course.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('UPDATE participe SET temps = ? WHERE id_course = ? AND id_equipe = ?');
    return $requete->execute([$temps, $idCourse, $idEquipe]);
}

function obtenirTousChevaux() {     // Récupère tous les chevaux disponibles pour la participation.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM cheval ORDER BY nom_cheval');
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function obtenirTousJockeys() {    // Récupère tous les jockeys disponibles pour la participation.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM jockey ORDER BY nom_jockey');
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function creerParticipation($idCourse, $ifceCheval, $matriculeJockey, $numDossard) {  // Crée une nouvelle participation pour une course selectionnée.
    $base = connecterBaseDeDonnees();
    
    // 1. Vérifier si l'équipe existe déjà
    $requete = $base->prepare('SELECT id_equipe FROM equipe WHERE IFCE = ? AND matricule_jockey = ?');  // Requête pour vérifier si une équipe avec le cheval et le jockey donnés existe déjà
    $requete->execute([$ifceCheval, $matriculeJockey]);
    $equipe = $requete->fetch(PDO::FETCH_ASSOC);
    
    if ($equipe) {
        $idEquipe = $equipe['id_equipe'];       // Si l'équipe existe, on récupère son ID
    } else {
        $requete = $base->prepare('INSERT INTO equipe (matricule_jockey, IFCE) VALUES (?, ?)');   // Sinon, on crée une nouvelle équipe
        $requete->execute([$matriculeJockey, $ifceCheval]);
        $idEquipe = $base->lastInsertId();   //récupérer l’ID auto-incrémenté généré lors du dernier INSERT dans la base de données.
    }
    
    $requete = $base->prepare('INSERT INTO participe (id_course, id_equipe, num_dossard) VALUES (?, ?, ?)');
    return $requete->execute([$idCourse, $idEquipe, $numDossard]);
}

function supprimerParticipationsCourse($idCourse) {    // Supprime toutes les participations associées à une course .
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('DELETE FROM participe WHERE id_course = ?');
    return $requete->execute([$idCourse]);
}

function supprimerCourse($idCourse) {    // Supprime une course et toutes ses participations associées.
    $base = connecterBaseDeDonnees();
    
    try {
        $base->beginTransaction();
        
        // 1. Supprimer d'abord les participations
        supprimerParticipationsCourse($idCourse);
        
        // 2. Supprimer la course
        $requete = $base->prepare('DELETE FROM course WHERE id_course = ?');
        $resultat = $requete->execute([$idCourse]);
        
        $base->commit();
        return $resultat;
        
    } catch (Exception $e) {
        $base->rollBack();
        return false;
    }
}

function supprimerParticipant($idCourse, $idEquipe) {   // Supprime un participant spécifique d’une course.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('DELETE FROM participe WHERE id_course = ? AND id_equipe = ?');
    return $requete->execute([$idCourse, $idEquipe]);
}

function modifierCourse($idCourse, $dateCourse, $idHippodrome) {  // Modifie les détails d’une course existante.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('UPDATE course SET date_course = ?, id_hippodrome = ? WHERE id_course = ?');
    return $requete->execute([$dateCourse, $idHippodrome, $idCourse]);
}

function obtenirCourseParId($idCourse) {   // Récupère les détails d’une course spécifique par son ID.
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT c.*, h.localisation_hippodrome FROM course c JOIN hippodrome h ON c.id_hippodrome = h.id_hippodrome WHERE c.id_course = ?');
    $requete->execute([$idCourse]); // Exécute la requête avec l'ID de la course fourni
    return $requete->fetch(PDO::FETCH_ASSOC);
}
?>