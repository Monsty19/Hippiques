<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Cheval</title>
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
    
    <a href="cChevaux.php" class="btn btn-secondary">← Retour</a>
    
    <h1>Modifier le Cheval</h1>
    
    <form method="post" action="cChevaux.php?action=mettreAJourCheval">
        <input type="hidden" name="hdIFCE" value="<?php echo $cheval['IFCE']; ?>">
        
        <div class="form-group">
            <label for="txtNom">Nom :</label>
            <input type="text" id="txtNom" name="txtNom" value="<?php echo htmlspecialchars($cheval['nom_cheval']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="txtDateNaissance">Date de naissance :</label>
            <input type="date" id="txtDateNaissance" name="txtDateNaissance" value="<?php echo $cheval['dateNaissance_cheval']; ?>" required>
        </div>
        
        <div class="form-group">
            <label for="txtRace">Race :</label>
            <input type="text" id="txtRace" name="txtRace" value="<?php echo htmlspecialchars($cheval['race_cheval']); ?>" required>
        </div>
        
        <input type="submit" value="Modifier le cheval" class="btn btn-primary">
    </form>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>