<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Jockey</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .form-group { margin: 15px 0; }
        label { display: inline-block; width: 150px; }
        .btn { 
            padding: 8px 15px; 
            text-decoration: none; 
            color: white; 
            border-radius: 3px; 
            border: none;
            cursor: pointer;
        }
        .btn-primary { background: #007bff; }
        .btn-secondary { background: #6c757d; }
    </style>
</head>
<body>
    <?php include 'vMenu.php'; ?>
    
    <a href="cJockeys.php" class="btn btn-secondary">← Retour</a>
    
    <h1>Modifier le Jockey</h1>
    
    <form method="post" action="cJockeys.php?action=mettreAJourJockey">
        <input type="hidden" name="hdMatricule" value="<?php echo $jockey['matricule_jockey']; ?>">
        
        <div class="form-group">
            <label for="txtNom">Nom :</label>
            <input type="text" id="txtNom" name="txtNom" value="<?php echo htmlspecialchars($jockey['nom_jockey']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="txtDateNaissance">Date de naissance :</label>
            <input type="date" id="txtDateNaissance" name="txtDateNaissance" value="<?php echo $jockey['dateNaissance_jockey']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="lstGenre">Genre :</label>
            <select id="lstGenre" name="lstGenre" required>
                <option value="M" <?php echo ($jockey['genre_jockey'] == 'M') ? 'selected' : ''; ?>>Masculin</option>
                <option value="F" <?php echo ($jockey['genre_jockey'] == 'F') ? 'selected' : ''; ?>>Féminin</option>
            </select>
        </div>
        
        <input type="submit" value="Modifier le jockey" class="btn btn-primary">
    </form>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>