<?php

namespace App\Controllers;

/**
 * Front office : pages simples (sans traitement de formulaire) des modules P1 à P5.
 * Chaque méthode correspond à une route de app/routes.php.
 */
class PageController extends Controller
{
    /** Page réservée aux membres connectés : vérifie la connexion puis rend app/Views/front/{$page}.php */
    private function afficherMembre(string $page): void
    {
        $this->requireLogin($page);
        $this->renderFront($page);
    }

    // ---------- Pages publiques ----------

    public function accueil(): void
    {
        $this->renderFront('accueil');
    }

    /** Page introuvable : utilisée par index.php quand la route ou la méthode n'existe pas */
    public function erreur(): void
    {
        http_response_code(404);
        $this->renderFront('404');
    }

    // ---------- P1 · Portfolio ----------

    public function portfolio(): void
    {
        $this->afficherMembre('portfolio');
    }

    public function ajouterRealisation(): void
    {
        $this->afficherMembre('ajouter-realisation');
    }

    // ---------- P2 · Missions ----------

    public function missions(): void
    {
        $this->afficherMembre('missions');
    }

    public function publierMission(): void
    {
        $this->afficherMembre('publier-mission');
    }

    public function mesMissions(): void
    {
        $this->afficherMembre('mes-missions');
    }

    // ---------- P3 · Recrutement ----------

    public function offres(): void
    {
        $this->afficherMembre('offres');
    }

    public function offreDetail(): void
    {
        $this->afficherMembre('offre-detail');
    }

    public function monEntreprise(): void
    {
        $this->afficherMembre('mon-entreprise');
    }

    public function publierOffre(): void
    {
        $this->afficherMembre('publier-offre');
    }

    // ---------- P4 · Candidatures et paiements ----------

    public function postuler(): void
    {
        $this->afficherMembre('postuler');
    }

    public function mesCandidatures(): void
    {
        $this->afficherMembre('mes-candidatures');
    }

    public function candidaturesRecues(): void
    {
        $this->afficherMembre('candidatures-recues');
    }

    public function payer(): void
    {
        $this->afficherMembre('payer');
    }

    // ---------- P5 · Formations ----------

    public function formations(): void
    {
        $this->afficherMembre('formations');
    }

    public function formationDetail(): void
    {
        $this->afficherMembre('formation-detail');
    }
}
