<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer Participation</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .form-group { margin: 15px 0; }
        label { display: inline-block; width: 150px; }
        select, input { padding: 5px; width: 200px; }
        .btn { padding: 8px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>
    <?php include 'vMenu.php'; ?>
    
    <a href="cCourses.php?action=gererParticipants&id=<?php echo $idCourse; ?>" class="btn">← Retour</a>
    
    <h1>Créer une Participation</h1>
    
    <form method="post" action="cCourses.php?action=ajouterParticipation">
        <input type="hidden" name="hdIdCourse" value="<?php echo $idCourse; ?>">
        
        <div class="form-group">
            <label for="lstCheval">Cheval :</label>
            <select id="lstCheval" name="lstCheval" required>
                <option value="">Sélectionner un cheval</option>
                <?php foreach ($chevaux as $cheval): ?>
                <option value="<?php echo $cheval['IFCE']; ?>">
                    <?php echo htmlspecialchars($cheval['nom_cheval']); ?> (<?php echo htmlspecialchars($cheval['race_cheval']); ?>)
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="lstJockey">Jockey :</label>
            <select id="lstJockey" name="lstJockey" required>
                <option value="">Sélectionner un jockey</option>
                <?php foreach ($jockeys as $jockey): ?>
                <option value="<?php echo $jockey['matricule_jockey']; ?>">
                    <?php echo htmlspecialchars($jockey['nom_jockey']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="txtNumDossard">Numéro de dossard :</label>
            <input type="number" id="txtNumDossard" name="txtNumDossard" min="1" required>
        </div>
        
        <input type="submit" value="Créer la participation" class="btn">
    </form>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>