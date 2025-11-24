<?php
require_once '../models/mCourses.php';
require_once '../models/mHippodromes.php';
require_once '../models/mConnexion.php';

session_start();
if (!isset($_SESSION['utilisateur'])) {
    header('Location: cConnexion.php');
    exit();
}

$action = $_POST['action'] ?? $_GET['action'] ?? 'liste';

if ($action === 'ajouter' && !estGestionnaireHippodrome()) {
    header('Location: cConnexion.php');
    exit();
}

switch ($action) {
    case 'liste':
        $courses = obtenirCourses();
        include '../views/vCourses.php';
        break;
        
    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dateCourse = filter_input(INPUT_POST, 'txtDateCourse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $idHippodrome = filter_input(INPUT_POST, 'lstHippodrome', FILTER_VALIDATE_INT);
            
            if ($dateCourse && $idHippodrome) {
                if (ajouterCourse($dateCourse, $idHippodrome)) {
                    $message = "Course ajoutée avec succès";
                } else {
                    $message = "Erreur lors de l'ajout";
                }
            } else {
                $message = "Données invalides";
            }
            $courses = obtenirCourses();
            include '../views/vCourses.php';
        }
        break;
        
    case 'gererParticipants':
        $idCourse = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($idCourse) {
            $participants = obtenirParticipantsCourse($idCourse);
            include '../views/vParticipantsCourse.php';
        }
        break;
        
    case 'creerParticipation':
        $idCourse = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($idCourse) {
            $chevaux = obtenirTousChevaux();
            $jockeys = obtenirTousJockeys();
            include '../views/vCreerParticipation.php';
        }
        break;
        
    case 'ajouterParticipation':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCourse = filter_input(INPUT_POST, 'hdIdCourse', FILTER_VALIDATE_INT);
            $ifceCheval = filter_input(INPUT_POST, 'lstCheval', FILTER_VALIDATE_INT);
            $matriculeJockey = filter_input(INPUT_POST, 'lstJockey', FILTER_VALIDATE_INT);
            $numDossard = filter_input(INPUT_POST, 'txtNumDossard', FILTER_VALIDATE_INT);
            
            if ($idCourse && $ifceCheval && $matriculeJockey && $numDossard) {
                if (creerParticipation($idCourse, $ifceCheval, $matriculeJockey, $numDossard)) {
                    header('Location: cCourses.php?action=gererParticipants&id=' . $idCourse);
                    exit();
                }
            }
        }
        break;
        
    case 'saisirResultats':
        $idCourse = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($idCourse) {
            $resultats = obtenirResultatsCourse($idCourse);
            include '../views/vResultatsCourse.php';
        }
        break;
        
    case 'enregistrerTemps':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCourse = filter_input(INPUT_POST, 'hdIdCourse', FILTER_VALIDATE_INT);
            $idEquipe = filter_input(INPUT_POST, 'hdIdEquipe', FILTER_VALIDATE_INT);
            $temps = filter_input(INPUT_POST, 'txtTemps', FILTER_VALIDATE_INT);
            
            if ($idCourse && $idEquipe && $temps) {
                if (mettreAJourTempsParticipant($idCourse, $idEquipe, $temps)) {
                    echo "OK";
                }
            }
        }  
        exit();
        break;
        
    default:
        $courses = obtenirCourses();
        include '../views/vCourses.php';
        break;
}
?>