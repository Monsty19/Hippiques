<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Hippodromes</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .form-group { margin: 10px 0; }
        label { display: inline-block; width: 100px; }
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
        .btn-warning { background: #ffc107; color: black; }
        .btn-danger { background: #dc3545; }
        .btn-disabled { background: #6c757d; cursor: not-allowed; }
        .message-erreur { color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 4px; margin: 10px 0; }
        .message-succes { color: #155724; background: #d4edda; padding: 10px; border-radius: 4px; margin: 10px 0; }
    </style>
</head>
<body>
    <?php include 'vMenu.php'; ?>
    
    <h1>Hippodromes</h1>
    
    <?php if (isset($_GET['message'])): ?>
        <?php if (strpos($_GET['message'], 'Impossible') !== false): ?>
            <div class="message-erreur">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php else: ?>
            <div class="message-succes">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php if (isset($message)): ?>
        <div class="message-succes">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    
    <h2>Ajouter un hippodrome</h2>
    <form method="post" action="cHippodromes.php">
        <input type="hidden" name="action" value="ajouter">
        <div class="form-group">
            <label for="txtLocalisation">Localisation :</label>
            <input type="text" id="txtLocalisation" name="txtLocalisation" required>
        </div>
        <div class="form-group">
            <label for="txtCapacite">Capacité :</label>
            <input type="number" id="txtCapacite" name="txtCapacite" required>
        </div>
        <input type="submit" value="Ajouter" class="btn btn-primary">
    </form>
    
    <h2>Liste des hippodromes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Localisation</th>
            <th>Capacité</th>
            <th>Actions</th>
        </tr>
        <?php 
        $hippodromes = obtenirHippodromes();
        foreach ($hippodromes as $hippodrome): 
            $peutSupprimer = hippodromePeutEtreSupprime($hippodrome['id_hippodrome']);
        ?>
        <tr>
            <td><?php echo htmlspecialchars($hippodrome['id_hippodrome']); ?></td>
            <td><?php echo htmlspecialchars($hippodrome['localisation_hippodrome']); ?></td>
            <td><?php echo htmlspecialchars($hippodrome['capacite_hippodrome']); ?></td>
            <td>
                <a href="cHippodromes.php?action=modifier&id=<?php echo $hippodrome['id_hippodrome']; ?>" class="btn btn-warning">
                    Modifier
                </a>
                <?php if ($peutSupprimer): ?>
                    <a href="cHippodromes.php?action=supprimer&id=<?php echo $hippodrome['id_hippodrome']; ?>" 
                       class="btn btn-danger" 
                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet hippodrome ?')">
                        Supprimer
                    </a>
                <?php else: ?>
                    <span class="btn btn-disabled" title="Impossible de supprimer : courses associées">
                        Supprimer
                    </span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>