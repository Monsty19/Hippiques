<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        body { font-family: Arial; margin: 50px; }
        .login-form { max-width: 300px; margin: 0 auto; }
        .form-group { margin: 10px 0; }
        label { display: inline-block; width: 100px; }
        input[type="submit"] { padding: 10px 20px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="login-form">
        <h1>Connexion</h1>
        
        <?php if (isset($messageErreur)): ?>
            <p style="color: red;"><?php echo $messageErreur; ?></p>
        <?php endif; ?>
        
        <form method="post" action="cConnexion.php">
            <div class="form-group">
                <label for="txtIdentifiant">Identifiant :</label>
                <input type="text" id="txtIdentifiant" name="txtIdentifiant" required>
            </div>
            <div class="form-group">
                <label for="txtMotDePasse">Mot de passe :</label>
                <input type="password" id="txtMotDePasse" name="txtMotDePasse" required>
            </div>
            <input type="submit" name="cmdConnexion" value="Se connecter">
        </form>
        
        <p>Comptes de test :<br>
        <strong>Admin (Fédération):</strong> admin / test<br>
        <strong>Gestionnaire (Hippodrome):</strong> gest / test</p>
    </div>
</body>
</html>