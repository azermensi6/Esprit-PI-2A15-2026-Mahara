<?php
/**
 * Table de routage : clé de page (index.php?page=...) => contrôleur à appeler.
 *   'NomController'          -> NomController::index()
 *   'NomController@methode'  -> NomController::methode()
 */
return [

    // ---------- Front office : pages publiques ----------
    'accueil'                 => 'AccueilController',
    'connexion'               => 'AuthController@connexion',
    'inscription'             => 'AuthController@inscription',
    'deconnexion'             => 'AuthController@deconnexion',

    // ---------- Front office : membres connectés (Commun) ----------
    'profil'                  => 'UtilisateurController@profil',
    'mes-reclamations'        => 'ReclamationController@mesReclamations',
    'reclamation-form'        => 'ReclamationController@formulaire',

    // ---------- P1 · Portfolio ----------
    'portfolio'               => 'PortfolioController',
    'ajouter-realisation'     => 'AjouterRealisationController',

    // ---------- P2 · Missions ----------
    'missions'                => 'MissionsController',
    'publier-mission'         => 'PublierMissionController',
    'mes-missions'            => 'MesMissionsController',

    // ---------- P3 · Recrutement ----------
    'offres'                  => 'OffreController@liste',
    'offre-detail'            => 'OffreController@detail',
    'mon-entreprise'          => 'EntrepriseController@monEntreprise',
    'publier-offre'           => 'OffreController@formulaire',

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
    'signin'                  => 'AuthController@signin',
    'blank-page'              => 'BlankPageController',

    // ---------- Back office · Commun ----------
    'admin-utilisateurs'      => 'UtilisateurController@liste',
    'admin-utilisateur-form'  => 'UtilisateurController@formulaire',
    'admin-reclamations'      => 'ReclamationController@liste',
    'admin-reclamation-form'  => 'ReclamationController@traitement',

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
    'admin-entreprises'       => 'EntrepriseController@liste',
    'admin-entreprise-form'   => 'EntrepriseController@formulaire',
    'admin-offres'            => 'OffreController@adminListe',
    'admin-offre-form'        => 'OffreController@adminFormulaire',
    'admin-statistiques-recrutement' => 'OffreController@statistiques',

    // ---------- Back office · P4 ----------
    'admin-paiements'         => 'AdminPaiementsController',
    'admin-paiement-form'     => 'AdminPaiementFormController',

    // ---------- Back office · P5 · Formations ----------
    'admin-categories-formation'     => 'AdminCategoriesFormationController',
    'admin-categorie-formation-form' => 'AdminCategorieFormationFormController',
    'admin-formations'               => 'AdminFormationsController',
    'admin-formation-form'           => 'AdminFormationFormController',
];
