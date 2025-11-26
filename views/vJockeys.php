<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Jockeys</title>
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
        .btn-warning { background: #ffc107; color: black; }
        .btn-danger { background: #dc3545; }
    </style>
</head>
<body>
    <?php include 'vMenu.php'; ?>
    
    <h1>Jockeys</h1>
    
    <?php if (isset($_GET['message'])): ?>
        <p style="color: green;"><?php echo htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>
    
    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <h2>Ajouter un jockey</h2>
    <form method="post" action="cJockeys.php">
        <input type="hidden" name="action" value="ajouter">
        <div class="form-group">
            <label for="txtMatricule">Matricule :</label>
            <input type="number" id="txtMatricule" name="txtMatricule" required>
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
            <label for="lstGenre">Genre :</label>
            <select id="lstGenre" name="lstGenre" required>
                <option value="">Sélectionner</option>
                <option value="M">Masculin</option>
                <option value="F">Féminin</option>
            </select>
        </div>
        <input type="submit" value="Ajouter" class="btn btn-primary">
    </form>
    
    <h2>Liste des jockeys</h2>
    <table>
        <tr>
            <th>Matricule</th>
            <th>Nom</th>
            <th>Date de naissance</th>
            <th>Genre</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($jockeys as $jockey): ?>
        <tr>
            <td><?php echo htmlspecialchars($jockey['matricule_jockey']); ?></td>
            <td><?php echo htmlspecialchars($jockey['nom_jockey']); ?></td>
            <td><?php echo htmlspecialchars($jockey['dateNaissance_jockey']); ?></td>
            <td><?php echo htmlspecialchars($jockey['genre_jockey']); ?></td>
            <td>
                <a href="cJockeys.php?action=modifier&matricule=<?php echo $jockey['matricule_jockey']; ?>" class="btn btn-warning">
                    Modifier
                </a>
                <a href="cJockeys.php?action=supprimer&matricule=<?php echo $jockey['matricule_jockey']; ?>" 
                   class="btn btn-danger" 
                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce jockey ?')">
                    Supprimer
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <?php include 'vFooter.php'; ?>
</body>
</html>