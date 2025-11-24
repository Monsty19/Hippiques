<?php
require_once '../models/mConnexion.php';

session_start();

$action = $_POST['action'] ?? $_GET['action'] ?? 'connexion';

switch ($action) {
    case 'connexion':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $identifiant = filter_input(INPUT_POST, 'txtIdentifiant', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $motDePasse = filter_input(INPUT_POST, 'txtMotDePasse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if ($identifiant && $motDePasse) {
                $utilisateur = verifierConnexion($identifiant, $motDePasse);
                if ($utilisateur) {
                    $_SESSION['utilisateur'] = $identifiant;
                    $_SESSION['type_utilisateur'] = $utilisateur['type'];
                    
                    if ($utilisateur['type'] == 1) {
                        header('Location: cHippodromes.php');
                    } else {
                        header('Location: cCourses.php');
                    }
                    exit();
                } else {
                    $messageErreur = "Identifiant ou mot de passe incorrect";
                }
            } else {
                $messageErreur = "Veuillez remplir tous les champs";
            }
        }
        include '../views/vConnexion.php';
        break;
        
    case 'deconnexion':
        session_destroy();
        header('Location: cConnexion.php');
        exit();
        break;
        
    default:
        include '../views/vConnexion.php';
        break;
}
?>