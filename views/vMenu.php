<nav style="background: #f8f9fa; padding: 10px; margin-bottom: 20px; border-bottom: 1px solid #dee2e6;">
    <?php if (isset($_SESSION['utilisateur'])): ?>
        
        <?php if ($_SESSION['type_utilisateur'] == 1): ?>
            <!-- Menu Gestionnaire Fédération -->
            <a href="cHippodromes.php">Hippodromes</a> |
            <a href="cChevaux.php">Chevaux</a> |
            <a href="cJockeys.php">Jockeys</a> |
            <a href="cCourses.php">Courses</a> |
        <?php else: ?>
            <!-- Menu Gestionnaire Hippodrome -->
            <a href="cCourses.php">Courses</a> |
        <?php endif; ?>
        
        <span style="float: right;">
            <strong>Connecté en tant que :</strong> 
            <?php echo htmlspecialchars($_SESSION['utilisateur']); ?>
            (<?php echo ($_SESSION['type_utilisateur'] == 1) ? 'Fédération' : 'Hippodrome'; ?>)
            | <a href="cConnexion.php?action=deconnexion">Déconnexion</a>
        </span>
        
    <?php endif; ?>
</nav>