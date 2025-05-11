<?php
 include(__DIR__ . '/../includes/header.php');

// Conectar a la base de datos
$db = new SQLite3(__DIR__ . '/../config/music.db');

// Obtener el ID del artista desde la URL
$artistaId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($artistaId <= 0) {
    echo "ID de artista no válido.";
    exit;
}

// Obtener nombre del artista
$artistaStmt = $db->prepare('SELECT art_nombreArtistico FROM artista WHERE art_id = :id');
$artistaStmt->bindValue(':id', $artistaId, SQLITE3_INTEGER);
$artistaResult = $artistaStmt->execute()->fetchArray(SQLITE3_ASSOC);

if (!$artistaResult) {
    echo "Artista no encontrado.";
    exit;
}

$nombreArtista = htmlspecialchars($artistaResult['art_nombreArtistico']);

// Obtener canciones del artista
$cancionesStmt = $db->prepare('SELECT * FROM cancion WHERE can_artistaId = :id');
$cancionesStmt->bindValue(':id', $artistaId, SQLITE3_INTEGER);
$canciones = $cancionesStmt->execute();

// Obtener álbumes del artista
$albumesStmt = $db->prepare('SELECT * FROM album WHERE alb_artistaId = :id');
$albumesStmt->bindValue(':id', $artistaId, SQLITE3_INTEGER);
$albumes = $albumesStmt->execute();

// Iniciar HTML
echo "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>$nombreArtista - Música y Álbumes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            padding: 20px;
        }

        h2, h3 {
            text-align: center;
            color: #2c3e50;
        }

        .section {
            margin: 30px auto;
            max-width: 900px;
        }

        .song, .album {
            background-color: #fff;
            margin: 15px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .song-title, .album-title {
            font-size: 20px;
            color: #2980b9;
            font-weight: bold;
        }

        .song-details, .album-details {
            margin-top: 8px;
            color: #555;
        }

        .youtube-link {
            display: inline-block;
            margin-top: 10px;
            background-color: #e74c3c;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        .youtube-link:hover {
            background-color: #c0392b;
        }

        .album-cover {
            width: 100px;
            height: auto;
            border-radius: 6px;
            margin-right: 15px;
        }

        .album-container {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    
    <h2>$nombreArtista</h2>

    <div class='section'>
        <h3>Canciones</h3>";

while ($cancion = $canciones->fetchArray(SQLITE3_ASSOC)) {
    $titulo = htmlspecialchars($cancion['can_title']);
    $fecha = htmlspecialchars($cancion['can_fecha']);
    $genero = htmlspecialchars($cancion['can_genero']);
    $reproducciones = htmlspecialchars($cancion['can_reproducciones']);
    $urlYoutube = htmlspecialchars($cancion['can_urlYoutube']);
    $contexto = htmlspecialchars($cancion['can_contexto']);

    echo "<div class='song'>
        <div class='song-title'>$titulo</div>
        <div class='song-details'>
            Fecha: $fecha<br>
            Género ID: $genero<br>
            Reproducciones: $reproducciones<br>
            Contexto: $contexto
        </div>";

    if (!empty($urlYoutube)) {
        echo "<a class='youtube-link' href='$urlYoutube' target='_blank'>Escuchar en YouTube</a>";
    }

    echo "</div>";
}
echo "</div><div class='section'>
        <h3>Álbumes</h3>";

while ($album = $albumes->fetchArray(SQLITE3_ASSOC)) {
    $nombre = htmlspecialchars($album['alb_nombre']);
    $fecha = htmlspecialchars($album['alb_fecha']);
    $foto = htmlspecialchars($album['alb_foto']);

    echo "<div class='album'>
        <div class='album-container'>
            <img src='$foto' alt='Portada del álbum' class='album-cover'/>
            <div>
                <div class='album-title'>$nombre</div>
                <div class='album-details'>Fecha: $fecha</div>
            </div>
        </div>
    </div>";
}

echo "</div></body></html>";
?>
