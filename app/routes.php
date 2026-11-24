<?php
/**
 * Table de routage : clé de page (index.php?page=...) => contrôleur à appeler.
 *   'NomController'          -> NomController::index()
 *   'NomController@methode'  -> NomController::methode()
 */
return [

    // ---------- Front office : pages publiques ----------
    'accueil'                 => 'PageController@accueil',
    'connexion'               => 'AuthController@connexion',
    'inscription'             => 'AuthController@inscription',
    'deconnexion'             => 'AuthController@deconnexion',

    // ---------- Front office : membres connectés (Commun) ----------
    'profil'                  => 'UtilisateurController@profil',
    'mes-reclamations'        => 'ReclamationController@mesReclamations',
    'reclamation-form'        => 'ReclamationController@formulaire',

    // ---------- P1 · Portfolio ----------
    'portfolio'               => 'PageController@portfolio',
    'ajouter-realisation'     => 'PageController@ajouterRealisation',

    // ---------- P2 · Missions ----------
    'missions'                => 'PageController@missions',
    'publier-mission'         => 'PageController@publierMission',
    'mes-missions'            => 'PageController@mesMissions',

    // ---------- P3 · Recrutement ----------
    'offres'                  => 'PageController@offres',
    'offre-detail'            => 'PageController@offreDetail',
    'mon-entreprise'          => 'PageController@monEntreprise',
    'publier-offre'           => 'PageController@publierOffre',

    // ---------- P4 · Candidatures et paiements ----------
    'postuler'                => 'PageController@postuler',
    'mes-candidatures'        => 'PageController@mesCandidatures',
    'candidatures-recues'     => 'PageController@candidaturesRecues',
    'payer'                   => 'PageController@payer',

    // ---------- P5 · Formations ----------
    'formations'              => 'PageController@formations',
    'formation-detail'        => 'PageController@formationDetail',

    // ---------- Back office ----------
    'dashboard'               => 'AdminController@dashboard',
    'signin'                  => 'AuthController@signin',
    'blank-page'              => 'AdminController@blankPage',

    // ---------- Back office · Commun ----------
    'admin-utilisateurs'      => 'UtilisateurController@liste',
    'admin-utilisateur-form'  => 'UtilisateurController@formulaire',
    'admin-reclamations'      => 'ReclamationController@liste',
    'admin-reclamation-form'  => 'ReclamationController@traitement',

    // ---------- Back office · P1 ----------
    'admin-competences'       => 'AdminController@competences',
    'admin-competence-form'   => 'AdminController@competenceForm',
    'admin-realisations'      => 'AdminController@realisations',
    'admin-realisation-form'  => 'AdminController@realisationForm',

    // ---------- Back office · P2 ----------
    'admin-categories'        => 'AdminController@categories',
    'admin-categorie-form'    => 'AdminController@categorieForm',
    'admin-missions'          => 'AdminController@missions',
    'admin-mission-form'      => 'AdminController@missionForm',

    // ---------- Back office · P3 ----------
    'admin-entreprises'       => 'AdminController@entreprises',
    'admin-entreprise-form'   => 'AdminController@entrepriseForm',

    // ---------- Back office · P4 ----------
    'admin-paiements'         => 'AdminController@paiements',
    'admin-paiement-form'     => 'AdminController@paiementForm',

    // ---------- Back office · P5 · Formations ----------
    'admin-categories-formation'     => 'AdminController@categoriesFormation',
    'admin-categorie-formation-form' => 'AdminController@categorieFormationForm',
    'admin-formations'               => 'AdminController@formations',
    'admin-formation-form'           => 'AdminController@formationForm',
];
