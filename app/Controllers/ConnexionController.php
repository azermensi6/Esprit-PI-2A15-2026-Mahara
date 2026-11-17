<?php

namespace App\Controllers;

use App\Models\Utilisateur;

class ConnexionController extends Controller
{
    public function index(): void
    {
        $redirect = safeRedirectPage($_POST['redirect'] ?? $_GET['redirect'] ?? null);

        if (isLoggedIn()) {
            header('Location: index.php?page=' . $redirect);
            exit;
        }

        $erreur = null;
        $email  = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $mdp   = $_POST['mot_de_passe'] ?? '';
            $user  = Utilisateur::findByEmail($email);

            if (!$user || !password_verify($mdp, $user['mot_de_passe'])) {
                $erreur = 'Email ou mot de passe incorrect.';
            } elseif ($user['statut'] === 'suspendu') {
                $erreur = 'Ton compte est suspendu. Contacte l\'administration.';
            } else {
                loginUser($user);
                header('Location: index.php?page=' . $redirect);
                exit;
            }
        } elseif (isset($_GET['redirect'])) {
            $erreur = 'Connecte-toi ou crée un compte pour accéder à cette page.';
        }

        $this->renderFront('connexion', compact('erreur', 'email', 'redirect'));
    }
}
