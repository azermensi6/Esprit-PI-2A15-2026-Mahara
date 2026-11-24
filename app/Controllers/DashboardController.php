<?php

namespace App\Controllers;

/**
 * Back office : tableau de bord avec les vrais chiffres de la base
 * (utilisateurs, réclamations, formations).
 */
class DashboardController extends Controller
{
    protected string $page = 'dashboard';
    protected string $title = 'Tableau de bord | Mahara Admin';

    public function index(): void
    {
        $this->requireAdmin();

        $utilisateurs = new UtilisateurController();
        $reclamations = new ReclamationController();
        $formations   = new FormationController();

        // Comptes par rôle et comptes à valider
        $parRole = $this->db->query('SELECT role, COUNT(*) AS nb FROM utilisateur GROUP BY role')->fetchAll();
        $roles   = array_fill_keys(array_keys(UtilisateurController::ROLES), 0);
        foreach ($parRole as $ligne) {
            $roles[$ligne['role']] = (int) $ligne['nb'];
        }

        $this->render('dashboard', [
            'roles'          => $roles,
            'libellesRoles'  => UtilisateurController::ROLES,
            'aValider'       => $utilisateurs->search('', '', 'en_attente'),
            'statsReclam'    => $reclamations->countParStatut(),
            'libellesStatut' => ReclamationController::STATUTS,
            'types'          => ReclamationController::TYPES,
            'enAttente'      => array_slice($reclamations->search('', 'en_attente'), 0, 5),
            'nbFormations'   => count($formations->allWithCategorie()),
        ]);
    }
}
