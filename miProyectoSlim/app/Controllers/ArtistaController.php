<?php
namespace app\Controllers;

use app\Models\Artista;

class ArtistaController {
    public function index($request, $response, $args) {
        $artistas = Artista::Info();

        // Mostrar vista
        ob_start();
        include __DIR__ . '/../Views/artistas.php';
        $html = ob_get_clean();

        $response->getBody()->write($html);
        return $response;
    }
}

?>