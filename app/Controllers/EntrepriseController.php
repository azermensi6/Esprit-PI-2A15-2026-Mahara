<?php

namespace App\Controllers;

use App\Models\Entreprise;

/**
 * Entreprises (module P3 · Recrutement) :
 *  - front office (recruteur) : créer, modifier, supprimer SON entreprise + voir / supprimer ses offres ;
 *  - back office  (admin)     : liste filtrée, ajout, modification, vérification (statut), suppression.
 * Jointures : entreprise.id_recruteur -> utilisateur ; COUNT des offres (offre_emploi.id_entreprise).
 */
class EntrepriseController extends Controller
{
    /** Valeurs autorisées par la base (ENUM) => libellé affiché */
    public const STATUTS = ['en_attente' => 'En attente', 'verifiee' => 'Vérifiée', 'refusee' => 'Refusée'];

    /** Partie commune des requêtes : entreprise + recruteur (JOIN) + nombre d'offres (sous-requête COUNT) */
    private const SELECT = "SELECT e.*,
                CONCAT(u.prenom, ' ', u.nom) AS recruteur, u.email AS recruteur_email,
                (SELECT COUNT(*) FROM offre_emploi o WHERE o.id_entreprise = e.id_entreprise) AS nb_offres
            FROM entreprise e
            JOIN utilisateur u ON e.id_recruteur = u.id_utilisateur";

    // ==============================================================
    // ACCÈS AUX DONNÉES (requêtes préparées)
    // ==============================================================

    /** @return Entreprise[] toutes les entreprises, filtrées (mot-clé, statut) */
    public function search(string $q = '', string $statut = ''): array
    {
        $sql    = self::SELECT . ' WHERE 1 = 1';
        $params = [];

        if ($q !== '') {
            $sql .= ' AND (e.nom LIKE :q1 OR e.secteur LIKE :q2 OR e.ville LIKE :q3 OR u.nom LIKE :q4 OR u.prenom LIKE :q5)';
            $params['q1'] = $params['q2'] = $params['q3'] = $params['q4'] = $params['q5'] = '%' . $q . '%';
        }
        if (isset(self::STATUTS[$statut])) {
            $sql .= ' AND e.statut = :statut';
            $params['statut'] = $statut;
        }
        // Les entreprises à vérifier d'abord, puis par nom
        $sql .= " ORDER BY FIELD(e.statut, 'en_attente', 'verifiee', 'refusee'), e.nom";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return array_map(fn(array $row) => Entreprise::fromArray($row), $stmt->fetchAll());
    }

    /** @return Entreprise[] toutes les entreprises, par nom (listes déroulantes) */
    public function findAll(): array
    {
        $stmt = $this->db->query(self::SELECT . ' ORDER BY e.nom');
        return array_map(fn(array $row) => Entreprise::fromArray($row), $stmt->fetchAll());
    }

    public function findById(int $id): ?Entreprise
    {
        $stmt = $this->db->prepare(self::SELECT . ' WHERE e.id_entreprise = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? Entreprise::fromArray($row) : null;
    }

    /** L'entreprise d'un recruteur (règle métier : une seule entreprise par recruteur) */
    public function findByRecruteur(int $idRecruteur): ?Entreprise
    {
        $stmt = $this->db->prepare(self::SELECT . ' WHERE e.id_recruteur = :id LIMIT 1');
        $stmt->execute(['id' => $idRecruteur]);
        $row = $stmt->fetch();
        return $row ? Entreprise::fromArray($row) : null;
    }

    public function insert(Entreprise $e): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO entreprise (nom, secteur, ville, site_web, statut, id_recruteur)
             VALUES (:nom, :secteur, :ville, :site, :statut, :recruteur)'
        );
        return $stmt->execute([
            'nom'       => $e->getNom(),
            'secteur'   => $e->getSecteur(),
            'ville'     => $e->getVille(),
            'site'      => $e->getSiteWeb(),
            'statut'    => $e->getStatut(),
            'recruteur' => $e->getIdRecruteur(),
        ]);
    }

    /** UPDATE complet (admin, ou recruteur : la condition sur id_recruteur protège son entreprise) */
    public function update(Entreprise $e): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE entreprise
             SET nom = :nom, secteur = :secteur, ville = :ville, site_web = :site, statut = :statut, id_recruteur = :recruteur
             WHERE id_entreprise = :id'
        );
        return $stmt->execute([
            'nom'       => $e->getNom(),
            'secteur'   => $e->getSecteur(),
            'ville'     => $e->getVille(),
            'site'      => $e->getSiteWeb(),
            'statut'    => $e->getStatut(),
            'recruteur' => $e->getIdRecruteur(),
            'id'        => $e->getId(),
        ]);
    }

    /** Décision de l'admin : vérifiée / refusée / en attente */
    public function updateStatut(int $id, string $statut): bool
    {
        $stmt = $this->db->prepare('UPDATE entreprise SET statut = :statut WHERE id_entreprise = :id');
        return $stmt->execute(['statut' => $statut, 'id' => $id]);
    }

    /** DELETE : les offres de l'entreprise sont supprimées aussi (ON DELETE CASCADE) */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM entreprise WHERE id_entreprise = :id');
        return $stmt->execute(['id' => $id]);
    }

    /** Contrôle de saisie : deux entreprises ne peuvent pas porter le même nom */
    public function nomExiste(string $nom, int $exceptId = 0): bool
    {
        $stmt = $this->db->prepare(
            'SELECT id_entreprise FROM entreprise WHERE LOWER(nom) = LOWER(:nom) AND id_entreprise <> :id LIMIT 1'
        );
        $stmt->execute(['nom' => $nom, 'id' => $exceptId]);
        return $stmt->fetchColumn() !== false;
    }

    /**
     * Recruteurs proposés dans le formulaire admin : ceux qui n'ont pas encore d'entreprise
     * (+ le recruteur actuel de l'entreprise modifiée).
     * @return array<int, string> [id_utilisateur => 'Prénom Nom (email)']
     */
    public function recruteursDisponibles(int $idEntreprise = 0): array
    {
        $stmt = $this->db->prepare(
            "SELECT u.id_utilisateur, CONCAT(u.prenom, ' ', u.nom, ' (', u.email, ')') AS libelle
             FROM utilisateur u
             LEFT JOIN entreprise e ON e.id_recruteur = u.id_utilisateur AND e.id_entreprise <> :id
             WHERE u.role = 'recruteur' AND e.id_entreprise IS NULL
             ORDER BY u.nom, u.prenom"
        );
        $stmt->execute(['id' => $idEntreprise]);
        $liste = [];
        foreach ($stmt->fetchAll() as $ligne) {
            $liste[(int) $ligne['id_utilisateur']] = $ligne['libelle'];
        }
        return $liste;
    }

    /** Vrai si l'utilisateur est un recruteur qui n'a pas encore d'entreprise (autre que $idEntreprise) */
    private function recruteurValide(int $idRecruteur, int $idEntreprise = 0): bool
    {
        return isset($this->recruteursDisponibles($idEntreprise)[$idRecruteur]);
    }

    /** Compteurs par statut : ['en_attente' => 2, ...] */
    public function countParStatut(): array
    {
        $stmt  = $this->db->query('SELECT statut, COUNT(*) AS nb FROM entreprise GROUP BY statut');
        $stats = array_fill_keys(array_keys(self::STATUTS), 0);
        foreach ($stmt->fetchAll() as $ligne) {
            $stats[$ligne['statut']] = (int) $ligne['nb'];
        }
        return $stats;
    }

    /** Validation des informations de l'entreprise : renvoie [champ => message] */
    private function valider(array $d, int $exceptId = 0): array
    {
        $errors = [];
        if (mb_strlen($d['nom']) < 2 || mb_strlen($d['nom']) > 100) {
            $errors['nom'] = 'Le nom doit contenir entre 2 et 100 caractères.';
        } elseif ($this->nomExiste($d['nom'], $exceptId)) {
            $errors['nom'] = 'Une entreprise porte déjà ce nom.';
        }
        if ($d['secteur'] !== '' && (mb_strlen($d['secteur']) < 2 || mb_strlen($d['secteur']) > 60)) {
            $errors['secteur'] = 'Le secteur doit contenir entre 2 et 60 caractères.';
        }
        if ($d['ville'] !== '' && !preg_match('/^\p{L}[\p{L} \'-]{1,59}$/u', $d['ville'])) {
            $errors['ville'] = 'La ville doit contenir entre 2 et 60 lettres.';
        }
        if ($d['site_web'] !== '' && (
            mb_strlen($d['site_web']) > 255
            || filter_var($d['site_web'], FILTER_VALIDATE_URL) === false
            || !preg_match('#^https?://#i', $d['site_web'])
        )) {
            $errors['site_web'] = 'Le site web doit être une adresse valide commençant par http:// ou https://';
        }
        return $errors;
    }

    /** Champ texte optionnel : '' -> NULL en base */
    private static function nullSiVide(string $valeur): ?string
    {
        return $valeur !== '' ? $valeur : null;
    }

    /** Remplit un objet Entreprise avec les champs du formulaire */
    private function remplir(Entreprise $e, array $d): Entreprise
    {
        $e->setNom($d['nom']);
        $e->setSecteur(self::nullSiVide($d['secteur']));
        $e->setVille(self::nullSiVide($d['ville']));
        $e->setSiteWeb(self::nullSiVide($d['site_web']));
        return $e;
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=mon-entreprise (recruteur)
    // Règle du MCD « Gérer » : un recruteur gère son entreprise
    // ==============================================================

    public function monEntreprise(): void
    {
        $this->requireLogin('mon-entreprise');
        if (($_SESSION['role'] ?? '') !== 'recruteur') {
            setFlash('danger', 'L\'espace « Mon entreprise » est réservé aux recruteurs.');
            $this->redirect('offres');
        }
        $idUser     = (int) $_SESSION['user_id'];
        $entreprise = $this->findByRecruteur($idUser);
        $offres     = new OffreController();

        $old = [
            'nom'      => $entreprise?->getNom() ?? '',
            'secteur'  => (string) $entreprise?->getSecteur(),
            'ville'    => (string) $entreprise?->getVille(),
            'site_web' => (string) $entreprise?->getSiteWeb(),
        ];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            $action = input($_POST, 'action');

            // ---------- Supprimer une de MES offres ----------
            if ($action === 'supprimer_offre') {
                $offre = $offres->findById((int) input($_POST, 'id_offre'));
                if ($offre === null || $offre->getIdRecruteur() !== $idUser) {
                    setFlash('danger', 'Offre introuvable.');
                } else {
                    $offres->delete($offre->getId());
                    setFlash('success', 'Offre supprimée.');
                }
                $this->redirect('mon-entreprise');
            }

            // ---------- Supprimer MON entreprise (et ses offres) ----------
            if ($action === 'supprimer_entreprise') {
                if ($entreprise !== null) {
                    $this->delete($entreprise->getId());
                    setFlash('success', 'Entreprise supprimée, ainsi que ses offres.');
                }
                $this->redirect('mon-entreprise');
            }

            // ---------- Créer / modifier MON entreprise ----------
            foreach ($old as $champ => $_) {
                $old[$champ] = input($_POST, $champ);
            }
            $errors = $this->valider($old, $entreprise?->getId() ?? 0);

            if ($errors === []) {
                if ($entreprise === null) {
                    $e = $this->remplir(new Entreprise(), $old);
                    $e->setStatut('en_attente');          // toute nouvelle entreprise est vérifiée par l'admin
                    $e->setIdRecruteur($idUser);           // le recruteur vient de la session, jamais du formulaire
                    $this->insert($e);
                    setFlash('success', 'Entreprise enregistrée : elle sera visible après vérification par l\'équipe Mahara.');
                } else {
                    // Règle métier : une entreprise refusée, ou vérifiée dont le nom change, repasse en vérification
                    $nomChange    = mb_strtolower($old['nom']) !== mb_strtolower($entreprise->getNom());
                    $ancienStatut = $entreprise->getStatut();
                    $statut       = $ancienStatut;
                    if ($statut === 'refusee' || ($statut === 'verifiee' && $nomChange)) {
                        $statut = 'en_attente';
                    }
                    $e = $this->remplir($entreprise, $old);
                    $e->setStatut($statut);
                    $this->update($e);
                    setFlash('success', $statut !== $ancienStatut
                        ? 'Entreprise modifiée : elle repasse en vérification.'
                        : 'Entreprise modifiée.');
                }
                $this->redirect('mon-entreprise');
            }
        }

        $this->renderFront('mon-entreprise', [
            'entreprise' => $entreprise,
            'offres'     => $entreprise ? $offres->byEntreprise($entreprise->getId()) : [],
            'old'        => $old,
            'errors'     => $errors,
            'statuts'    => self::STATUTS,
            'types'      => OffreController::TYPES,
            'flash'      => takeFlash(),
        ]);
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-entreprises
    // ==============================================================

    public function liste(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-entreprises';
        $this->title = 'Entreprises | Mahara Admin';

        $filtres = ['q' => input($_GET, 'q'), 'statut' => input($_GET, 'statut')];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            $id     = (int) input($_POST, 'id');
            $action = input($_POST, 'action');

            if ($this->findById($id) === null) {
                setFlash('danger', 'Entreprise introuvable.');
            } elseif ($action === 'supprimer') {
                $this->delete($id);
                setFlash('success', 'Entreprise supprimée, ainsi que ses offres.');
            } elseif ($action === 'verifier' || $action === 'refuser') {
                $this->updateStatut($id, $action === 'verifier' ? 'verifiee' : 'refusee');
                setFlash('success', $action === 'verifier' ? 'Entreprise vérifiée : ses offres sont visibles.' : 'Entreprise refusée.');
            }
            $this->redirect('admin-entreprises', array_filter($filtres));
        }

        $this->render('entreprises', [
            'entreprises' => $this->search($filtres['q'], $filtres['statut']),
            'stats'       => $this->countParStatut(),
            'filtres'     => $filtres,
            'statuts'     => self::STATUTS,
            'flash'       => takeFlash(),
        ]);
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-entreprise-form (&id=3 pour modifier)
    // ==============================================================

    public function formulaire(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-entreprise-form';

        $id         = (int) input($_GET, 'id');
        $entreprise = null;
        $old = ['nom' => '', 'secteur' => '', 'ville' => '', 'site_web' => '', 'statut' => 'en_attente', 'id_recruteur' => ''];

        if ($id > 0) {
            $entreprise = $this->findById($id);
            if ($entreprise === null) {
                setFlash('danger', 'Entreprise introuvable.');
                $this->redirect('admin-entreprises');
            }
            $old = [
                'nom'          => $entreprise->getNom(),
                'secteur'      => (string) $entreprise->getSecteur(),
                'ville'        => (string) $entreprise->getVille(),
                'site_web'     => (string) $entreprise->getSiteWeb(),
                'statut'       => $entreprise->getStatut(),
                'id_recruteur' => (string) $entreprise->getIdRecruteur(),
            ];
        }
        $this->title = ($id > 0 ? 'Modifier' : 'Ajouter') . ' une entreprise | Mahara Admin';
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            foreach ($old as $champ => $_) {
                $old[$champ] = input($_POST, $champ);
            }
            $errors = $this->valider($old, $id);
            if (!isset(self::STATUTS[$old['statut']])) {
                $errors['statut'] = 'Choisissez un statut.';
            }
            if (!$this->recruteurValide((int) $old['id_recruteur'], $id)) {
                $errors['id_recruteur'] = 'Choisissez un recruteur qui n\'a pas encore d\'entreprise.';
            }

            if ($errors === []) {
                $e = $this->remplir($entreprise ?? new Entreprise(), $old);
                $e->setStatut($old['statut']);
                $e->setIdRecruteur((int) $old['id_recruteur']);

                if ($id > 0) {
                    $this->update($e);
                    setFlash('success', 'Entreprise modifiée.');
                } else {
                    $this->insert($e);
                    setFlash('success', 'Entreprise ajoutée.');
                }
                $this->redirect('admin-entreprises');
            }
        }

        $this->render('entreprise-form', [
            'id'         => $id,
            'entreprise' => $entreprise,
            'offres'     => $id > 0 ? (new OffreController())->byEntreprise($id) : [],
            'old'        => $old,
            'errors'     => $errors,
            'statuts'    => self::STATUTS,
            'types'      => OffreController::TYPES,
            'recruteurs' => $this->recruteursDisponibles($id),
        ]);
    }
}
