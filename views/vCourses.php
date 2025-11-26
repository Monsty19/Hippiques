<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Courses</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .form-group { margin: 10px 0; }
        label { display: inline-block; width: 150px; }
        .btn { 
            padding: 5px 10px; 
            text-decoration: none; 
            color: white; 
            border-radius: 3px; 
            margin: 2px;
            display: inline-block;
            font-size: 14px;
        }
        .btn-primary { background: #007bff; }
        .btn-success { background: #28a745; }
        .btn-warning { background: #ffc107; color: black; }
        .btn-danger { background: #dc3545; }
    </style>
</head>
<body>
    <?php include 'vMenu.php'; ?>
    
    <h1>Courses</h1>
    
    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>
    
    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 0): ?> 
    <h2>Ajouter une course</h2>
    <form method="post" action="cCourses.php">
        <input type="hidden" name="action" value="ajouter">
        <div class="form-group">
            <label for="txtDateCourse">Date et heure :</label>
            <input type="datetime-local" id="txtDateCourse" name="txtDateCourse" required>
        </div>
        <div class="form-group">
            <label for="lstHippodrome">Hippodrome :</label>
            <select id="lstHippodrome" name="lstHippodrome" required>
                <option value="">Sélectionner</option>
                <?php 
                $hippodromes = obtenirHippodromes();
                foreach ($hippodromes as $hippodrome): 
                ?>
                <option value="<?php echo $hippodrome['id_hippodrome']; ?>">
                    <?php echo htmlspecialchars($hippodrome['localisation_hippodrome']); ?>
                </option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="submit" value="Ajouter la course" class="btn btn-primary">
    </form>
    <?php endif; ?>
    
    <h2>Liste des courses</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Hippodrome</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($courses as $course): ?>
        <tr>
            <td><?php echo htmlspecialchars($course['id_course']); ?></td>
            <td><?php echo htmlspecialchars($course['date_course']); ?></td>
            <td><?php echo htmlspecialchars($course['localisation_hippodrome']); ?></td>
            <td>
                <a href="cCourses.php?action=gererParticipants&id=<?php echo $course['id_course']; ?>" class="btn btn-primary">
                    Participants
                </a>
                <?php if (isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 0): ?>
                    <a href="cCourses.php?action=saisirResultats&id=<?php echo $course['id_course']; ?>" class="btn btn-success">
                        Résultats
                    </a>
                    <a href="cCourses.php?action=modifierCourse&id=<?php echo $course['id_course']; ?>" class="btn btn-warning">
                        Modifier
                    </a>
                    <a href="cCourses.php?action=supprimer&id=<?php echo $course['id_course']; ?>" 
                       class="btn btn-danger" 
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette course ? Tous les participants et résultats seront également supprimés.')">
                        Supprimer
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>