<?php

namespace App\Controllers;

/**
 * Back office : tableau de bord et pages d'administration simples (listes et formulaires) des modules P1 à P5.
 * Chaque méthode correspond à une route de app/routes.php.
 */
class AdminController extends Controller
{
    /** Définit la page active et le titre, puis rend la vue app/Views/back/pages/{$view}.php */
    private function afficher(string $page, string $title, string $view): void
    {
        $this->page  = $page;
        $this->title = $title . ' | Mahara Admin';
        $this->render($view);
    }

    // ---------- Général ----------

    public function dashboard(): void
    {
        $this->afficher('dashboard', 'Tableau de bord', 'dashboard');
    }

    public function blankPage(): void
    {
        $this->afficher('blank-page', 'Page vide', 'blank-page');
    }

    // ---------- P1 · Portfolio ----------

    public function competences(): void
    {
        $this->afficher('admin-competences', 'Compétences', 'competences');
    }

    public function competenceForm(): void
    {
        $this->afficher('admin-competence-form', 'Ajouter une compétence', 'competence-form');
    }

    public function realisations(): void
    {
        $this->afficher('admin-realisations', 'Réalisations', 'realisations');
    }

    public function realisationForm(): void
    {
        $this->afficher('admin-realisation-form', 'Modifier une réalisation', 'realisation-form');
    }

    // ---------- P2 · Missions ----------

    public function categories(): void
    {
        $this->afficher('admin-categories', 'Catégories', 'categories');
    }

    public function categorieForm(): void
    {
        $this->afficher('admin-categorie-form', 'Ajouter une catégorie', 'categorie-form');
    }

    public function missions(): void
    {
        $this->afficher('admin-missions', 'Missions', 'missions');
    }

    public function missionForm(): void
    {
        $this->afficher('admin-mission-form', 'Ajouter une mission', 'mission-form');
    }

    // ---------- P3 · Recrutement ----------

    public function entreprises(): void
    {
        $this->afficher('admin-entreprises', 'Entreprises', 'entreprises');
    }

    public function entrepriseForm(): void
    {
        $this->afficher('admin-entreprise-form', 'Vérifier une entreprise', 'entreprise-form');
    }

    // ---------- P4 · Paiements ----------

    public function paiements(): void
    {
        $this->afficher('admin-paiements', 'Paiements', 'paiements');
    }

    public function paiementForm(): void
    {
        $this->afficher('admin-paiement-form', 'Modifier un paiement', 'paiement-form');
    }

    // ---------- P5 · Formations ----------

    public function categoriesFormation(): void
    {
        $this->afficher('admin-categories-formation', 'Catégories de formation', 'categories-formation');
    }

    public function categorieFormationForm(): void
    {
        $this->afficher('admin-categorie-formation-form', 'Ajouter une catégorie de formation', 'categorie-formation-form');
    }

    public function formations(): void
    {
        $this->afficher('admin-formations', 'Formations', 'formations');
    }

    public function formationForm(): void
    {
        $this->afficher('admin-formation-form', 'Ajouter une formation', 'formation-form');
    }
}
