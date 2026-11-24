<?php

namespace App\Controllers;

use Database;
use PDO;

/**
 * Contrôleur de base : connexion à la base ($this->db) et affichage des vues.
 * Chaque contrôleur hérite de cette classe.
 */
abstract class Controller
{
    /** Connexion PDO partagée (Singleton de config/database.php) */
    protected PDO $db;

    /** Clé de la page courante, utilisée par la navbar / sidebar pour l'état actif */
    protected string $page = 'dashboard';

    /** Titre affiché dans <title> (back office) */
    protected string $title = 'Mahara Admin';

    public function __construct()
    {
        $this->db = Database::getConnexion();
    }

    /**
     * Back office : rend une vue (app/Views/back/pages/{$view}.php) dans le layout commun.
     * Filet de sécurité : aucune page du back office ne s'affiche sans le rôle admin.
     */
    protected function render(string $view, array $data = [], ?string $scriptsView = null): void
    {
        AuthController::requireRole('admin');

        $data['csrfToken'] = AuthController::getCsrfToken();
        $content      = $this->capture(__DIR__ . '/../Views/back/pages/' . $view . '.php', $data);
        $extraScripts = $scriptsView
            ? $this->capture(__DIR__ . '/../Views/back/pages/' . $scriptsView . '.php', $data)
            : '';

        $title       = $this->title;
        $currentPage = $this->page;

        require_once __DIR__ . '/../Views/back/layout.php';
    }

    /** Back office : page complète sans layout (ex : connexion admin) */
    protected function renderStandalone(string $view, array $data = []): void
    {
        $data['csrfToken'] = AuthController::getCsrfToken();
        extract($data);
        $title       = $this->title;
        $currentPage = $this->page;
        require_once __DIR__ . '/../Views/back/pages/' . $view . '.php';
    }

    /**
     * Front office : la page (app/Views/front/{$view}.php) assemble elle-même
     * ses includes (head, spinner, navbar, footer, scripts).
     * Le jeton CSRF est transmis à toutes les vues : $csrfToken.
     */
    protected function renderFront(string $view, array $data = []): void
    {
        $data['csrfToken'] = AuthController::getCsrfToken();
        extract($data);
        require_once __DIR__ . '/../Views/front/' . $view . '.php';
    }

    /** Front office : réservé aux utilisateurs connectés (raccourci vers AuthController::requireAuth) */
    protected function requireLogin(string $page): void
    {
        AuthController::requireAuth($page);
    }

    /** Back office : réservé aux administrateurs. À appeler AVANT tout traitement. */
    protected function requireAdmin(): void
    {
        AuthController::requireRole('admin');
    }

    /** Redirige vers index.php?page=$page (avec d'éventuels paramètres) et arrête le script */
    protected function redirect(string $page, array $params = []): never
    {
        header('Location: index.php?' . http_build_query(['page' => $page] + $params));
        exit;
    }

    /** Exécute une vue et renvoie son HTML sous forme de texte (ob_start / ob_get_clean) */
    protected function capture(string $file, array $data = []): string
    {
        extract($data);
        ob_start();
        require $file;
        return ob_get_clean();
    }
}
