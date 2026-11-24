<?php
/**
 * index.php : point d'entrée unique de Mahara (front controller).
 * Exemple : index.php?page=admin-utilisateurs  ->  UtilisateurController::liste()
 *
 * Ordre imposé par le workshop « Sessions et sécurité PHP » :
 *   1. configuration sécurisée de la session + session_start()
 *   2. expiration de la session après inactivité
 *   3. en-têtes HTTP de sécurité
 *   4. chargement des classes
 *   5. routage
 */
declare(strict_types=1);

// ---------- 1. Configuration sécurisée de la session ----------
ini_set('session.use_strict_mode', '1');    // refuse les identifiants de session inventés par un attaquant
ini_set('session.cookie_httponly', '1');    // cookie PHPSESSID invisible pour JavaScript (vol de session via XSS)
ini_set('session.cookie_samesite', 'Lax');  // cookie non envoyé depuis un site tiers (première barrière CSRF)
// ini_set('session.cookie_secure', '1');   // à décommenter si le site est servi en HTTPS
session_start();

// ---------- 2. Expiration après 30 minutes d'inactivité ----------
$sessionLifetime = 1800;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $sessionLifetime)) {
    $_SESSION = [];
    session_destroy();
    session_start();
}
$_SESSION['last_activity'] = time();

// ---------- 3. En-têtes HTTP de sécurité ----------
header('X-Frame-Options: DENY');                         // anti clickjacking
header('X-Content-Type-Options: nosniff');               // empêche le navigateur de deviner le type des fichiers
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; "    // limite le XSS : aucun script extérieur ni écrit dans la page
     . "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; "
     . "font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; "
     . "form-action 'self'; frame-ancestors 'none'; base-uri 'self'");

// ---------- 4. Chargement des classes ----------
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/app/helpers.php';

// App\Controllers\X -> app/Controllers/X.php ; App\Models\X -> app/Models/X.php
spl_autoload_register(function (string $class): void {
    $relative = str_replace(['App\\', '\\'], ['', '/'], $class);
    $file = __DIR__ . '/app/' . $relative . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

// ---------- 5. Routage ----------
// routes.php : 'page' => 'NomController' (méthode index) ou 'NomController@methode'
$routes = require __DIR__ . '/app/routes.php';
$page   = $_GET['page'] ?? 'accueil';

$route = (is_string($page) && isset($routes[$page])) ? $routes[$page] : null;
[$controller, $method] = $route !== null ? array_pad(explode('@', $route), 2, 'index') : ['PageController', 'erreur'];

$class = 'App\\Controllers\\' . $controller;
if (!class_exists($class) || !method_exists($class, $method)) {
    $class  = 'App\\Controllers\\PageController';   // page introuvable : erreur() envoie le code 404
    $method = 'erreur';
}

(new $class())->$method();
