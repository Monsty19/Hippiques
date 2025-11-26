<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Course</title>
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
    
    <a href="cCourses.php" class="btn btn-secondary">← Retour aux courses</a>
    
    <h1>Modifier la Course</h1>
    
    <form method="post" action="cCourses.php?action=mettreAJourCourse">
        <input type="hidden" name="hdIdCourse" value="<?php echo $course['id_course']; ?>">
        
        <div class="form-group">
            <label for="txtDateCourse">Date et heure :</label>
            <input type="datetime-local" id="txtDateCourse" name="txtDateCourse" 
                   value="<?php echo date('Y-m-d\TH:i', strtotime($course['date_course'])); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="lstHippodrome">Hippodrome :</label>
            <select id="lstHippodrome" name="lstHippodrome" required>
                <option value="">Sélectionner</option>
                <?php 
                $hippodromes = obtenirHippodromes();
                foreach ($hippodromes as $hippodrome): 
                ?>
                <option value="<?php echo $hippodrome['id_hippodrome']; ?>" 
                    <?php echo ($hippodrome['id_hippodrome'] == $course['id_hippodrome']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($hippodrome['localisation_hippodrome']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <input type="submit" value="Modifier la course" class="btn btn-primary">
    </form>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>