<?php
/**
 * Point d'entrée unique de Mahara.
 * Exemple : index.php?page=missions  ->  App\Controllers\MissionsController::index()
 */
session_start();
require_once __DIR__ . '/app/helpers.php';

// Chargement automatique des classes : App\Controllers\X -> app/Controllers/X.php
spl_autoload_register(function (string $class): void {
    $relative = str_replace(['App\\', '\\'], ['', '/'], $class);
    $file = __DIR__ . '/app/' . $relative . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

$routes = require __DIR__ . '/app/routes.php';
$page   = $_GET['page'] ?? 'accueil';

if (!isset($routes[$page])) {
    http_response_code(404);
    $controller = 'ErreurController';
} else {
    $controller = $routes[$page];
}

$class = 'App\\Controllers\\' . $controller;
(new $class())->index();
