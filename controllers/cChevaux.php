<?php
require_once '../models/mChevaux.php';
require_once '../models/mConnexion.php';

session_start();
if (!isset($_SESSION['utilisateur']) || !estGestionnaireFederation()) {
    header('Location: cConnexion.php');
    exit();
}

$action = $_POST['action'] ?? $_GET['action'] ?? 'liste';

switch ($action) {
    case 'liste':
        $chevaux = obtenirChevaux();
        include '../views/vChevaux.php';
        break;
        
    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ifce = filter_input(INPUT_POST, 'txtIFCE', FILTER_VALIDATE_INT);
            $nom = filter_input(INPUT_POST, 'txtNom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaissance = filter_input(INPUT_POST, 'txtDateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $race = filter_input(INPUT_POST, 'txtRace', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ($ifce && $nom && $dateNaissance && $race) {
                if (ajouterCheval($ifce, $nom, $dateNaissance, $race)) {
                    $message = "Cheval ajouté avec succès";
                } else {
                    $message = "Erreur lors de l'ajout";
                }
            } else {
                $message = "Données invalides";
            }
            $chevaux = obtenirChevaux();
            include '../views/vChevaux.php';
        }
        break;
        
    case 'supprimer':
        $ifce = filter_input(INPUT_GET, 'ifce', FILTER_VALIDATE_INT);
        if ($ifce) {
            if (supprimerCheval($ifce)) {
                header('Location: cChevaux.php?message=Cheval supprimé avec succès');
            } else {
                header('Location: cChevaux.php?message=Erreur lors de la suppression');
            }
            exit();
        }
        break;
        
    case 'modifier':
        $ifce = filter_input(INPUT_GET, 'ifce', FILTER_VALIDATE_INT);
        if ($ifce) {
            $cheval = obtenirChevalParIFCE($ifce);
            if ($cheval) {
                include '../views/vModifierCheval.php';
                exit();
            }
        }
        header('Location: cChevaux.php');
        break;
        
    case 'mettreAJourCheval':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ifce = filter_input(INPUT_POST, 'hdIFCE', FILTER_VALIDATE_INT);
            $nom = filter_input(INPUT_POST, 'txtNom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaissance = filter_input(INPUT_POST, 'txtDateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $race = filter_input(INPUT_POST, 'txtRace', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ($ifce && $nom && $dateNaissance && $race) {
                if (modifierCheval($ifce, $nom, $dateNaissance, $race)) {
                    header('Location: cChevaux.php?message=Cheval modifié avec succès');
                } else {
                    header('Location: cChevaux.php?message=Erreur lors de la modification');
                }
                exit();
            }
        }
        header('Location: cChevaux.php');
        break;
        
    default:
        $chevaux = obtenirChevaux();
        include '../views/vChevaux.php';
        break;
}
?>