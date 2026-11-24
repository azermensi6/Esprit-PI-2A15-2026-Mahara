<?php

namespace App\Controllers;

use App\Models\OffreEmploi;
use DateTime;

/**
 * Offres d'emploi (module P3 · Recrutement) :
 *  - front office : liste filtrée et détail des offres (membres connectés) ;
 *                   publier / modifier une offre (recruteur, pour SON entreprise) ;
 *  - back office  : liste filtrée, ajout, modification, suppression (admin).
 * Jointure du module : offre_emploi.id_entreprise -> entreprise (-> utilisateur pour le recruteur).
 */
class OffreController extends Controller
{
    /** Valeurs autorisées par la base (ENUM) => libellé affiché */
    public const TYPES = ['stage' => 'Stage', 'emploi' => 'Emploi'];

    /** Salaire mensuel maximum accepté (TND) */
    public const SALAIRE_MAX = 50000;

    /** Partie commune des requêtes : offre + entreprise (JOIN) + recruteur (JOIN) */
    private const SELECT = "SELECT o.*,
                e.nom AS entreprise, e.secteur AS entreprise_secteur, e.ville AS entreprise_ville,
                e.site_web AS entreprise_site_web, e.statut AS entreprise_statut,
                e.id_recruteur, u.email AS recruteur_email
            FROM offre_emploi o
            JOIN entreprise  e ON o.id_entreprise = e.id_entreprise
            JOIN utilisateur u ON e.id_recruteur  = u.id_utilisateur";

    /** Règle métier : une offre est publique si son entreprise est vérifiée et si la date limite n'est pas passée */
    private const PUBLIQUE = " e.statut = 'verifiee' AND (o.date_limite IS NULL OR o.date_limite >= CURDATE())";

    // ==============================================================
    // ACCÈS AUX DONNÉES (requêtes préparées)
    // ==============================================================

    /**
     * @return OffreEmploi[] offres filtrées (mot-clé, type, ville, entreprise)
     * $publiques = true : uniquement les offres visibles sur le site
     */
    public function search(string $q = '', string $type = '', string $ville = '', int $idEntreprise = 0, bool $publiques = false): array
    {
        $sql    = self::SELECT . ' WHERE 1 = 1';
        $params = [];

        if ($publiques) {
            $sql .= ' AND' . self::PUBLIQUE;
        }
        if ($q !== '') {
            $sql .= ' AND (o.titre LIKE :q1 OR o.description LIKE :q2 OR e.nom LIKE :q3)';
            $params['q1'] = $params['q2'] = $params['q3'] = '%' . $q . '%';
        }
        if (isset(self::TYPES[$type])) {
            $sql .= ' AND o.type_offre = :type';
            $params['type'] = $type;
        }
        if ($ville !== '') {
            $sql .= ' AND o.ville = :ville';
            $params['ville'] = $ville;
        }
        if ($idEntreprise > 0) {
            $sql .= ' AND o.id_entreprise = :entreprise';
            $params['entreprise'] = $idEntreprise;
        }
        $sql .= ' ORDER BY o.date_publication DESC, o.id_offre DESC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return array_map(fn(array $row) => OffreEmploi::fromArray($row), $stmt->fetchAll());
    }

    /** @return OffreEmploi[] les offres d'une entreprise */
    public function byEntreprise(int $idEntreprise): array
    {
        return $this->search('', '', '', $idEntreprise);
    }

    /** @return string[] villes des offres publiques (liste déroulante du filtre) */
    public function villesPubliques(): array
    {
        $stmt = $this->db->query(
            'SELECT DISTINCT o.ville FROM offre_emploi o JOIN entreprise e ON o.id_entreprise = e.id_entreprise
             WHERE o.ville IS NOT NULL AND o.ville <> \'\' AND' . self::PUBLIQUE . ' ORDER BY o.ville'
        );
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function findById(int $id): ?OffreEmploi
    {
        $stmt = $this->db->prepare(self::SELECT . ' WHERE o.id_offre = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? OffreEmploi::fromArray($row) : null;
    }

    /** INSERT : la date de publication est celle du jour */
    public function insert(OffreEmploi $o): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO offre_emploi (titre, type_offre, description, ville, salaire, date_publication, date_limite, id_entreprise)
             VALUES (:titre, :type, :description, :ville, :salaire, CURDATE(), :limite, :entreprise)'
        );
        return $stmt->execute([
            'titre'       => $o->getTitre(),
            'type'        => $o->getTypeOffre(),
            'description' => $o->getDescription(),
            'ville'       => $o->getVille(),
            'salaire'     => $o->getSalaire(),
            'limite'      => $o->getDateLimite(),
            'entreprise'  => $o->getIdEntreprise(),
        ]);
    }

    public function update(OffreEmploi $o): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE offre_emploi
             SET titre = :titre, type_offre = :type, description = :description, ville = :ville,
                 salaire = :salaire, date_limite = :limite, id_entreprise = :entreprise
             WHERE id_offre = :id'
        );
        return $stmt->execute([
            'titre'       => $o->getTitre(),
            'type'        => $o->getTypeOffre(),
            'description' => $o->getDescription(),
            'ville'       => $o->getVille(),
            'salaire'     => $o->getSalaire(),
            'limite'      => $o->getDateLimite(),
            'entreprise'  => $o->getIdEntreprise(),
            'id'          => $o->getId(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM offre_emploi WHERE id_offre = :id');
        return $stmt->execute(['id' => $id]);
    }

    /** Compteurs par type : ['stage' => 2, 'emploi' => 1] */
    public function countParType(): array
    {
        $stmt  = $this->db->query('SELECT type_offre, COUNT(*) AS nb FROM offre_emploi GROUP BY type_offre');
        $stats = array_fill_keys(array_keys(self::TYPES), 0);
        foreach ($stmt->fetchAll() as $ligne) {
            $stats[$ligne['type_offre']] = (int) $ligne['nb'];
        }
        return $stats;
    }

    /**
     * Validation : renvoie [champ => message]
     * $datePublication : '' pour une nouvelle offre (la date limite ne peut pas être passée)
     */
    private function valider(array $d, string $datePublication = ''): array
    {
        $errors = [];
        if (mb_strlen($d['titre']) < 5 || mb_strlen($d['titre']) > 120) {
            $errors['titre'] = 'L\'intitulé doit contenir entre 5 et 120 caractères.';
        }
        if (!isset(self::TYPES[$d['type_offre']])) {
            $errors['type_offre'] = 'Choisissez le type d\'offre.';
        }
        if ($d['ville'] !== '' && !preg_match('/^\p{L}[\p{L} \'-]{1,59}$/u', $d['ville'])) {
            $errors['ville'] = 'La ville doit contenir entre 2 et 60 lettres.';
        }
        if ($d['salaire'] !== '' && (!is_numeric($d['salaire']) || (float) $d['salaire'] < 0 || (float) $d['salaire'] > self::SALAIRE_MAX)) {
            $errors['salaire'] = 'Le salaire doit être un nombre entre 0 et ' . self::SALAIRE_MAX . ' TND (vide si à négocier).';
        }
        if ($d['date_limite'] !== '') {
            $date = DateTime::createFromFormat('!Y-m-d', $d['date_limite']);
            $min  = $datePublication !== '' ? $datePublication : date('Y-m-d');
            if ($date === false || $date->format('Y-m-d') !== $d['date_limite']) {
                $errors['date_limite'] = 'Date limite invalide.';
            } elseif ($d['date_limite'] < $min) {
                $errors['date_limite'] = $datePublication !== ''
                    ? 'La date limite ne peut pas précéder la date de publication (' . dateFr($datePublication) . ').'
                    : 'La date limite ne peut pas être dans le passé.';
            }
        }
        if (mb_strlen($d['description']) < 20 || mb_strlen($d['description']) > 3000) {
            $errors['description'] = 'La description doit contenir entre 20 et 3000 caractères.';
        }
        return $errors;
    }

    /** Remplit un objet OffreEmploi avec les champs du formulaire */
    private function remplir(OffreEmploi $o, array $d): OffreEmploi
    {
        $o->setTitre($d['titre']);
        $o->setTypeOffre($d['type_offre']);
        $o->setDescription($d['description']);
        $o->setVille($d['ville'] !== '' ? $d['ville'] : null);
        $o->setSalaire($d['salaire'] !== '' ? round((float) $d['salaire'], 2) : null);
        $o->setDateLimite($d['date_limite'] !== '' ? $d['date_limite'] : null);
        return $o;
    }

    /** Champs du formulaire, pré-remplis avec une offre existante (ou vides) */
    private function champs(?OffreEmploi $o = null): array
    {
        return [
            'titre'       => $o?->getTitre() ?? '',
            'type_offre'  => $o?->getTypeOffre() ?? '',
            'ville'       => (string) $o?->getVille(),
            'salaire'     => $o?->getSalaire() !== null ? (string) (0 + $o->getSalaire()) : '',
            'date_limite' => (string) $o?->getDateLimite(),
            'description' => (string) $o?->getDescription(),
        ];
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=offres
    // ==============================================================

    public function liste(): void
    {
        $this->requireLogin('offres');

        $filtres = ['q' => input($_GET, 'q'), 'type' => input($_GET, 'type'), 'ville' => input($_GET, 'ville')];

        $this->renderFront('offres', [
            'offres'  => $this->search($filtres['q'], $filtres['type'], $filtres['ville'], 0, true),
            'villes'  => $this->villesPubliques(),
            'filtres' => $filtres,
            'types'   => self::TYPES,
            'flash'   => takeFlash(),
        ]);
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=offre-detail&id=3
    // ==============================================================

    public function detail(): void
    {
        $this->requireLogin('offres');

        $offre = $this->findById((int) input($_GET, 'id'));

        // Une offre non publique n'est visible que par son recruteur et par l'admin
        $proprietaire = $offre !== null && $offre->getIdRecruteur() === (int) $_SESSION['user_id'];
        $publique     = $offre !== null && $offre->getEntrepriseStatut() === 'verifiee' && !$offre->estExpiree();
        if ($offre === null || (!$publique && !$proprietaire && !isAdmin())) {
            setFlash('danger', 'Cette offre n\'existe pas ou n\'est plus disponible.');
            $this->redirect('offres');
        }

        $this->renderFront('offre-detail', [
            'offre'        => $offre,
            'publique'     => $publique,
            'proprietaire' => $proprietaire,
            'types'        => self::TYPES,
        ]);
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=publier-offre (&id=3 pour modifier) — recruteur
    // Règle du MCD « Proposer » : l'offre appartient à l'entreprise du recruteur connecté
    // ==============================================================

    public function formulaire(): void
    {
        $this->requireLogin('publier-offre');
        if (($_SESSION['role'] ?? '') !== 'recruteur') {
            setFlash('danger', 'La publication d\'offres est réservée aux recruteurs.');
            $this->redirect('offres');
        }
        $idUser     = (int) $_SESSION['user_id'];
        $entreprise = (new EntrepriseController())->findByRecruteur($idUser);

        // Règle métier : il faut d'abord enregistrer son entreprise
        if ($entreprise === null) {
            setFlash('danger', 'Enregistre d\'abord ton entreprise avant de publier une offre.');
            $this->redirect('mon-entreprise');
        }

        $id    = (int) input($_GET, 'id');
        $offre = null;
        if ($id > 0) {
            $offre = $this->findById($id);
            if ($offre === null || $offre->getIdRecruteur() !== $idUser) {
                setFlash('danger', 'Offre introuvable.');
                $this->redirect('mon-entreprise');
            }
        }
        $old    = $this->champs($offre);
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            foreach ($old as $champ => $_) {
                $old[$champ] = input($_POST, $champ);
            }
            $errors = $this->valider($old, $offre?->getDatePublication() ?? '');

            if ($errors === []) {
                $o = $this->remplir($offre ?? new OffreEmploi(), $old);
                $o->setIdEntreprise($entreprise->getId());   // l'entreprise vient de la session, jamais du formulaire

                if ($id > 0) {
                    $this->update($o);
                    setFlash('success', 'Offre modifiée.');
                } else {
                    $this->insert($o);
                    setFlash('success', $entreprise->getStatut() === 'verifiee'
                        ? 'Offre publiée.'
                        : 'Offre enregistrée : elle sera visible dès que ton entreprise sera vérifiée.');
                }
                $this->redirect('mon-entreprise');
            }
        }

        $this->renderFront('publier-offre', [
            'id'         => $id,
            'old'        => $old,
            'errors'     => $errors,
            'types'      => self::TYPES,
            'entreprise' => $entreprise,
            'statuts'    => EntrepriseController::STATUTS,
            'minDate'    => $offre?->getDatePublication() ?? date('Y-m-d'),
        ]);
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-offres
    // ==============================================================

    public function adminListe(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-offres';
        $this->title = 'Offres d\'emploi | Mahara Admin';

        $filtres = ['q' => input($_GET, 'q'), 'type' => input($_GET, 'type'), 'entreprise' => input($_GET, 'entreprise')];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            $id = (int) input($_POST, 'delete_id');
            if ($this->findById($id) === null) {
                setFlash('danger', 'Offre introuvable.');
            } else {
                $this->delete($id);
                setFlash('success', 'Offre supprimée.');
            }
            $this->redirect('admin-offres', array_filter($filtres));
        }

        $this->render('offres', [
            'offres'      => $this->search($filtres['q'], $filtres['type'], '', (int) $filtres['entreprise']),
            'stats'       => $this->countParType(),
            'entreprises' => (new EntrepriseController())->findAll(),
            'filtres'     => $filtres,
            'types'       => self::TYPES,
            'statuts'     => EntrepriseController::STATUTS,
            'flash'       => takeFlash(),
        ]);
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-offre-form (&id=3 pour modifier)
    // ==============================================================

    public function adminFormulaire(): void
    {
        $this->requireAdmin();
        $this->page = 'admin-offre-form';

        $id    = (int) input($_GET, 'id');
        $offre = null;
        if ($id > 0) {
            $offre = $this->findById($id);
            if ($offre === null) {
                setFlash('danger', 'Offre introuvable.');
                $this->redirect('admin-offres');
            }
        }
        $this->title = ($id > 0 ? 'Modifier' : 'Ajouter') . ' une offre | Mahara Admin';

        $entreprises = (new EntrepriseController())->findAll();
        $idsValides  = array_map(fn($e) => $e->getId(), $entreprises);

        $old = $this->champs($offre) + ['id_entreprise' => $offre ? (string) $offre->getIdEntreprise() : input($_GET, 'entreprise')];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->verifierCsrf();
            foreach ($old as $champ => $_) {
                $old[$champ] = input($_POST, $champ);
            }
            $errors = $this->valider($old, $offre?->getDatePublication() ?? '');
            if (!in_array((int) $old['id_entreprise'], $idsValides, true)) {
                $errors['id_entreprise'] = 'Choisissez l\'entreprise qui propose l\'offre.';
            }

            if ($errors === []) {
                $o = $this->remplir($offre ?? new OffreEmploi(), $old);
                $o->setIdEntreprise((int) $old['id_entreprise']);

                if ($id > 0) {
                    $this->update($o);
                    setFlash('success', 'Offre modifiée.');
                } else {
                    $this->insert($o);
                    setFlash('success', 'Offre ajoutée.');
                }
                $this->redirect('admin-offres');
            }
        }

        $this->render('offre-form', [
            'id'          => $id,
            'offre'       => $offre,
            'old'         => $old,
            'errors'      => $errors,
            'types'       => self::TYPES,
            'entreprises' => $entreprises,
            'statuts'     => EntrepriseController::STATUTS,
            'minDate'     => $offre?->getDatePublication() ?? date('Y-m-d'),
        ]);
    }
}
