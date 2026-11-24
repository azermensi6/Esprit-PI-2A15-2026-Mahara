<?php

namespace App\Controllers;

use App\Models\Utilisateur;
use PDOException;

/**
 * Gestion des utilisateurs :
 *  - back office : liste, recherche, ajout, modification, validation, suspension, suppression ;
 *  - front office : profil de l'utilisateur connecté.
 * Jointure : utilisateur <-> reclamation (nombre de réclamations de chaque utilisateur).
 */
class UtilisateurController extends Controller
{
    /** Valeurs autorisées par la base (ENUM) => libellé affiché */
    public const ROLES   = ['etudiant' => 'Étudiant', 'client' => 'Client', 'recruteur' => 'Recruteur', 'admin' => 'Administrateur'];
    public const STATUTS = ['en_attente' => 'En attente', 'actif' => 'Actif', 'suspendu' => 'Suspendu'];

    /** Réutilise les accès aux comptes et la validation de l'authentification */
    private AuthController $auth;

    public function __construct()
    {
        parent::__construct();
        $this->auth = new AuthController();
    }

    // ==============================================================
    // ACCÈS AUX DONNÉES (requêtes préparées)
    // ==============================================================

    /**
     * READ + LEFT JOIN : liste filtrée, avec le nombre de réclamations de chaque utilisateur.
     * @return Utilisateur[]
     */
    public function search(string $q = '', string $role = '', string $statut = ''): array
    {
        $sql = 'SELECT u.*, COUNT(r.id_reclamation) AS nb_reclamations
                FROM utilisateur u
                LEFT JOIN reclamation r ON r.id_utilisateur = u.id_utilisateur
                WHERE 1 = 1';
        $params = [];

        if ($q !== '') {
            $sql .= ' AND (u.nom LIKE :q1 OR u.prenom LIKE :q2 OR u.email LIKE :q3)';
            $params['q1'] = $params['q2'] = $params['q3'] = '%' . $q . '%';
        }
        if (isset(self::ROLES[$role])) {
            $sql .= ' AND u.role = :role';
            $params['role'] = $role;
        }
        if (isset(self::STATUTS[$statut])) {
            $sql .= ' AND u.statut = :statut';
            $params['statut'] = $statut;
        }
        $sql .= ' GROUP BY u.id_utilisateur ORDER BY u.date_inscription DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return array_map(fn(array $row) => Utilisateur::fromArray($row), $stmt->fetchAll());
    }

    /** UPDATE (admin) : toutes les informations sauf le mot de passe */
    public function update(Utilisateur $u): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE utilisateur
             SET nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, role = :role, statut = :statut
             WHERE id_utilisateur = :id'
        );
        return $stmt->execute([
            'nom'       => $u->getNom(),
            'prenom'    => $u->getPrenom(),
            'email'     => $u->getEmail(),
            'telephone' => $u->getTelephone() !== '' ? $u->getTelephone() : null,
            'role'      => $u->getRole(),
            'statut'    => $u->getStatut(),
            'id'        => $u->getId(),
        ]);
    }

    /** UPDATE : nouveau mot de passe (reçu déjà haché) */
    public function updateMotDePasse(int $id, string $hash): bool
    {
        $stmt = $this->db->prepare('UPDATE utilisateur SET mot_de_passe = :mdp WHERE id_utilisateur = :id');
        return $stmt->execute(['mdp' => $hash, 'id' => $id]);
    }

    /** UPDATE : valider ou suspendre un compte */
    public function setStatut(int $id, string $statut): bool
    {
        $stmt = $this->db->prepare('UPDATE utilisateur SET statut = :statut WHERE id_utilisateur = :id');
        return $stmt->execute(['statut' => $statut, 'id' => $id]);
    }

    /** DELETE (ses réclamations sont supprimées avec lui : ON DELETE CASCADE) */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM utilisateur WHERE id_utilisateur = :id');
        return $stmt->execute(['id' => $id]);
    }

    /** Règle métier : il doit toujours rester au moins un administrateur actif */
    public function countAdminsActifs(): int
    {
        return (int) $this->db
            ->query("SELECT COUNT(*) FROM utilisateur WHERE role = 'admin' AND statut = 'actif'")
            ->fetchColumn();
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-utilisateurs
    // ==============================================================

    public function liste(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-utilisateurs';
        $this->title = 'Utilisateurs | Mahara Admin';

        $filtres = [
            'q'      => input($_GET, 'q'),
            'role'   => input($_GET, 'role'),
            'statut' => input($_GET, 'statut'),
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            $this->action(input($_POST, 'action'), (int) input($_POST, 'id'));
            $this->redirect('admin-utilisateurs', array_filter($filtres));
        }

        $this->render('utilisateurs', [
            'utilisateurs' => $this->search($filtres['q'], $filtres['role'], $filtres['statut']),
            'filtres'      => $filtres,
            'roles'        => self::ROLES,
            'statuts'      => self::STATUTS,
            'flash'        => takeFlash(),
            'moi'          => (int) $_SESSION['user_id'],
        ]);
    }

    /** Valider, suspendre ou supprimer un compte (avec les règles métiers) */
    private function action(string $action, int $id): void
    {
        $user = $this->auth->findById($id);

        if ($user === null) {
            setFlash('danger', 'Utilisateur introuvable.');
        } elseif ($id === (int) $_SESSION['user_id'] && $action !== 'valider') {
            setFlash('danger', 'Vous ne pouvez pas suspendre ou supprimer votre propre compte.');
        } elseif ($user->getRole() === 'admin' && $user->getStatut() === 'actif' && $action !== 'valider'
                  && $this->countAdminsActifs() <= 1) {
            setFlash('danger', 'Impossible : c\'est le dernier administrateur actif.');
        } elseif ($action === 'valider') {
            $this->setStatut($id, 'actif');
            setFlash('success', 'Compte activé.');
        } elseif ($action === 'suspendre') {
            $this->setStatut($id, 'suspendu');
            setFlash('success', 'Compte suspendu : l\'utilisateur est déconnecté.');
        } elseif ($action === 'supprimer') {
            try {
                $this->delete($id);
                setFlash('success', 'Compte supprimé.');
            } catch (PDOException $e) {
                // Clé étrangère : un paiement est lié à ce compte (historique à conserver)
                setFlash('danger', 'Suppression impossible : ce compte a un historique de paiements. Suspendez-le plutôt.');
            }
        } else {
            setFlash('danger', 'Action inconnue.');
        }
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-utilisateur-form (&id=3 pour modifier)
    // ==============================================================

    public function formulaire(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-utilisateur-form';
        $this->title = 'Ajouter un utilisateur | Mahara Admin';

        $id  = (int) input($_GET, 'id');
        $moi = $id > 0 && $id === (int) $_SESSION['user_id'];
        $old = ['nom' => '', 'prenom' => '', 'email' => '', 'telephone' => '', 'role' => '', 'statut' => 'actif'];

        if ($id > 0) {
            $user = $this->auth->findById($id);
            if ($user === null) {
                setFlash('danger', 'Utilisateur introuvable.');
                $this->redirect('admin-utilisateurs');
            }
            $old = [
                'nom' => $user->getNom(), 'prenom' => $user->getPrenom(), 'email' => $user->getEmail(),
                'telephone' => $user->getTelephone(), 'role' => $user->getRole(), 'statut' => $user->getStatut(),
            ];
            $this->title = 'Modifier un utilisateur | Mahara Admin';
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            foreach ($old as $champ => $_) {
                $old[$champ] = input($_POST, $champ);
            }
            $old['telephone'] = str_replace(' ', '', $old['telephone']);
            if ($moi) {
                // Règle métier : l'admin ne peut pas retirer son propre rôle ni désactiver son compte
                $old['role']   = 'admin';
                $old['statut'] = 'actif';
            }
            $mdp  = input($_POST, 'mot_de_passe', false);
            $mdp2 = input($_POST, 'confirmation', false);

            $errors = $this->auth->validerIdentite($old, $id);
            if (!isset(self::ROLES[$old['role']])) {
                $errors['role'] = 'Choisissez un rôle.';
            }
            if (!isset(self::STATUTS[$old['statut']])) {
                $errors['statut'] = 'Statut invalide.';
            }
            if ($id === 0 && $mdp === '') {
                $errors['mot_de_passe'] = 'Le mot de passe est obligatoire.';
            } elseif ($mdp !== '' && mb_strlen($mdp) < AuthController::MDP_MIN) {
                $errors['mot_de_passe'] = 'Le mot de passe doit contenir au moins ' . AuthController::MDP_MIN . ' caractères.';
            } elseif ($mdp !== $mdp2) {
                $errors['confirmation'] = 'Les mots de passe ne correspondent pas.';
            }

            if ($errors === []) {
                $user = new Utilisateur();
                $user->setId($id);
                $user->setNom($old['nom']);
                $user->setPrenom($old['prenom']);
                $user->setEmail($old['email']);
                $user->setTelephone($old['telephone']);
                $user->setRole($old['role']);
                $user->setStatut($old['statut']);

                if ($id > 0) {
                    $this->update($user);
                    if ($mdp !== '') {
                        $this->updateMotDePasse($id, password_hash($mdp, PASSWORD_DEFAULT));
                    }
                    setFlash('success', 'Utilisateur modifié.');
                } else {
                    $user->setMotDePasse(password_hash($mdp, PASSWORD_DEFAULT));   // toujours haché
                    $this->auth->insertUser($user);
                    setFlash('success', 'Utilisateur ajouté.');
                }
                $this->redirect('admin-utilisateurs');
            }
        }

        $this->render('utilisateur-form', [
            'id'      => $id,
            'moi'     => $moi,
            'old'     => $old,
            'errors'  => $errors,
            'roles'   => self::ROLES,
            'statuts' => self::STATUTS,
            'mdpMin'  => AuthController::MDP_MIN,
        ]);
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=profil
    // ==============================================================

    public function profil(): void
    {
        $this->requireLogin('profil');

        $id   = (int) $_SESSION['user_id'];
        $user = $this->auth->findById($id);
        $old  = ['nom' => $user->getNom(), 'prenom' => $user->getPrenom(), 'email' => $user->getEmail(), 'telephone' => $user->getTelephone()];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            foreach ($old as $champ => $_) {
                $old[$champ] = input($_POST, $champ);
            }
            $old['telephone'] = str_replace(' ', '', $old['telephone']);
            $actuel = input($_POST, 'mot_de_passe_actuel', false);
            $mdp    = input($_POST, 'mot_de_passe', false);
            $mdp2   = input($_POST, 'confirmation', false);

            $errors = $this->auth->validerIdentite($old, $id);

            // Changement de mot de passe seulement si l'un des champs est rempli
            if ($mdp !== '' || $actuel !== '') {
                if (!password_verify($actuel, $user->getMotDePasse())) {
                    $errors['mot_de_passe_actuel'] = 'Mot de passe actuel incorrect.';
                } elseif (mb_strlen($mdp) < AuthController::MDP_MIN) {
                    $errors['mot_de_passe'] = 'Le nouveau mot de passe doit contenir au moins ' . AuthController::MDP_MIN . ' caractères.';
                } elseif ($mdp !== $mdp2) {
                    $errors['confirmation'] = 'Les mots de passe ne correspondent pas.';
                }
            }

            if ($errors === []) {
                // Le rôle et le statut ne viennent jamais du formulaire : on garde ceux de la base
                $user->setNom($old['nom']);
                $user->setPrenom($old['prenom']);
                $user->setEmail($old['email']);
                $user->setTelephone($old['telephone']);
                $this->update($user);
                if ($mdp !== '') {
                    $this->updateMotDePasse($id, password_hash($mdp, PASSWORD_DEFAULT));
                }
                setFlash('success', 'Profil mis à jour.');
                $this->redirect('profil');
            }
        }

        $this->renderFront('profil', [
            'user'    => $user,
            'old'     => $old,
            'errors'  => $errors,
            'roles'   => ['etudiant' => 'Étudiant freelance'] + self::ROLES,
            'statuts' => self::STATUTS,
            'mdpMin'  => AuthController::MDP_MIN,
            'flash'   => takeFlash(),
        ]);
    }
}
