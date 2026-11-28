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

    /** Règle métier : nombre maximum d'offres actives (non expirées) par entreprise */
    public const MAX_OFFRES_ACTIVES = 5;

    /** Règle métier : une offre reste publiée au maximum 90 jours (date limite obligatoire) */
    public const DUREE_MAX_JOURS = 90;

    /** Métier simple : tris proposés (clé => libellé). La clé choisit un ORDER BY écrit ici, jamais par l'utilisateur. */
    public const TRIS = [
        'recent'       => 'Plus récentes',
        'limite'       => 'Date limite la plus proche',
        'salaire_desc' => 'Salaire le plus élevé',
        'salaire_asc'  => 'Salaire le plus bas',
    ];
    private const ORDRES = [
        'recent'       => 'o.date_publication DESC, o.id_offre DESC',
        'limite'       => 'o.date_limite IS NULL, o.date_limite ASC, o.id_offre DESC',
        'salaire_desc' => 'o.salaire IS NULL, o.salaire DESC, o.id_offre DESC',
        'salaire_asc'  => 'o.salaire IS NULL, o.salaire ASC, o.id_offre DESC',
    ];

    /**
     * Métier avancé : carte des offres. Projection du fond de carte (Views/front/carte-tunisie.php) :
     * x = pad + (longitude − lonMin) × cos × échelle ; y = pad + (latMax − latitude) × échelle
     */
    public const CARTE = ['largeur' => 305, 'hauteur' => 620, 'pad' => 16, 'echelle' => 80.218,
                          'cos' => 0.83016, 'lonMin' => 7.47, 'latMax' => 37.55];

    /** Villes placées sur la carte (chefs-lieux des 24 gouvernorats + quelques villes connues), coordonnées approchées */
    private const VILLES_TN = [
        // Grand Tunis : les 4 villes sont très proches, leurs points sont un peu écartés pour rester lisibles
        'tunis' => ['Tunis', 36.81, 10.18],         'ariana' => ['Ariana', 37.10, 10.36],
        'ben arous' => ['Ben Arous', 36.58, 10.33], 'manouba' => ['Manouba', 36.86, 9.90],
        'nabeul' => ['Nabeul', 36.45, 10.74],       'hammamet' => ['Hammamet', 36.40, 10.62],
        'zaghouan' => ['Zaghouan', 36.40, 10.14],   'bizerte' => ['Bizerte', 37.27, 9.87],
        'beja' => ['Béja', 36.73, 9.18],            'jendouba' => ['Jendouba', 36.50, 8.78],
        'kef' => ['Le Kef', 36.18, 8.71],           'siliana' => ['Siliana', 36.08, 9.37],
        'sousse' => ['Sousse', 35.83, 10.64],       'monastir' => ['Monastir', 35.77, 10.83],
        'mahdia' => ['Mahdia', 35.50, 11.06],       'kairouan' => ['Kairouan', 35.68, 10.10],
        'kasserine' => ['Kasserine', 35.17, 8.84],  'sidi bouzid' => ['Sidi Bouzid', 35.04, 9.49],
        'sfax' => ['Sfax', 34.74, 10.76],           'gafsa' => ['Gafsa', 34.42, 8.78],
        'tozeur' => ['Tozeur', 33.92, 8.13],        'kebili' => ['Kébili', 33.70, 8.97],
        'gabes' => ['Gabès', 33.88, 10.10],         'medenine' => ['Médenine', 33.35, 10.50],
        'djerba' => ['Djerba', 33.88, 10.86],       'zarzis' => ['Zarzis', 33.50, 11.11],
        'tataouine' => ['Tataouine', 32.93, 10.45],
    ];
    /** Autres façons d'écrire une ville => clé de VILLES_TN */
    private const ALIAS_VILLES = [
        'le kef' => 'kef', 'la manouba' => 'manouba', 'manubah' => 'manouba', 'sidi bou zid' => 'sidi bouzid',
        'houmt souk' => 'djerba', 'jerba' => 'djerba', 'kassrine' => 'kasserine', 'gabes ville' => 'gabes',
    ];

    /** Métier simple : nombre d'offres par page (front office / back office) */
    public const PAR_PAGE_FRONT = 6;
    public const PAR_PAGE_BACK  = 10;

    /** Partie commune des requêtes : offre + entreprise (JOIN) + recruteur (JOIN) */
    private const SELECT = "SELECT o.*,
                e.nom AS entreprise, e.secteur AS entreprise_secteur, e.ville AS entreprise_ville,
                e.site_web AS entreprise_site_web, e.logo AS entreprise_logo, e.statut AS entreprise_statut,
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
    public function search(string $q = '', string $type = '', string $ville = '', int $idEntreprise = 0, bool $publiques = false,
                           bool $accessibles = false, string $tri = 'recent'): array
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
        if ($accessibles) {
            $sql .= ' AND o.accessible = 1';                 // métier avancé : postes accessibles
        }
        $sql .= ' ORDER BY ' . (self::ORDRES[$tri] ?? self::ORDRES['recent']);   // métier simple : tri

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return array_map(fn(array $row) => OffreEmploi::fromArray($row), $stmt->fetchAll());
    }

    /** @return OffreEmploi[] les offres d'une entreprise */
    public function byEntreprise(int $idEntreprise): array
    {
        return $this->search('', '', '', $idEntreprise);
    }

    /** « Médenine », « medenine », « MEDENINE » ou « Le Kef » → même clé ('medenine', 'kef') */
    private static function cleVille(string $ville): string
    {
        $v = mb_strtolower(trim($ville));
        $v = strtr($v, ['é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'à' => 'a', 'â' => 'a', 'î' => 'i', 'ï' => 'i',
                        'ô' => 'o', 'û' => 'u', 'ù' => 'u', 'ç' => 'c', '-' => ' ', "'" => ' ']);
        $v = preg_replace('/\s+/', ' ', $v);
        return self::ALIAS_VILLES[$v] ?? $v;
    }

    /**
     * Métier avancé : carte des offres. Compte les offres par ville et calcule la position de chaque point.
     * @param OffreEmploi[] $offres
     * @return array{points: array, autres: array<string,int>, total: int}
     */
    public static function carte(array $offres): array
    {
        $parVille = [];                                   // clé => ['nb' => .., 'ecritures' => [ville telle qu'écrite => nb]]
        foreach ($offres as $o) {
            if ($o->getVille() === null || $o->getVille() === '') {
                continue;
            }
            $cle = self::cleVille($o->getVille());
            $parVille[$cle]['nb'] = ($parVille[$cle]['nb'] ?? 0) + 1;
            $parVille[$cle]['ecritures'][$o->getVille()] = ($parVille[$cle]['ecritures'][$o->getVille()] ?? 0) + 1;
        }

        $c = self::CARTE;
        $max = max(1, ...array_values(array_map(fn($v) => $v['nb'], $parVille ?: [['nb' => 1]])));
        $points = [];
        $autres = [];
        foreach ($parVille as $cle => $v) {
            arsort($v['ecritures']);
            $ecriture = (string) array_key_first($v['ecritures']);   // la façon la plus fréquente : sert au filtre Ville
            if (!isset(self::VILLES_TN[$cle])) {
                $autres[$ecriture] = $v['nb'];
                continue;
            }
            [$nom, $lat, $lon] = self::VILLES_TN[$cle];
            $points[] = [
                'nom'    => $nom,
                'ville'  => $ecriture,
                'nb'     => $v['nb'],
                'x'      => round($c['pad'] + ($lon - $c['lonMin']) * $c['cos'] * $c['echelle'], 1),
                'y'      => round($c['pad'] + ($c['latMax'] - $lat) * $c['echelle'], 1),
                'rayon'  => round(6 + 10 * sqrt($v['nb'] / $max), 1),
                'niveau' => self::niveauVille($v['nb'], $max),
            ];
        }
        usort($points, fn($a, $b) => $b['nb'] <=> $a['nb']);      // les gros points d'abord, les petits par-dessus
        arsort($autres);
        $autres = array_map(fn($nb) => ['nb' => $nb, 'niveau' => self::niveauVille($nb, $max)], $autres);
        return ['points' => $points, 'autres' => $autres, 'total' => count($offres)];
    }

    /** Niveaux de la carte : la couleur d'une ville dépend de son nombre d'offres comparé à la ville qui en a le plus. */
    public const NIVEAUX = [
        'fort'   => 'Beaucoup d\'offres',
        'moyen'  => 'Quelques offres',
        'faible' => 'Peu d\'offres',
    ];

    /** fort (vert) : au moins 3/4 du maximum · moyen (orange) : plus d'1/3 · faible (jaune) : le reste. */
    private static function niveauVille(int $nb, int $max): string
    {
        $part = $nb / max(1, $max);
        if ($part >= 3 / 4) {
            return 'fort';
        }
        return $part > 1 / 3 ? 'moyen' : 'faible';
    }

    /**
     * Métier simple : pagination. Découpe une liste en pages.
     * @return array{items: array, page: int, pages: int, total: int}
     */
    public static function paginer(array $liste, int $page, int $parPage): array
    {
        $total = count($liste);
        $pages = max(1, (int) ceil($total / $parPage));
        $page  = min(max(1, $page), $pages);
        return [
            'items' => array_slice($liste, ($page - 1) * $parPage, $parPage),
            'page'  => $page,
            'pages' => $pages,
            'total' => $total,
        ];
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
            'INSERT INTO offre_emploi (titre, type_offre, description, ville, salaire, accessible, date_publication, date_limite, id_entreprise)
             VALUES (:titre, :type, :description, :ville, :salaire, :accessible, CURDATE(), :limite, :entreprise)'
        );
        return $stmt->execute([
            'titre'       => $o->getTitre(),
            'type'        => $o->getTypeOffre(),
            'description' => $o->getDescription(),
            'ville'       => $o->getVille(),
            'salaire'     => $o->getSalaire(),
            'accessible'  => $o->isAccessible() ? 1 : 0,
            'limite'      => $o->getDateLimite(),
            'entreprise'  => $o->getIdEntreprise(),
        ]);
    }

    public function update(OffreEmploi $o): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE offre_emploi
             SET titre = :titre, type_offre = :type, description = :description, ville = :ville,
                 salaire = :salaire, accessible = :accessible, date_limite = :limite, id_entreprise = :entreprise
             WHERE id_offre = :id'
        );
        return $stmt->execute([
            'titre'       => $o->getTitre(),
            'type'        => $o->getTypeOffre(),
            'description' => $o->getDescription(),
            'ville'       => $o->getVille(),
            'salaire'     => $o->getSalaire(),
            'accessible'  => $o->isAccessible() ? 1 : 0,
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
        // Règle métier : date limite obligatoire, entre la publication et publication + 90 jours
        $date = DateTime::createFromFormat('!Y-m-d', $d['date_limite']);
        $min  = $datePublication !== '' ? $datePublication : date('Y-m-d');
        $max  = self::dateMax($datePublication);
        if ($d['date_limite'] === '') {
            $errors['date_limite'] = 'Choisissez une date limite.';
        } elseif ($date === false || $date->format('Y-m-d') !== $d['date_limite']) {
            $errors['date_limite'] = 'Date limite invalide.';
        } elseif ($d['date_limite'] < $min) {
            $errors['date_limite'] = $datePublication !== ''
                ? 'La date limite ne peut pas précéder la date de publication (' . dateFr($datePublication) . ').'
                : 'La date limite ne peut pas être dans le passé.';
        } elseif ($d['date_limite'] > $max) {
            $errors['date_limite'] = 'Une offre reste publiée au maximum ' . self::DUREE_MAX_JOURS
                . ' jours : la date limite doit être au plus tard le ' . dateFr($max) . '.';
        }
        if (mb_strlen($d['description']) < 20 || mb_strlen($d['description']) > 3000) {
            $errors['description'] = 'La description doit contenir entre 20 et 3000 caractères.';
        }
        return $errors;
    }

    /** Date limite la plus lointaine autorisée : publication (ou aujourd'hui) + 90 jours */
    public static function dateMax(string $datePublication = ''): string
    {
        $depart = $datePublication !== '' ? $datePublication : date('Y-m-d');
        return date('Y-m-d', strtotime($depart . ' +' . self::DUREE_MAX_JOURS . ' days'));
    }

    /** Nombre d'offres actives (non expirées) d'une entreprise, sans compter l'offre $exceptId */
    public function countActives(int $idEntreprise, int $exceptId = 0): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM offre_emploi
             WHERE id_entreprise = :entreprise AND id_offre <> :id
               AND (date_limite IS NULL OR date_limite >= CURDATE())'
        );
        $stmt->execute(['entreprise' => $idEntreprise, 'id' => $exceptId]);
        return (int) $stmt->fetchColumn();
    }

    /** Vrai si l'entreprise a déjà une offre active avec le même intitulé */
    public function titreExiste(string $titre, int $idEntreprise, int $exceptId = 0): bool
    {
        $stmt = $this->db->prepare(
            'SELECT id_offre FROM offre_emploi
             WHERE id_entreprise = :entreprise AND id_offre <> :id AND LOWER(titre) = LOWER(:titre)
               AND (date_limite IS NULL OR date_limite >= CURDATE())
             LIMIT 1'
        );
        $stmt->execute(['entreprise' => $idEntreprise, 'id' => $exceptId, 'titre' => $titre]);
        return $stmt->fetchColumn() !== false;
    }

    /**
     * Règles métier liées à l'entreprise (en plus de valider()) : renvoie [champ => message]
     *  - pas deux offres actives avec le même intitulé dans la même entreprise ;
     *  - au maximum 5 offres actives par entreprise (l'offre enregistrée comptera si sa date limite n'est pas passée).
     */
    private function verifierRegles(array $d, int $idEntreprise, int $idOffre = 0): array
    {
        $errors = [];
        if ($idEntreprise <= 0) {
            return $errors;
        }
        if (mb_strlen($d['titre']) >= 5 && $this->titreExiste($d['titre'], $idEntreprise, $idOffre)) {
            $errors['titre'] = 'Cette entreprise a déjà une offre active avec cet intitulé.';
        }
        // La limite ne bloque pas la modification d'une offre déjà active dans la même entreprise
        $actuelle   = $idOffre > 0 ? $this->findById($idOffre) : null;
        $dejaActive = $actuelle !== null && !$actuelle->estExpiree() && $actuelle->getIdEntreprise() === $idEntreprise;
        $seraActive = $d['date_limite'] === '' || $d['date_limite'] >= date('Y-m-d');
        if ($seraActive && !$dejaActive && $this->countActives($idEntreprise, $idOffre) >= self::MAX_OFFRES_ACTIVES) {
            $errors['general'] = 'Une entreprise peut avoir au maximum ' . self::MAX_OFFRES_ACTIVES
                . ' offres actives en même temps. Supprimez une offre ou attendez qu\'une offre expire.';
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
        $o->setAccessible($d['accessible'] === '1');       // case cochée = '1'
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
            'accessible'  => $o?->isAccessible() ? '1' : '',
        ];
    }

    // ==============================================================
    // FRONT OFFICE : index.php?page=offres
    // ==============================================================

    public function liste(): void
    {
        $this->requireLogin('offres');

        $filtres = [
            'q'          => input($_GET, 'q'),
            'type'       => input($_GET, 'type'),
            'ville'      => input($_GET, 'ville'),
            'accessible' => input($_GET, 'accessible') === '1' ? '1' : '',
            'tri'        => isset(self::TRIS[input($_GET, 'tri')]) ? input($_GET, 'tri') : 'recent',
        ];
        $offres = $this->search($filtres['q'], $filtres['type'], $filtres['ville'], 0, true,
                                $filtres['accessible'] === '1', $filtres['tri']);

        $vue = input($_GET, 'vue') === 'carte' ? 'carte' : 'liste';      // métier avancé : vue carte

        $this->renderFront('offres', [
            'vue'        => $vue,
            'carte'      => $vue === 'carte' ? self::carte($offres) : null,
            'pagination' => self::paginer($offres, (int) input($_GET, 'p'), self::PAR_PAGE_FRONT),
            'villes'     => $this->villesPubliques(),
            'filtres'    => $filtres,
            'types'      => self::TYPES,
            'tris'       => self::TRIS,
            'flash'      => takeFlash(),
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
        } else {
            // Règle métier : une entreprise refusée ne peut pas publier de nouvelle offre
            if ($entreprise->getStatut() === 'refusee') {
                setFlash('danger', 'Ton entreprise a été refusée : corrige ses informations avant de publier une nouvelle offre.');
                $this->redirect('mon-entreprise');
            }
            // Règle métier : au maximum 5 offres actives par entreprise
            if ($this->countActives($entreprise->getId()) >= self::MAX_OFFRES_ACTIVES) {
                setFlash('danger', 'Tu as déjà ' . self::MAX_OFFRES_ACTIVES . ' offres actives : supprime une offre ou attends qu\'une offre expire.');
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
            $errors = $this->valider($old, $offre?->getDatePublication() ?? '')
                    + $this->verifierRegles($old, $entreprise->getId(), $id);

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
            'maxDate'    => self::dateMax($offre?->getDatePublication() ?? ''),
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

        $filtres = [
            'q'          => input($_GET, 'q'),
            'type'       => input($_GET, 'type'),
            'entreprise' => input($_GET, 'entreprise'),
            'accessible' => input($_GET, 'accessible') === '1' ? '1' : '',
            'tri'        => isset(self::TRIS[input($_GET, 'tri')]) ? input($_GET, 'tri') : 'recent',
        ];

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
            'pagination'  => self::paginer(
                $this->search($filtres['q'], $filtres['type'], '', (int) $filtres['entreprise'], false,
                              $filtres['accessible'] === '1', $filtres['tri']),
                (int) input($_GET, 'p'), self::PAR_PAGE_BACK),
            'tris'        => self::TRIS,
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
            } else {
                $errors += $this->verifierRegles($old, (int) $old['id_entreprise'], $id);
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
            'maxDate'     => self::dateMax($offre?->getDatePublication() ?? ''),
        ]);
    }

    // ==============================================================
    // BACK OFFICE : index.php?page=admin-statistiques-recrutement (métier avancé : dashboard)
    // Tous les calculs sont faits ici (contrôleur) ; la vue ne fait qu'afficher.
    // ==============================================================

    /** Métier : filtre par période du dashboard (sur la date de publication des offres). */
    public const PERIODES = [
        'tout'  => 'Tout',
        '30j'   => '30 derniers jours',
        '3m'    => '3 derniers mois',
        'annee' => 'Cette année',
    ];

    /** Premier jour de la période choisie (format Y-m-d), ou null pour « Tout ». */
    private static function debutPeriode(string $periode): ?string
    {
        return match ($periode) {
            '30j'   => date('Y-m-d', strtotime('-30 days')),
            '3m'    => date('Y-m-d', strtotime('-3 months')),
            'annee' => date('Y-01-01'),
            default => null,
        };
    }

    public function statistiques(): void
    {
        $this->requireAdmin();
        $this->page  = 'admin-statistiques-recrutement';
        $this->title = 'Statistiques recrutement | Mahara Admin';

        $entreprises = new EntrepriseController();
        $parStatut   = $entreprises->countParStatut();
        $aujourdhui  = date('Y-m-d');

        // ---------- Période choisie : on garde seulement les offres publiées depuis le début de la période ----------
        $periode = input($_GET, 'periode');
        if (!isset(self::PERIODES[$periode])) {
            $periode = 'tout';
        }
        $debut  = self::debutPeriode($periode);
        $offres = $this->search();                            // toutes les offres, avec leur entreprise (JOIN)
        if ($debut !== null) {
            $offres = array_values(array_filter($offres,
                fn(OffreEmploi $o) => substr((string) $o->getDatePublication(), 0, 10) >= $debut));
        }
        $dans7jours  = date('Y-m-d', strtotime('+7 days'));

        // ---------- Chiffres clés ----------
        $actives  = array_values(array_filter($offres, fn(OffreEmploi $o) => !$o->estExpiree()));
        $visibles = array_filter($actives, fn(OffreEmploi $o) => $o->getEntrepriseStatut() === 'verifiee');
        $stages   = array_filter($actives, fn(OffreEmploi $o) => $o->getTypeOffre() === 'stage');
        $accessibles = array_filter($actives, fn(OffreEmploi $o) => $o->isAccessible());
        $salaires = array_filter(array_map(fn(OffreEmploi $o) => $o->getSalaire(), $actives), fn($s) => $s !== null);

        $chiffres = [
            'entreprises'   => array_sum($parStatut),
            'en_attente'    => $parStatut['en_attente'],
            'offres'        => count($offres),
            'actives'       => count($actives),
            'visibles'      => count($visibles),
            'accessibles'   => count($accessibles),
            'part_accessibles'   => count($actives) > 0 ? (int) round(count($accessibles) * 100 / count($actives)) : 0,
            'accessibles_stage'  => count(array_filter($accessibles, fn(OffreEmploi $o) => $o->getTypeOffre() === 'stage')),
            'accessibles_emploi' => count(array_filter($accessibles, fn(OffreEmploi $o) => $o->getTypeOffre() === 'emploi')),
            'part_stages'   => count($actives) > 0 ? (int) round(count($stages) * 100 / count($actives)) : 0,
            'salaire_moyen' => $salaires !== [] ? (int) round(array_sum($salaires) / count($salaires)) : null,
        ];

        // ---------- Offres publiées par mois, stage / emploi (6 derniers mois, ou les mois de la période) ----------
        $moisFr = ['01' => 'janv.', '02' => 'févr.', '03' => 'mars', '04' => 'avr.', '05' => 'mai', '06' => 'juin',
                   '07' => 'juil.', '08' => 'août', '09' => 'sept.', '10' => 'oct.', '11' => 'nov.', '12' => 'déc.'];
        $parMois = [];
        $nbMois = 6;
        if ($debut !== null) {
            $nbMois = (int) date('Y') * 12 + (int) date('n') - ((int) substr($debut, 0, 4) * 12 + (int) substr($debut, 5, 2)) + 1;
        }
        for ($i = $nbMois - 1; $i >= 0; $i--) {
            $cle = date('Y-m', strtotime(date('Y-m-01') . " -$i months"));
            $parMois[$cle] = ['label' => $moisFr[substr($cle, 5, 2)], 'stage' => 0, 'emploi' => 0];
        }
        foreach ($offres as $o) {
            $cle = substr($o->getDatePublication(), 0, 7);
            if (isset($parMois[$cle][$o->getTypeOffre()])) {
                $parMois[$cle][$o->getTypeOffre()]++;
            }
        }
        $maxMois = max(1, ...array_values(array_map(fn($m) => $m['stage'] + $m['emploi'], $parMois)));
        foreach ($parMois as $cle => $m) {
            $parMois[$cle]['hauteur_stage']  = (int) round($m['stage'] * 100 / $maxMois);
            $parMois[$cle]['hauteur_emploi'] = (int) round($m['emploi'] * 100 / $maxMois);
        }

        // ---------- Top 5 des entreprises (offres actives) et des villes ----------
        $compter = function (array $liste, callable $cle): array {
            $total = [];
            foreach ($liste as $o) {
                $nom = $cle($o);
                if ($nom !== null && $nom !== '') {
                    $total[$nom] = ($total[$nom] ?? 0) + 1;
                }
            }
            arsort($total);
            $total = array_slice($total, 0, 5, true);
            $max   = max(1, ...array_values($total ?: [1]));
            $barres = [];
            foreach ($total as $nom => $nb) {
                $barres[] = ['nom' => $nom, 'nb' => $nb, 'largeur' => (int) round($nb * 100 / $max),
                             'niveau' => self::niveauVille($nb, $max)];   // même couleur que la carte
            }
            return $barres;
        };
        $topEntreprises = $compter($actives, fn(OffreEmploi $o) => $o->getEntreprise());
        $topVilles      = $compter($actives, fn(OffreEmploi $o) => $o->getVille());

        // ---------- Entreprises par statut (barres) ----------
        $maxStatut = max(1, ...array_values($parStatut));
        $barresStatut = [];
        foreach (EntrepriseController::STATUTS as $statut => $libelle) {
            $barresStatut[] = ['statut' => $statut, 'nom' => $libelle, 'nb' => $parStatut[$statut],
                               'largeur' => (int) round($parStatut[$statut] * 100 / $maxStatut)];
        }

        // ---------- À traiter : entreprises en attente + offres qui expirent dans 7 jours ----------
        $expirent = array_values(array_filter($actives, fn(OffreEmploi $o) =>
            $o->getDateLimite() !== null && $o->getDateLimite() <= $dans7jours));
        usort($expirent, fn($a, $b) => strcmp($a->getDateLimite(), $b->getDateLimite()));
        $joursRestants = [];
        foreach ($expirent as $o) {
            $joursRestants[$o->getId()] = (int) ((strtotime($o->getDateLimite()) - strtotime($aujourdhui)) / 86400);
        }

        $this->render('statistiques-recrutement', [
            'chiffres'       => $chiffres,
            'parMois'        => $parMois,
            'topEntreprises' => $topEntreprises,
            'topVilles'      => $topVilles,
            'barresStatut'   => $barresStatut,
            'enAttente'      => $entreprises->search('', 'en_attente'),
            'expirent'       => $expirent,
            'joursRestants'  => $joursRestants,
            'types'          => self::TYPES,
            'periode'        => $periode,
            'periodes'       => self::PERIODES,
            'niveaux'        => self::NIVEAUX,
        ]);
    }
}
