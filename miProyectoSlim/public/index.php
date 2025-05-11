<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response) {
    $db = new SQLite3(__DIR__ . '/../config/music.db');
    $resultado = $db->query('SELECT * FROM artista');

    $htmlContent = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <title>Artistas</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                    margin: 0;
                    padding: 0;
                }

                h2 {
                    text-align: center;
                    margin-top: 20px;
                    font-size: 36px;
                    color: #2c3e50;
                }

                .container {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                    gap: 20px;
                    padding: 20px;
                    margin: 0 10px;
                }

                .artist-card {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    transition: transform 0.3s ease-in-out;
                }

                .artist-card:hover {
                    transform: translateY(-10px);
                }

                .artist-photo {
                    width: 150px;
                    height: auto;
                    border-radius: 8px;
                    margin-bottom: 15px;
                }

                .artist-name {
                    font-size: 24px;
                    font-weight: bold;
                    color: #3498db;
                    margin-bottom: 10px;
                }

                .artist-debut {
                    font-size: 18px;
                    color: #7f8c8d;
                    margin-bottom: 10px;
                }

                .music-link {
                    display: inline-block;
                    margin-top: 10px;
                    padding: 8px 16px;
                    background-color: #3498db;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }

                .music-link:hover {
                    background-color: #2980b9;
                }
            </style>
        </head>
        <body>
            <h2>Artistas</h2>
            <div class='container'>";

    while ($artista = $resultado->fetchArray(SQLITE3_ASSOC)) {
        $htmlContent .= "<div class='artist-card'>
            <img src='" . htmlspecialchars($artista['art_foto']) . "' alt='Foto de " . htmlspecialchars($artista['art_nombreArtistico']) . "' class='artist-photo'/>
            <div class='artist-name'>" . htmlspecialchars($artista['art_nombreArtistico']) . "</div>
            <div class='artist-debut'>Año debut: " . htmlspecialchars($artista['art_anioDebut']) . "</div>
            <a class='music-link' href='musica.php?id=" . urlencode($artista['art_id']) . "'>Ver música</a>
        </div>";
    }

    $htmlContent .= "</div>
        </body>
        </html>";

    $response->getBody()->write($htmlContent);
    return $response->withHeader('Content-Type', 'text/html');
});

$app->run();
?>
