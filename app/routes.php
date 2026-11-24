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

    // ---------- Front office : membres connectés ----------
    'profil'                  => 'UtilisateurController@profil',
    'mes-reclamations'        => 'ReclamationController@mesReclamations',
    'reclamation-form'        => 'ReclamationController@formulaire',
    'formations'              => 'FormationController@catalogue',
    'formation-detail'        => 'FormationController@detail',

    // ---------- Back office ----------
    'signin'                  => 'AuthController@signin',
    'dashboard'               => 'DashboardController',

    // ---------- Back office · Utilisateurs et réclamations ----------
    'admin-utilisateurs'      => 'UtilisateurController@liste',
    'admin-utilisateur-form'  => 'UtilisateurController@formulaire',
    'admin-reclamations'      => 'ReclamationController@liste',
    'admin-reclamation-form'  => 'ReclamationController@traitement',

    // ---------- Back office · Formations ----------
    'admin-categories-formation'     => 'CategorieFormationController@liste',
    'admin-categorie-formation-form' => 'CategorieFormationController@formulaire',
    'admin-formations'               => 'FormationController@liste',
    'admin-formation-form'           => 'FormationController@formulaire',
];
