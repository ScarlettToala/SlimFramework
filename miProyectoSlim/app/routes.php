<?php

use Slim\App;
use app\Controllers\ArtistaController;

return function (App $app) {
    $app->get('/artistas', [ArtistaController::class, 'index']);
};
