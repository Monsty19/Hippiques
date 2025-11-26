<?php
function connecterBaseDeDonnees() { 
    try {
        $base = new PDO('mysql:host=localhost;dbname=hippiques;charset=utf8', 'root', '');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $base;
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}
?>