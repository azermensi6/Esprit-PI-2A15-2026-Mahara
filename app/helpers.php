<?php
/**
 * Petites fonctions utilisées par la navbar (front) et la sidebar (back)
 * pour afficher automatiquement le lien de la page courante.
 */

/** 'active' si $page est la page courante */
function isActive(string $page, string $currentPage): string
{
    return $page === $currentPage ? 'active' : '';
}

/** 'show' si la page courante fait partie du sous-menu (sous-menu ouvert) */
function isOpen(array $pages, string $currentPage): string
{
    return in_array($currentPage, $pages, true) ? 'show' : '';
}

/** 'collapsed' si la page courante n'est PAS dans le sous-menu (flèche fermée) */
function isCollapsed(array $pages, string $currentPage): string
{
    return in_array($currentPage, $pages, true) ? '' : 'collapsed';
}

/** 'true' / 'false' pour l'attribut aria-expanded du sous-menu */
function groupIsExpanded(array $pages, string $currentPage): string
{
    return in_array($currentPage, $pages, true) ? 'true' : 'false';
}

/* ---------- Authentification (session) ---------- */

/** Utilisateur connecté (id, nom, prenom, role) ou null */
function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function isLoggedIn(): bool
{
    return currentUser() !== null;
}

/** Enregistre l'utilisateur dans la session après connexion / inscription */
function loginUser(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id'     => (int) $user['id_utilisateur'],
        'nom'    => $user['nom'],
        'prenom' => $user['prenom'],
        'role'   => $user['role'],
    ];
}

/** Page de retour après connexion : uniquement une page front connue (pas d'URL externe) */
function safeRedirectPage(?string $page): string
{
    $routes = require __DIR__ . '/routes.php';
    return ($page !== null && isset($routes[$page])) ? $page : 'accueil';
}
