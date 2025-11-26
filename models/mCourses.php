<?php
require_once 'mConnexionBD.php';

function obtenirCourses() {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('
        SELECT c.*, h.localisation_hippodrome 
        FROM course c 
        JOIN hippodrome h ON c.id_hippodrome = h.id_hippodrome 
        ORDER BY c.date_course DESC
    ');
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterCourse($dateCourse, $idHippodrome) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('INSERT INTO course (date_course, id_hippodrome) VALUES (?, ?)');
    return $requete->execute([$dateCourse, $idHippodrome]);
}

function obtenirParticipantsCourse($idCourse) {
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

function mettreAJourTempsParticipant($idCourse, $idEquipe, $temps) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('UPDATE participe SET temps = ? WHERE id_course = ? AND id_equipe = ?');
    return $requete->execute([$temps, $idCourse, $idEquipe]);
}

function obtenirTousChevaux() {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM cheval ORDER BY nom_cheval');
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function obtenirTousJockeys() {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT * FROM jockey ORDER BY nom_jockey');
    $requete->execute();
    return $requete->fetchAll(PDO::FETCH_ASSOC);
}

function creerParticipation($idCourse, $ifceCheval, $matriculeJockey, $numDossard) {
    $base = connecterBaseDeDonnees();
    
    // 1. Vérifier si l'équipe existe déjà
    $requete = $base->prepare('SELECT id_equipe FROM equipe WHERE IFCE = ? AND matricule_jockey = ?');
    $requete->execute([$ifceCheval, $matriculeJockey]);
    $equipe = $requete->fetch(PDO::FETCH_ASSOC);
    
    if ($equipe) {
        $idEquipe = $equipe['id_equipe'];
    } else {
        $requete = $base->prepare('INSERT INTO equipe (matricule_jockey, IFCE) VALUES (?, ?)');
        $requete->execute([$matriculeJockey, $ifceCheval]);
        $idEquipe = $base->lastInsertId();
    }
    
    $requete = $base->prepare('INSERT INTO participe (id_course, id_equipe, num_dossard) VALUES (?, ?, ?)');
    return $requete->execute([$idCourse, $idEquipe, $numDossard]);
}

function supprimerParticipationsCourse($idCourse) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('DELETE FROM participe WHERE id_course = ?');
    return $requete->execute([$idCourse]);
}

function supprimerCourse($idCourse) {
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

function supprimerParticipant($idCourse, $idEquipe) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('DELETE FROM participe WHERE id_course = ? AND id_equipe = ?');
    return $requete->execute([$idCourse, $idEquipe]);
}

function modifierCourse($idCourse, $dateCourse, $idHippodrome) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('UPDATE course SET date_course = ?, id_hippodrome = ? WHERE id_course = ?');
    return $requete->execute([$dateCourse, $idHippodrome, $idCourse]);
}

function obtenirCourseParId($idCourse) {
    $base = connecterBaseDeDonnees();
    $requete = $base->prepare('SELECT c.*, h.localisation_hippodrome FROM course c JOIN hippodrome h ON c.id_hippodrome = h.id_hippodrome WHERE c.id_course = ?');
    $requete->execute([$idCourse]);
    return $requete->fetch(PDO::FETCH_ASSOC);
}
?>