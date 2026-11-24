<?php
/**
 * Petites fonctions d'affichage utilisées par les vues (navbar, sidebar, formulaires).
 * Aucune requête SQL ici : la logique métier est dans les contrôleurs.
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

/* ---------- Lecture de la session (remplie par AuthController à la connexion) ---------- */

/** Utilisateur connecté ['id', 'nom', 'prenom', 'email', 'role'] ou null */
function currentUser(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }
    return [
        'id'     => (int) $_SESSION['user_id'],
        'nom'    => $_SESSION['nom'] ?? '',
        'prenom' => $_SESSION['prenom'] ?? '',
        'email'  => $_SESSION['email'] ?? '',
        'role'   => $_SESSION['role'] ?? '',
    ];
}

function isLoggedIn(): bool
{
    return !empty($_SESSION['user_id']);
}

function isAdmin(): bool
{
    return isLoggedIn() && ($_SESSION['role'] ?? null) === 'admin';
}

/** Page de retour après connexion : uniquement une page connue (pas d'URL externe) */
function safeRedirectPage(?string $page): string
{
    $routes = require __DIR__ . '/routes.php';
    return ($page !== null && isset($routes[$page])) ? $page : 'accueil';
}

/* ---------- Saisie et affichage ---------- */

/**
 * Lit un champ texte de $_POST ou $_GET sans risque d'erreur fatale.
 * Renvoie '' si le champ est absent ou si ce n'est pas du texte (ex : nom[]=x envoyé comme tableau).
 * $trim = false pour les mots de passe (les espaces en font partie).
 */
function input(array $source, string $key, bool $trim = true): string
{
    $valeur = $source[$key] ?? '';
    if (!is_string($valeur)) {
        return '';
    }
    return $trim ? trim($valeur) : $valeur;
}

/** Échappe un texte avant de l'afficher dans le HTML (protection contre les failles XSS) */
function e(mixed $valeur): string
{
    return htmlspecialchars((string) $valeur, ENT_QUOTES, 'UTF-8');
}

/** Message affiché une seule fois, après une redirection */
function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function takeFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/** Date MySQL (AAAA-MM-JJ ...) -> JJ/MM/AAAA, ou '—' si vide */
function dateFr(?string $date, bool $heure = false): string
{
    if ($date === null || $date === '') {
        return '—';
    }
    return date($heure ? 'd/m/Y H:i' : 'd/m/Y', strtotime($date));
}
