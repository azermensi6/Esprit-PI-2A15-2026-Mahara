<?php

namespace App\Controllers;

use App\Models\Reclamation;

/**
 * Réclamations (communes à tous les modules) :
 *  - front office : déposer, modifier, retirer et suivre ses réclamations ;
 *  - back office  : liste filtrée, traitement (statut + réponse), suppression.
 * Jointures : reclamation.id_utilisateur -> utilisateur (auteur), reclamation.id_admin -> utilisateur (admin).
 */
class ReclamationController extends Controller
{
    /** Valeurs autorisées par la base (ENUM) => libellé affiché */
    public const TYPES = [
        'compte' => 'Mon compte', 'portfolio' => 'Portfolio', 'mission' => 'Missions', 'recrutement' => 'Recrutement',
        'paiement' => 'Paiements', 'formation' => 'Formations', 'autre' => 'Autre',
    ];
    public const STATUTS = ['en_attente' => 'En attente', 'en_cours' => 'En cours', 'resolue' => 'Résolue', 'rejetee' => 'Rejetée'];

    /** Statuts que l'admin peut choisir : une réclamation prise en charge ne revient pas « en attente » */
    private const STATUTS_TRAITEMENT = ['en_cours', 'resolue', 'rejetee'];

    /** Règle métier anti-spam : nombre maximum de réclamations en attente par utilisateur */
    public const MAX_EN_ATTENTE = 3;

    /** Partie commune des requêtes : réclamation + auteur (JOIN) + admin (LEFT JOIN, peut être NULL) */
    private const SELECT = "SELECT r.*,
                CONCAT(u.prenom, ' ', u.nom) AS auteur, u.email AS auteur_email, u.role AS auteur_role,
                CONCAT(a.prenom, ' ', a.nom) AS admin
            FROM reclamation r
            JOIN      utilisateur u ON r.id_utilisateur = u.id_utilisateur
            LEFT JOIN utilisateur a ON r.id_admin       = a.id_utilisateur";

    // ==============================================================
    // ACCÈS AUX DONNÉES (requêtes préparées)
    // ==============================================================

    /** @return Reclamation[] toutes les réclamations, filtrées (mot-clé, statut, module) */
    public function search(string $q = '', string $statut = '', string $type = ''): array
    {
        $sql    = self::SELECT . ' WHERE 1 = 1';
        $params = [];

        if ($q !== '') {
            $sql .= ' AND (r.sujet LIKE :q1 OR u.nom LIKE :q2 OR u.prenom LIKE :q3 OR u.email LIKE :q4)';
            $params['q1'] = $params['q2'] = $params['q3'] = $params['q4'] = '%' . $q . '%';
        }
        if (isset(self::STATUTS[$statut])) {
            $sql .= ' AND r.statut = :statut';
            $params['statut'] = $statut;
        }
        if (isset(self::TYPES[$type])) {
            $sql .= ' AND r.type_probleme = :type';
            $params['type'] = $type;
        }
        // Les réclamations à traiter d'abord, puis les plus récentes
        $sql .= " ORDER BY FIELD(r.statut, 'en_attente', 'en_cours', 'resolue', 'rejetee'), r.date_reclamation DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return array_map(fn(array $row) => Reclamation::fromArray($row), $stmt->fetchAll());
    }

    /** @return Reclamation[] les réclamations d'un utilisateur */
    public function byUtilisateur(int $idUtilisateur): array
    {
        $stmt = $this->db->prepare(self::SELECT . ' WHERE r.id_utilisateur = :id ORDER BY r.date_reclamation DESC');
        $stmt->execute(['id' => $idUtilisateur]);
        return array_map(fn(array $row) => Reclamation::fromArray($row), $stmt->fetchAll());
    }

    public function findById(int $id): ?Reclamation
    {
        $stmt = $this->db->prepare(self::SELECT . ' WHERE r.id_reclamation = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? Reclamation::fromArray($row) : null;
    }

    public function insert(Reclamation $r): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO reclamation (sujet, description, type_probleme, id_utilisateur)
             VALUES (:sujet, :description, :type, :id)'
        );
        return $stmt->execute([
            'sujet'       => $r->getSujet(),
            'description' => $r->getDescription(),
            'type'        => $r->getTypeProbleme(),
            'id'          => $r->getIdUtilisateur(),
        ]);
    }

    /** UPDATE par l'auteur : seulement tant qu'elle est « en attente » (condition aussi dans le SQL) */
    public function updateParAuteur(Reclamation $r): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE reclamation SET sujet = :sujet, description = :description, type_probleme = :type
             WHERE id_reclamation = :id AND id_utilisateur = :auteur AND statut = 'en_attente'"
        );
        return $stmt->execute([
            'sujet'       => $r->getSujet(),
            'description' => $r->getDescription(),
            'type'        => $r->getTypeProbleme(),
            'id'          => $r->getId(),
            'auteur'      => $r->getIdUtilisateur(),
        ]);
    }

    /** UPDATE par l'admin : statut, réponse, admin qui traite ; date remplie à la clôture */
    public function enregistrerTraitement(Reclamation $r): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE reclamation
             SET statut = :statut, reponse = :reponse, id_admin = :admin,
                 date_traitement = IF(:statut2 IN ('resolue', 'rejetee'), NOW(), NULL)
             WHERE id_reclamation = :id"
        );
        return $stmt->execute([
            'statut'  => $r->getStatut(),
            'statut2' => $r->getStatut(),
            'reponse' => $r->getReponse(),
            'admin'   => $r->getIdAdmin(),
            'id'      => $r->getId(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM reclamation WHERE id_reclamation = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function countEnAttente(int $idUtilisateur): int
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM reclamation WHERE id_utilisateur = :id AND statut = 'en_attente'"
        );
        $stmt->execute(['id' => $idUtilisateur]);
        return (int) $stmt->fetchColumn();
    }

    /** Compteurs par statut : ['en_attente' => 2, ...] (de tout le monde, ou d'un utilisateur) */
    public function countParStatut(?int $idUtilisateur = null): array
    {
        $sql    = 'SELECT statut, COUNT(*) AS nb FROM reclamation';
        $params = [];
        if ($idUtilisateur !== null) {
            $sql .= ' WHERE id_utilisateur = :id';
            $params['id'] = $idUtilisateur;
        }
        $stmt = $this->db->prepare($sql . ' GROUP BY statut');
        $stmt->execute($params);

        $stats = array_fill_keys(array_keys(self::STATUTS), 0);
        foreach ($stmt->fetchAll() as $ligne) {
            $stats[$ligne['statut']] = (int) $ligne['nb'];
        }
        return $stats;
    }

    /** Validation (auteur) : renvoie [champ => message] */
    private function valider(array $d): array
    {
        $errors = [];
        if (mb_strlen($d['sujet']) < 5 || mb_strlen($d['sujet']) > 150) {
            $errors['sujet'] = 'Le sujet doit contenir entre 5 et 150 caractères.';
        }
        if (!isset(self::TYPES[$d['type_probleme']])) {
            $errors['type_probleme'] = 'Choisissez le module concerné.';
        }
        if (mb_strlen($d['description']) < 20 || mb_strlen($d['description']) > 2000) {
            $errors['description'] = 'La description doit contenir entre 20 et 2000 caractères.';
        }
        return $errors;
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=mes-reclamations
    // ==============================================================

    public function mesReclamations(): void
    {
        $this->requireLogin('mes-reclamations');
        $idUser = (int) $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            $r = $this->findById((int) input($_POST, 'delete_id'));

            // Règles métiers : uniquement SA réclamation, et seulement si elle n'est pas encore prise en charge
            if ($r === null || $r->getIdUtilisateur() !== $idUser) {
                setFlash('danger', 'Réclamation introuvable.');
            } elseif ($r->getStatut() !== 'en_attente') {
                setFlash('danger', 'Cette réclamation est déjà prise en charge : elle ne peut plus être retirée.');
            } else {
                $this->delete($r->getId());
                setFlash('success', 'Réclamation retirée.');
            }
            $this->redirect('mes-reclamations');
        }

        $this->renderFront('mes-reclamations', [
            'reclamations' => $this->byUtilisateur($idUser),
            'stats'        => $this->countParStatut($idUser),
            'peutDeposer'  => $this->countEnAttente($idUser) < self::MAX_EN_ATTENTE,
            'maxEnAttente' => self::MAX_EN_ATTENTE,
            'types'        => self::TYPES,
            'statuts'      => self::STATUTS,
            'flash'        => takeFlash(),
        ]);
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=reclamation-form (&id=3 pour modifier)
    // ==============================================================

    public function formulaire(): void
    {
        $this->requireLogin('reclamation-form');
        $idUser = (int) $_SESSION['user_id'];

        $id  = (int) input($_GET, 'id');
        $old = ['sujet' => '', 'type_probleme' => input($_GET, 'type'), 'description' => ''];

        if ($id > 0) {
            $r = $this->findById($id);
            if ($r === null || $r->getIdUtilisateur() !== $idUser) {
                setFlash('danger', 'Réclamation introuvable.');
                $this->redirect('mes-reclamations');
            }
            if ($r->getStatut() !== 'en_attente') {
                setFlash('danger', 'Cette réclamation est déjà prise en charge : elle ne peut plus être modifiée.');
                $this->redirect('mes-reclamations');
            }
            $old = ['sujet' => $r->getSujet(), 'type_probleme' => $r->getTypeProbleme(), 'description' => $r->getDescription()];
        } elseif ($this->countEnAttente($idUser) >= self::MAX_EN_ATTENTE) {
            setFlash('danger', 'Tu as déjà ' . self::MAX_EN_ATTENTE . ' réclamations en attente : attends qu\'elles soient traitées.');
            $this->redirect('mes-reclamations');
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            foreach ($old as $champ => $_) {
                $old[$champ] = input($_POST, $champ);
            }
            $errors = $this->valider($old);

            if ($errors === []) {
                $r = new Reclamation();
                $r->setId($id);
                $r->setSujet($old['sujet']);
                $r->setTypeProbleme($old['type_probleme']);
                $r->setDescription($old['description']);
                $r->setIdUtilisateur($idUser);                 // l'auteur vient de la session, jamais du formulaire

                if ($id > 0) {
                    $this->updateParAuteur($r);
                    setFlash('success', 'Réclamation modifiée.');
                } else {
                    $this->insert($r);
                    setFlash('success', 'Réclamation envoyée : l\'équipe Mahara va la traiter.');
                }
                $this->redirect('mes-reclamations');
            }
        }

        $this->renderFront('reclamation-form', [
            'id'     => $id,
            'old'    => $old,
            'errors' => $errors,
            'types'  => self::TYPES,
        ]);
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-reclamations
    // ==============================================================

    public function liste(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-reclamations';
        $this->title = 'Réclamations | Mahara Admin';

        $filtres = ['q' => input($_GET, 'q'), 'statut' => input($_GET, 'statut'), 'type' => input($_GET, 'type')];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            $id = (int) input($_POST, 'delete_id');
            if ($this->findById($id) === null) {
                setFlash('danger', 'Réclamation introuvable.');
            } else {
                $this->delete($id);
                setFlash('success', 'Réclamation supprimée.');
            }
            $this->redirect('admin-reclamations', array_filter($filtres));
        }

        $this->render('reclamations', [
            'reclamations' => $this->search($filtres['q'], $filtres['statut'], $filtres['type']),
            'stats'        => $this->countParStatut(),
            'filtres'      => $filtres,
            'types'        => self::TYPES,
            'statuts'      => self::STATUTS,
            'roles'        => UtilisateurController::ROLES,
            'flash'        => takeFlash(),
        ]);
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-reclamation-form&id=3
    // Règle du MCD : « Traiter » concerne uniquement les administrateurs
    // ==============================================================

    public function traitement(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-reclamation-form';
        $this->title = 'Traiter une réclamation | Mahara Admin';

        $reclamation = $this->findById((int) input($_GET, 'id'));
        if ($reclamation === null) {
            setFlash('danger', 'Réclamation introuvable.');
            $this->redirect('admin-reclamations');
        }

        $old = [
            'statut'  => $reclamation->getStatut() === 'en_attente' ? 'en_cours' : $reclamation->getStatut(),
            'reponse' => (string) $reclamation->getReponse(),
        ];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            $old = ['statut' => input($_POST, 'statut'), 'reponse' => input($_POST, 'reponse')];

            if (!in_array($old['statut'], self::STATUTS_TRAITEMENT, true)) {
                $errors['statut'] = 'Choisissez un statut.';
            }
            // Règle métier : on ne clôture pas une réclamation sans répondre à l'utilisateur
            if (in_array($old['statut'], ['resolue', 'rejetee'], true) && mb_strlen($old['reponse']) < 10) {
                $errors['reponse'] = 'Une réponse d\'au moins 10 caractères est obligatoire pour clôturer la réclamation.';
            } elseif (mb_strlen($old['reponse']) > 2000) {
                $errors['reponse'] = 'La réponse ne doit pas dépasser 2000 caractères.';
            }

            if ($errors === []) {
                $reclamation->setStatut($old['statut']);
                $reclamation->setReponse($old['reponse'] !== '' ? $old['reponse'] : null);
                $reclamation->setIdAdmin((int) $_SESSION['user_id']);   // l'admin connecté
                $this->enregistrerTraitement($reclamation);
                setFlash('success', 'Réclamation mise à jour.');
                $this->redirect('admin-reclamations');
            }
        }

        $this->render('reclamation-form', [
            'reclamation'       => $reclamation,
            'old'               => $old,
            'errors'            => $errors,
            'types'             => self::TYPES,
            'statuts'           => self::STATUTS,
            'statutsTraitement' => self::STATUTS_TRAITEMENT,
            'roles'             => UtilisateurController::ROLES,
        ]);
    }
}
