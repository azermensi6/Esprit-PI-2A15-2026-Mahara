<?php
/**
 * Table de routage : clé de page (index.php?page=...) => Controller
 */
return [
    // ---------- Front office ----------
    'accueil' => 'AccueilController',
    'missions' => 'MissionsController',
    'offres' => 'OffresController',
    'publier-mission' => 'PublierMissionController',
    'connexion' => 'ConnexionController',
    'inscription' => 'InscriptionController',
    // ---------- Back office ----------
    'dashboard' => 'DashboardController',
    'admin-missions' => 'AdminMissionsController',
    'admin-mission-form' => 'AdminMissionFormController',
    'blank-page' => 'BlankPageController',
    'signin' => 'SigninController',

    // ---------- Pages à activer par chaque membre (décommenter quand prêtes) ----------
    // 'portfolio'          => 'PortfolioController',          // P1
    // 'admin-competences'  => 'AdminCompetencesController',   // P1
    // 'admin-categories'   => 'AdminCategoriesController',    // P2
    // 'admin-entreprises'  => 'AdminEntreprisesController',   // P3
    // 'admin-offres'       => 'AdminOffresController',        // P3
    // 'admin-candidatures' => 'AdminCandidaturesController',  // P4
    // 'admin-paiements'    => 'AdminPaiementsController',     // P4
    // 'admin-litiges'      => 'AdminLitigesController',       // P5
    // 'admin-suspensions'  => 'AdminSuspensionsController',   // P5
];
