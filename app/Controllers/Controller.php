<?php

namespace App\Controllers;

abstract class Controller
{
    /** Clé de la page courante, utilisée par la navbar / sidebar pour l'état actif */
    protected string $page = 'dashboard';

    /** Titre affiché dans <title> (back office) */
    protected string $title = 'Mahara Admin';

    /**
     * Back office : rend une vue de contenu (app/Views/back/pages/{$view}.php)
     * dans le layout commun.
     *
     * @param string      $view        nom du fichier de vue (sans .php) dans Views/back/pages
     * @param array       $data        variables à extraire dans la vue de contenu
     * @param string|null $scriptsView nom du fichier de script spécifique (sans .php) — optionnel
     */
    protected function render(string $view, array $data = [], ?string $scriptsView = null): void
    {
        $content      = $this->capture(__DIR__ . '/../Views/back/pages/' . $view . '.php', $data);
        $extraScripts = $scriptsView
            ? $this->capture(__DIR__ . '/../Views/back/pages/' . $scriptsView . '.php', $data)
            : '';

        $title       = $this->title;
        $currentPage = $this->page;

        require_once __DIR__ . '/../Views/back/layout.php';
    }

    /**
     * Back office : page complète sans layout (ex : connexion admin).
     */
    protected function renderStandalone(string $view, array $data = []): void
    {
        extract($data);
        $title       = $this->title;
        $currentPage = $this->page;
        require_once __DIR__ . '/../Views/back/pages/' . $view . '.php';
    }

    /**
     * Front office : la page (app/Views/front/{$view}.php) assemble elle-même
     * ses includes (head, spinner, navbar, footer, scripts) comme dans la partie 1 de l'atelier.
     */
    protected function renderFront(string $view, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . '/../Views/front/' . $view . '.php';
    }

    /**
     * Front office : réservé aux utilisateurs connectés.
     * Sinon, redirection vers la connexion puis retour sur $page après login.
     */
    protected function requireLogin(string $page): void
    {
        if (!isLoggedIn()) {
            header('Location: index.php?page=connexion&redirect=' . urlencode($page));
            exit;
        }
    }

    /** Exécute une vue et renvoie son HTML sous forme de texte */
    protected function capture(string $file, array $data = []): string
    {
        extract($data);
        ob_start();
        require $file;
        return ob_get_clean();
    }
}
