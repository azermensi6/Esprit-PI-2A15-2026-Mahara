<?php
/**
 * Table de routage : clé de page (index.php?page=...) => Controller
 */
return [

    // ---------- Front office : pages publiques ----------
    'accueil'                 => 'AccueilController',
    'connexion'               => 'ConnexionController',
    'inscription'             => 'InscriptionController',
    'deconnexion'             => 'DeconnexionController',

    // ---------- Front office : membres connectés (Commun) ----------
    'profil'                  => 'ProfilController',

    // ---------- P1 · Portfolio ----------
    'portfolio'               => 'PortfolioController',
    'ajouter-realisation'     => 'AjouterRealisationController',

    // ---------- P2 · Missions ----------
    'missions'                => 'MissionsController',
    'publier-mission'         => 'PublierMissionController',
    'mes-missions'            => 'MesMissionsController',

    // ---------- P3 · Recrutement ----------
    'offres'                  => 'OffresController',
    'offre-detail'            => 'OffreDetailController',
    'mon-entreprise'          => 'MonEntrepriseController',
    'publier-offre'           => 'PublierOffreController',

    // ---------- P4 · Candidatures et paiements ----------
    'postuler'                => 'PostulerController',
    'mes-candidatures'        => 'MesCandidaturesController',
    'candidatures-recues'     => 'CandidaturesRecuesController',
    'payer'                   => 'PayerController',

    // ---------- P5 · Formations ----------
    'formations'              => 'FormationsController',
    'formation-detail'        => 'FormationDetailController',

    // ---------- Back office ----------
    'dashboard'               => 'DashboardController',
    'signin'                  => 'SigninController',
    'blank-page'              => 'BlankPageController',

    // ---------- Back office · Commun ----------
    'admin-utilisateurs'      => 'AdminUtilisateursController',
    'admin-utilisateur-form'  => 'AdminUtilisateurFormController',

    // ---------- Back office · P1 ----------
    'admin-competences'       => 'AdminCompetencesController',
    'admin-competence-form'   => 'AdminCompetenceFormController',
    'admin-realisations'      => 'AdminRealisationsController',
    'admin-realisation-form'  => 'AdminRealisationFormController',

    // ---------- Back office · P2 ----------
    'admin-categories'        => 'AdminCategoriesController',
    'admin-categorie-form'    => 'AdminCategorieFormController',
    'admin-missions'          => 'AdminMissionsController',
    'admin-mission-form'      => 'AdminMissionFormController',

    // ---------- Back office · P3 ----------
    'admin-entreprises'       => 'AdminEntreprisesController',
    'admin-entreprise-form'   => 'AdminEntrepriseFormController',

    // ---------- Back office · P4 ----------
    'admin-paiements'         => 'AdminPaiementsController',
    'admin-paiement-form'     => 'AdminPaiementFormController',

    // ---------- Back office · P5 · Formations ----------
    'admin-categories-formation'     => 'AdminCategoriesFormationController',
    'admin-categorie-formation-form' => 'AdminCategorieFormationFormController',
    'admin-formations'               => 'AdminFormationsController',
    'admin-formation-form'           => 'AdminFormationFormController',
];
