<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Chevaux</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        .form-group { margin: 10px 0; }
        label { display: inline-block; width: 150px; }
    </style>
</head>
<body>
    <?php include 'vMenu.php'; ?>
    
    <h1>Chevaux</h1>
    
    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <h2>Ajouter un cheval</h2>
    <form method="post" action="cChevaux.php">
        <input type="hidden" name="action" value="ajouter">
        <div class="form-group">
            <label for="txtIFCE">Numéro IFCE :</label>
            <input type="number" id="txtIFCE" name="txtIFCE" required>
        </div>
        <div class="form-group">
            <label for="txtNom">Nom :</label>
            <input type="text" id="txtNom" name="txtNom" required>
        </div>
        <div class="form-group">
            <label for="txtDateNaissance">Date de naissance :</label>
            <input type="date" id="txtDateNaissance" name="txtDateNaissance" required>
        </div>
        <div class="form-group">
            <label for="txtRace">Race :</label>
            <input type="text" id="txtRace" name="txtRace" required>
        </div>
        <input type="submit" value="Ajouter">
    </form>
    
    <h2>Liste des chevaux</h2>
    <table>
        <tr>
            <th>IFCE</th>
            <th>Nom</th>
            <th>Date de naissance</th>
            <th>Race</th>
        </tr>
        <?php foreach ($chevaux as $cheval): ?>
        <tr>
            <td><?php echo htmlspecialchars($cheval['IFCE']); ?></td>
            <td><?php echo htmlspecialchars($cheval['nom_cheval']); ?></td>
            <td><?php echo htmlspecialchars($cheval['dateNaissance_cheval']); ?></td>
            <td><?php echo htmlspecialchars($cheval['race_cheval']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>