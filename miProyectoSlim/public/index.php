<?php 
use Slim\Factory\AppFactory;
// public/index.php
require __DIR__ . '/../app/routes.php';

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/miProyectoSlim/public"); // Asegúrate de esto si es necesario

// Middleware de errores
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Ruta correcta
$app->get('/artistas', [\app\Controllers\ArtistaController::class, 'index']);

$app->run();
?>