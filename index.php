<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

if (isset($_SESSION['utilisateur'])) {
    if ($_SESSION['type_utilisateur'] == 1) {
        header('Location: controllers/cHippodromes.php');
    } else {
        header('Location: controllers/cCourses.php');
    }
} else {
    header('Location: controllers/cConnexion.php');
}
exit();
?>