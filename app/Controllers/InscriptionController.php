<?php

namespace App\Controllers;

use App\Models\Utilisateur;

class InscriptionController extends Controller
{
    private const ROLES = ['etudiant', 'client', 'recruteur'];

    public function index(): void
    {
        $redirect = safeRedirectPage($_POST['redirect'] ?? $_GET['redirect'] ?? null);

        if (isLoggedIn()) {
            header('Location: index.php?page=' . $redirect);
            exit;
        }

        $erreur = null;
        $old    = ['role' => 'etudiant', 'nom' => '', 'prenom' => '', 'email' => '', 'telephone' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach (array_keys($old) as $champ) {
                $old[$champ] = trim($_POST[$champ] ?? '');
            }
            $mdp  = $_POST['mot_de_passe'] ?? '';
            $mdp2 = $_POST['confirmation'] ?? '';

            if (!in_array($old['role'], self::ROLES, true)) {
                $erreur = 'Type de compte invalide.';
            } elseif ($old['nom'] === '' || $old['prenom'] === '') {
                $erreur = 'Le nom et le prénom sont obligatoires.';
            } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
                $erreur = 'Adresse email invalide.';
            } elseif (strlen($mdp) < 6) {
                $erreur = 'Le mot de passe doit contenir au moins 6 caractères.';
            } elseif ($mdp !== $mdp2) {
                $erreur = 'Les mots de passe ne correspondent pas.';
            } elseif (Utilisateur::findByEmail($old['email'])) {
                $erreur = 'Un compte existe déjà avec cet email.';
            } else {
                Utilisateur::create($old + ['mot_de_passe' => $mdp]);
                loginUser(Utilisateur::findByEmail($old['email']));
                header('Location: index.php?page=' . $redirect);
                exit;
            }
        }

        $this->renderFront('inscription', compact('erreur', 'old', 'redirect'));
    }
}
