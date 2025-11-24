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
        
    default:
        $chevaux = obtenirChevaux();
        include '../views/vChevaux.php';
        break;
}
?>