<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Résultats Course</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .podium-1 { background-color: #ffd700; }
        .podium-2 { background-color: #c0c0c0; }
        .podium-3 { background-color: #cd7f32; }
        .btn { padding: 5px 10px; text-decoration: none; background: #007bff; color: white; border-radius: 3px; }
    </style>
</head>
<body>
    <?php include 'vMenu.php'; ?>
    
    <a href="cCourses.php" class="btn">← Retour aux courses</a>
    
    <h1>Résultats de la Course</h1>
    
    <?php if (empty($resultats)): ?>
        <p>Aucun participant ou résultat.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Position</th>
                <th>Dossard</th>
                <th>Cheval</th>
                <th>Jockey</th>
                <th>Temps (secondes)</th>
                <?php if (isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 0): ?>
                    <th>Saisir temps</th>
                <?php endif; ?>
            </tr>
            <?php 
            $position = 1;
            foreach ($resultats as $resultat): 
                $classe = '';
                if ($position === 1 && $resultat['temps']) $classe = 'podium-1';
                elseif ($position === 2 && $resultat['temps']) $classe = 'podium-2';
                elseif ($position === 3 && $resultat['temps']) $classe = 'podium-3';
            ?>
            <tr class="<?php echo $classe; ?>">
                <td>
                    <?php if ($resultat['temps']): ?>
                        <?php echo $position; ?>
                        <?php $position++; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($resultat['num_dossard']); ?></td>
                <td><?php echo htmlspecialchars($resultat['nom_cheval']); ?></td>
                <td><?php echo htmlspecialchars($resultat['nom_jockey']); ?></td>
                <td>
                    <?php if ($resultat['temps']): ?>
                        <?php echo htmlspecialchars($resultat['temps']); ?>
                    <?php else: ?>
                        <span style="color: red;">Non saisi</span>
                    <?php endif; ?>
                </td>
                <?php if (isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] == 0): ?>
                <td>
                    <form onsubmit="enregistrerTemps(event, <?php echo $resultat['id_equipe']; ?>)">
                        <input type="hidden" name="hdIdCourse" value="<?php echo $idCourse; ?>">
                        <input type="hidden" name="hdIdEquipe" value="<?php echo $resultat['id_equipe']; ?>">
                        <input type="number" name="txtTemps" placeholder="Temps" min="1" style="width: 80px;">
                        <button type="submit">OK</button>
                    </form>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <script>
        function enregistrerTemps(event, idEquipe) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('cCourses.php?action=enregistrerTemps', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(message => {
                alert('Temps enregistré !');
                location.reload();
            });
        }
        </script>
    <?php endif; ?>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>