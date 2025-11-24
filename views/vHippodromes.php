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
    </style>
</head>
<body>
    <?php include 'vMenu.php'; ?>
    
    <h1>Hippodromes</h1>
    
    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
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
        <input type="submit" value="Ajouter">
    </form>
    
    <h2>Liste des hippodromes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Localisation</th>
            <th>Capacité</th>
        </tr>
        <?php foreach ($hippodromes as $hippodrome): ?>
        <tr>
            <td><?php echo htmlspecialchars($hippodrome['id_hippodrome']); ?></td>
            <td><?php echo htmlspecialchars($hippodrome['localisation_hippodrome']); ?></td>
            <td><?php echo htmlspecialchars($hippodrome['capacite_hippodrome']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>