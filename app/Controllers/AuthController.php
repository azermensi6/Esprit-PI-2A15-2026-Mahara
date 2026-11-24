<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use Database;

/**
 * Authentification : inscription, connexion, déconnexion, session, rôles et jeton CSRF.
 * Toute la logique (SQL préparé, hachage, validation, session) est ici, jamais dans le modèle ni la vue.
 */
class AuthController extends Controller
{
    /** Rôles qu'on peut choisir à l'inscription : jamais « admin » (pas d'auto-promotion) */
    public const ROLES_INSCRIPTION = ['etudiant' => 'Étudiant freelance', 'client' => 'Client', 'recruteur' => 'Recruteur'];

    /** Longueur minimale d'un mot de passe */
    public const MDP_MIN = 8;

    // ==============================================================
    // ÉTAT DE LA SESSION ET CONTRÔLE DES RÔLES
    // ==============================================================

    public static function isAuthenticated(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function hasRole(string $role): bool
    {
        return self::isAuthenticated() && ($_SESSION['role'] ?? null) === $role;
    }

    /**
     * Arrête la page si personne n'est connecté (redirection vers la connexion).
     * Relit aussi le compte dans la base à CHAQUE page protégée :
     * un compte supprimé ou suspendu est déconnecté, un changement de rôle est pris en compte.
     */
    public static function requireAuth(string $retour = 'accueil', string $pageConnexion = 'connexion'): void
    {
        if (self::isAuthenticated()) {
            $stmt = Database::getConnexion()->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id LIMIT 1');
            $stmt->execute(['id' => (int) $_SESSION['user_id']]);
            $row = $stmt->fetch();

            if ($row && $row['statut'] !== 'suspendu') {
                self::remplirSession(Utilisateur::fromArray($row));
                return;
            }
            self::detruireSession();
            session_start();
        }
        header('Location: index.php?' . http_build_query(['page' => $pageConnexion, 'redirect' => $retour]));
        exit;
    }

    /** Arrête la page si l'utilisateur n'a pas le rôle exigé (erreur HTTP 403) */
    public static function requireRole(string $role): void
    {
        self::requireAuth('accueil', $role === 'admin' ? 'signin' : 'connexion');

        if (($_SESSION['role'] ?? null) !== $role) {
            http_response_code(403);
            die('Accès refusé : vous n\'avez pas les droits nécessaires. <a href="index.php">Retour au site</a>');
        }
    }

    // ==============================================================
    // CSRF : un jeton unique par session, vérifié à chaque envoi de formulaire
    // ==============================================================

    public static function getCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function verifyCsrfToken(mixed $token): bool
    {
        if (!is_string($token) || $token === '' || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);   // comparaison à temps constant
    }

    // ==============================================================
    // ACCÈS AUX DONNÉES (requêtes préparées : protection contre l'injection SQL)
    // ==============================================================

    public function findByEmail(string $email): ?Utilisateur
    {
        $stmt = $this->db->prepare('SELECT * FROM utilisateur WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        return $row ? Utilisateur::fromArray($row) : null;
    }

    public function findById(int $id): ?Utilisateur
    {
        $stmt = $this->db->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? Utilisateur::fromArray($row) : null;
    }

    /** Règle métier : l'email est-il déjà utilisé par un autre compte ? */
    public function emailExiste(string $email, int $exceptId = 0): bool
    {
        $stmt = $this->db->prepare(
            'SELECT id_utilisateur FROM utilisateur WHERE email = :email AND id_utilisateur <> :id LIMIT 1'
        );
        $stmt->execute(['email' => $email, 'id' => $exceptId]);
        return (bool) $stmt->fetch();
    }

    /** Insère un utilisateur : le mot de passe de l'objet doit déjà être haché */
    public function insertUser(Utilisateur $user): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, role, statut)
             VALUES (:nom, :prenom, :email, :mdp, :telephone, :role, :statut)'
        );
        return $stmt->execute([
            'nom'       => $user->getNom(),
            'prenom'    => $user->getPrenom(),
            'email'     => $user->getEmail(),
            'mdp'       => $user->getMotDePasse(),
            'telephone' => $user->getTelephone() !== '' ? $user->getTelephone() : null,
            'role'      => $user->getRole(),
            'statut'    => $user->getStatut(),
        ]);
    }

    /**
     * Validation commune (inscription, profil, back office) : renvoie [champ => message].
     * $d : nom, prenom, email, telephone (8 chiffres, facultatif).
     */
    public function validerIdentite(array $d, int $exceptId = 0): array
    {
        $errors = [];
        // 2 à 50 caractères, commence par une lettre (le client peut écrire le nom de son commerce)
        $nomValide = '/^\p{L}[\p{L}\p{N} \'.&-]{1,49}$/u';

        if ($d['nom'] === '') {
            $errors['nom'] = 'Le nom est obligatoire.';
        } elseif (!preg_match($nomValide, $d['nom'])) {
            $errors['nom'] = 'Le nom doit contenir 2 à 50 caractères et commencer par une lettre.';
        }
        if ($d['prenom'] === '') {
            $errors['prenom'] = 'Le prénom est obligatoire.';
        } elseif (!preg_match($nomValide, $d['prenom'])) {
            $errors['prenom'] = 'Le prénom doit contenir 2 à 50 caractères et commencer par une lettre.';
        }
        if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($d['email']) > 100) {
            $errors['email'] = 'Adresse email invalide.';
        } elseif ($this->emailExiste($d['email'], $exceptId)) {
            $errors['email'] = 'Un compte existe déjà avec cet email.';
        }
        if ($d['telephone'] !== '' && !preg_match('/^[0-9]{8}$/', $d['telephone'])) {
            $errors['telephone'] = 'Le téléphone doit contenir exactement 8 chiffres.';
        }
        return $errors;
    }

    // ==============================================================
    // INSCRIPTION
    // ==============================================================

    /** Renvoie la liste des erreurs (tableau vide = compte créé) */
    public function register(array $post): array
    {
        $d = [
            'role'      => input($post, 'role'),
            'nom'       => input($post, 'nom'),
            'prenom'    => input($post, 'prenom'),
            'email'     => input($post, 'email'),
            'telephone' => str_replace(' ', '', input($post, 'telephone')),
        ];
        $password        = input($post, 'mot_de_passe', false);
        $passwordConfirm = input($post, 'confirmation', false);

        $errors = [];
        if (!isset(self::ROLES_INSCRIPTION[$d['role']])) {
            $errors[] = 'Type de compte invalide.';
        }
        $errors = array_merge($errors, array_values($this->validerIdentite($d)));
        if (mb_strlen($password) < self::MDP_MIN) {
            $errors[] = 'Le mot de passe doit contenir au moins ' . self::MDP_MIN . ' caractères.';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
        if ($errors !== []) {
            return $errors;
        }

        // Construction de l'entité : mot de passe haché (bcrypt), rôle choisi parmi les rôles autorisés
        $user = new Utilisateur();
        $user->setNom($d['nom']);
        $user->setPrenom($d['prenom']);
        $user->setEmail($d['email']);
        $user->setTelephone($d['telephone']);
        $user->setRole($d['role']);
        $user->setStatut('en_attente');                       // l'admin validera le compte
        $user->setMotDePasse(password_hash($password, PASSWORD_DEFAULT));

        if (!$this->insertUser($user)) {
            $errors[] = 'Une erreur est survenue lors de la création du compte.';
        }
        return $errors;
    }

    // ==============================================================
    // CONNEXION / DÉCONNEXION
    // ==============================================================

    /** Renvoie la liste des erreurs (tableau vide = connecté) */
    public function login(array $post): array
    {
        $email    = input($post, 'email');
        $password = input($post, 'mot_de_passe', false);

        if ($email === '' || $password === '') {
            return ['Saisis ton email et ton mot de passe.'];
        }

        $user = $this->findByEmail($email);

        // Message volontairement général : on ne révèle jamais si c'est l'email ou le mot de passe qui est faux
        if (!$user || !password_verify($password, $user->getMotDePasse())) {
            return ['Email ou mot de passe incorrect.'];
        }
        if ($user->getStatut() === 'suspendu') {
            return ['Ce compte est suspendu. Contacte l\'administration.'];
        }

        // Nouvel identifiant de session : protège contre la fixation de session
        session_regenerate_id(true);
        self::remplirSession($user);

        return [];
    }

    public function logout(): void
    {
        self::detruireSession();
    }

    /** Copie dans la session les informations utiles (jamais le mot de passe) */
    private static function remplirSession(Utilisateur $user): void
    {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['nom']     = $user->getNom();
        $_SESSION['prenom']  = $user->getPrenom();
        $_SESSION['email']   = $user->getEmail();
        $_SESSION['role']    = $user->getRole();   // le rôle vient de la base, jamais du formulaire
    }

    /** Vide la session, supprime le cookie PHPSESSID et le fichier de session sur le serveur */
    private static function detruireSession(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    /** Après connexion : l'admin va au back office, les autres au front office */
    private function redirigerSelonRole(string $retour): never
    {
        $this->redirect(self::hasRole('admin') ? 'dashboard' : $retour);
    }

    // ==============================================================
    // PAGES (appelées par le routeur)
    // ==============================================================

    /** index.php?page=connexion */
    public function connexion(): void
    {
        $redirect = safeRedirectPage(input($_POST, 'redirect') ?: input($_GET, 'redirect') ?: null);

        if (self::isAuthenticated()) {
            $this->redirigerSelonRole($redirect);
        }

        $errors = [];
        $email  = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email  = input($_POST, 'email');
            $errors = $this->login($_POST);
            if ($errors === []) {
                $this->redirigerSelonRole($redirect);
            }
        } elseif (isset($_GET['redirect'])) {
            $errors[] = 'Connecte-toi ou crée un compte pour accéder à cette page.';
        }

        $this->renderFront('connexion', [
            'errors'     => $errors,
            'email'      => $email,
            'redirect'   => $redirect,
            'registered' => isset($_GET['registered']),
        ]);
    }

    /** index.php?page=inscription */
    public function inscription(): void
    {
        if (self::isAuthenticated()) {
            $this->redirigerSelonRole('accueil');
        }

        $errors = [];
        $old    = ['role' => 'etudiant', 'nom' => '', 'prenom' => '', 'email' => '', 'telephone' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach ($old as $champ => $_) {
                $old[$champ] = input($_POST, $champ);
            }
            $errors = $this->register($_POST);
            if ($errors === []) {
                $this->redirect('connexion', ['registered' => 1]);
            }
        }

        $this->renderFront('inscription', [
            'errors' => $errors,
            'old'    => $old,
            'roles'  => self::ROLES_INSCRIPTION,
            'mdpMin' => self::MDP_MIN,
        ]);
    }

    /** index.php?page=signin : connexion au back office (même logique, présentation admin) */
    public function signin(): void
    {
        $this->page  = 'signin';
        $this->title = 'Connexion | Mahara Admin';

        if (self::isAuthenticated()) {
            $this->redirigerSelonRole('accueil');
        }

        $errors = [];
        $email  = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email  = input($_POST, 'email');
            $errors = $this->login($_POST);
            if ($errors === []) {
                $this->redirigerSelonRole('accueil');
            }
        }

        $this->renderStandalone('signin', ['errors' => $errors, 'email' => $email]);
    }

    /** index.php?page=deconnexion */
    public function deconnexion(): void
    {
        $this->logout();
        header('Location: index.php?page=connexion');
        exit;
    }
}
