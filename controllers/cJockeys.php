<?php
require_once '../models/mJockeys.php';
require_once '../models/mConnexion.php';

session_start();
if (!isset($_SESSION['utilisateur']) || !estGestionnaireFederation()) {
    header('Location: cConnexion.php');
    exit();
}

$action = $_POST['action'] ?? $_GET['action'] ?? 'liste';

switch ($action) {
    case 'liste':
        $jockeys = obtenirJockeys();
        include '../views/vJockeys.php';
        break;
        
    case 'ajouter':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matricule = filter_input(INPUT_POST, 'txtMatricule', FILTER_VALIDATE_INT);
            $nom = filter_input(INPUT_POST, 'txtNom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaissance = filter_input(INPUT_POST, 'txtDateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $genre = filter_input(INPUT_POST, 'lstGenre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ($matricule && $nom && $dateNaissance && $genre) {
                if (ajouterJockey($matricule, $nom, $dateNaissance, $genre)) {
                    $message = "Jockey ajouté avec succès";
                } else {
                    $message = "Erreur lors de l'ajout";
                }
            } else {
                $message = "Données invalides";
            }
            $jockeys = obtenirJockeys();
            include '../views/vJockeys.php';
        }
        break;
        
    case 'supprimer':
        $matricule = filter_input(INPUT_GET, 'matricule', FILTER_VALIDATE_INT);
        if ($matricule) {
            if (supprimerJockey($matricule)) {
                header('Location: cJockeys.php?message=Jockey supprimé avec succès');
            } else {
                header('Location: cJockeys.php?message=Erreur lors de la suppression');
            }
            exit();
        }
        break;
        
    case 'modifier':
        $matricule = filter_input(INPUT_GET, 'matricule', FILTER_VALIDATE_INT);
        if ($matricule) {
            $jockey = obtenirJockeyParMatricule($matricule);
            if ($jockey) {
                include '../views/vModifierJockey.php';
                exit();
            }
        }
        header('Location: cJockeys.php');
        break;
        
    case 'mettreAJourJockey':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matricule = filter_input(INPUT_POST, 'hdMatricule', FILTER_VALIDATE_INT);
            $nom = filter_input(INPUT_POST, 'txtNom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dateNaissance = filter_input(INPUT_POST, 'txtDateNaissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $genre = filter_input(INPUT_POST, 'lstGenre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ($matricule && $nom && $dateNaissance && $genre) {
                if (modifierJockey($matricule, $nom, $dateNaissance, $genre)) {
                    header('Location: cJockeys.php?message=Jockey modifié avec succès');
                } else {
                    header('Location: cJockeys.php?message=Erreur lors de la modification');
                }
                exit();
            }
        }
        header('Location: cJockeys.php');
        break;
        
    default:
        $jockeys = obtenirJockeys();
        include '../views/vJockeys.php';
        break;
}
?>