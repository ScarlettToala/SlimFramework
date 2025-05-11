<!DOCTYPE html>
<html>
<head>
    <title>Lista de Artistas</title>
</head>
<body>
    <h1>Artistas</h1>
    <ul>
        <?php foreach ($artistas as $artista): ?>
            <li>
                <?= htmlspecialchars($artista['art_nombreArtistico']) ?> (<?= $artista['art_anioDebut'] ?>)
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

<?php
include("/workspaces/SlimFramework/miProyectoSlim/error/error.php");
?>