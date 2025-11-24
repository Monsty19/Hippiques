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
        
    default:
        $hippodromes = obtenirHippodromes();
        include '../views/vHippodromes.php';
        break;
}
?>