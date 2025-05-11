<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/ping', function ($request, $response, $args) {
    $response->getBody()->write("pong");
    return $response;
});

$app->setBasePath('/miProyectoSlim/public'); // Asegúrate que este path sea correcto

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->get('/artistas', [\app\Controllers\ArtistaController::class, 'index']);

$app->run();
