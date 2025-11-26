<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Hippodrome</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .form-group { margin: 15px 0; }
        label { display: inline-block; width: 100px; }
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
    
    <a href="cHippodromes.php" class="btn btn-secondary">← Retour</a>
    
    <h1>Modifier l'Hippodrome</h1>
    
    <form method="post" action="cHippodromes.php?action=mettreAJourHippodrome">
        <input type="hidden" name="hdIdHippodrome" value="<?php echo $hippodrome['id_hippodrome']; ?>">
        
        <div class="form-group">
            <label for="txtLocalisation">Localisation :</label>
            <input type="text" id="txtLocalisation" name="txtLocalisation" value="<?php echo htmlspecialchars($hippodrome['localisation_hippodrome']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="txtCapacite">Capacité :</label>
            <input type="number" id="txtCapacite" name="txtCapacite" value="<?php echo htmlspecialchars($hippodrome['capacite_hippodrome']); ?>" required>
        </div>
        
        <input type="submit" value="Modifier l'hippodrome" class="btn btn-primary"> 
    </form>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>