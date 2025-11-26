<?php
require_once '../models/mHippodromes.php';
require_once '../models/mConnexion.php';

session_start();
if (!isset($_SESSION['utilisateur']) || !estGestionnaireFederation()) {
    header('Location: cConnexion.php');
    exit();
}

$action = $_POST['action'] ?? $_GET['action'] ?? 'liste';

switch ($action) {
    case 'liste':
        $hippodromes = obtenirHippodromes();
        include '../views/vHippodromes.php';
        break;
        
    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $localisation = filter_input(INPUT_POST, 'txtLocalisation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $capacite = filter_input(INPUT_POST, 'txtCapacite', FILTER_VALIDATE_INT);
            
            if ($localisation && $capacite) {
                if (ajouterHippodrome($localisation, $capacite)) {
                    $message = "Hippodrome ajouté avec succès";
                } else {
                    $message = "Erreur lors de l'ajout";
                }
            } else {
                $message = "Données invalides";
            }
            $hippodromes = obtenirHippodromes();
            include '../views/vHippodromes.php';
        }
        break;
        
    case 'supprimer':
        $idHippodrome = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($idHippodrome) {
            
            if (!hippodromePeutEtreSupprime($idHippodrome)) {  // code exécuté si l'hippodrome **ne peut pas être supprimé**
                $nbCourses = obtenirNbCoursesHippodrome($idHippodrome);
                header('Location: cHippodromes.php?message=Impossible de supprimer cet hippodrome : il y a ' . $nbCourses . ' course(s) associée(s)');
                exit();
            }
            
            if (supprimerHippodrome($idHippodrome)) {
                header('Location: cHippodromes.php?message=Hippodrome supprimé avec succès');
            } else {
                header('Location: cHippodromes.php?message=Erreur lors de la suppression');
            }
            exit();
        }
        break;
        
    case 'modifier':
        $idHippodrome = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($idHippodrome) {
            $hippodrome = obtenirHippodromeParId($idHippodrome);
            if ($hippodrome) {
                include '../views/vModifierHippodrome.php';
                exit();
            }
        }
        header('Location: cHippodromes.php');
        break;
        
    case 'mettreAJourHippodrome':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idHippodrome = filter_input(INPUT_POST, 'hdIdHippodrome', FILTER_VALIDATE_INT);
            $localisation = filter_input(INPUT_POST, 'txtLocalisation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $capacite = filter_input(INPUT_POST, 'txtCapacite', FILTER_VALIDATE_INT);
            
            if ($idHippodrome && $localisation && $capacite) {
                if (modifierHippodrome($idHippodrome, $localisation, $capacite)) {
                    header('Location: cHippodromes.php?message=Hippodrome modifié avec succès');
                } else {
                    header('Location: cHippodromes.php?message=Erreur lors de la modification');
                }
                exit();
            }
        }
        header('Location: cHippodromes.php');
        break;
        
    default:
        $hippodromes = obtenirHippodromes();
        include '../views/vHippodromes.php';
        break;
}
?>