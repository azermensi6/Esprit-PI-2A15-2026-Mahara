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

    // ---------- P5 · Administration (litiges et suspensions) ----------
    'admin-litiges'         => 'AdminLitigesController',
    'admin-litige-form'     => 'AdminLitigeFormController',
    'admin-suspensions'     => 'AdminSuspensionsController',
    'admin-suspension-form' => 'AdminSuspensionFormController',
    'signaler-litige'       => 'SignalerLitigeController',

    // ---------- Pages à activer par chaque membre (décommenter quand prêtes) ----------
    // 'portfolio'          => 'PortfolioController',          // P1
    // 'admin-competences'  => 'AdminCompetencesController',   // P1
    // 'admin-categories'   => 'AdminCategoriesController',    // P2
    // 'admin-entreprises'  => 'AdminEntreprisesController',   // P3
    // 'admin-offres'       => 'AdminOffresController',        // P3
    // 'admin-candidatures' => 'AdminCandidaturesController',  // P4
    // 'admin-paiements'    => 'AdminPaiementsController',     // P4
];
