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
