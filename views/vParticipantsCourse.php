<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Participants Course</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .btn { padding: 8px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 3px; }
    </style>
</head>
<body>
    <?php include 'vMenu.php'; ?>
    
    <a href="cCourses.php" class="btn">← Retour aux courses</a>
    
    <h1>Participants de la Course</h1>
    
    <?php if (isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 0): ?>
    <a href="cCourses.php?action=creerParticipation&id=<?php echo $idCourse; ?>" class="btn">
        + Ajouter un participant
    </a>
    <?php endif; ?>
    
    <h2>Liste des participants</h2>
    <?php if (empty($participants)): ?>
        <p>Aucun participant inscrit.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Dossard</th>
                <th>Cheval</th>
                <th>Jockey</th>
                <th>Temps</th>
            </tr>
            <?php foreach ($participants as $participant): ?>
            <tr>
                <td><?php echo htmlspecialchars($participant['num_dossard']); ?></td>
                <td><?php echo htmlspecialchars($participant['nom_cheval']); ?></td>
                <td><?php echo htmlspecialchars($participant['nom_jockey']); ?></td>
                <td>
                    <?php if ($participant['temps']): ?>
                        <?php echo htmlspecialchars($participant['temps']); ?>s
                    <?php else: ?>
                        Non renseigné
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>