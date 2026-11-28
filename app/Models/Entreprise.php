<?php

namespace App\Models;

/**
 * Modèle (entité) : une entreprise de la table « entreprise » (module P3 · Recrutement).
 * Relation du MCD : Utilisateur (recruteur) 1 ---- N Entreprise  (« Gérer »)
 * Les attributs recruteur, recruteurEmail et nbOffres viennent des jointures.
 */
class Entreprise
{
    /** Dossier des logos envoyés, à côté de index.php (métier avancé : logo de l'entreprise) */
    public const DOSSIER_LOGOS = 'uploads/logos';

    /** Couleurs du logo automatique : [fond, texte] (couleurs du template) */
    private const COULEURS_LOGO = [
        ['#2675B8', '#FFFFFF'],
        ['#F3852C', '#1C335F'],
        ['#2EAD6B', '#FFFFFF'],
        ['#1C335F', '#FFFFFF'],
        ['#7B5CD6', '#FFFFFF'],
    ];

    // ------------------------------------------------------------
    // ATTRIBUTS
    // ------------------------------------------------------------

    private int $id = 0;
    private string $nom = '';
    private ?string $secteur = null;
    private ?string $ville = null;
    private ?string $siteWeb = null;
    private ?string $logo = null;            // nom du fichier image dans uploads/logos (null = logo avec les initiales)
    private string $statut = 'en_attente';   // en_attente, verifiee ou refusee (décision de l'admin)
    private int $idRecruteur = 0;            // clé étrangère : le recruteur (utilisateur)
    private string $recruteur = '';          // jointure : prénom + nom du recruteur
    private string $recruteurEmail = '';     // jointure
    private int $nbOffres = 0;               // jointure : nombre d'offres publiées

    // ------------------------------------------------------------
    // GETTERS
    // ------------------------------------------------------------

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getIdRecruteur(): int
    {
        return $this->idRecruteur;
    }

    public function getRecruteur(): string
    {
        return $this->recruteur;
    }

    public function getRecruteurEmail(): string
    {
        return $this->recruteurEmail;
    }

    public function getNbOffres(): int
    {
        return $this->nbOffres;
    }

    // ------------------------------------------------------------
    // SETTERS
    // ------------------------------------------------------------

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setSecteur(?string $secteur): void
    {
        $this->secteur = $secteur;
    }

    public function setVille(?string $ville): void
    {
        $this->ville = $ville;
    }

    public function setSiteWeb(?string $siteWeb): void
    {
        $this->siteWeb = $siteWeb;
    }

    public function setLogo(?string $logo): void
    {
        $this->logo = $logo;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setIdRecruteur(int $idRecruteur): void
    {
        $this->idRecruteur = $idRecruteur;
    }

    public function setRecruteur(string $recruteur): void
    {
        $this->recruteur = $recruteur;
    }

    public function setRecruteurEmail(string $recruteurEmail): void
    {
        $this->recruteurEmail = $recruteurEmail;
    }

    public function setNbOffres(int $nbOffres): void
    {
        $this->nbOffres = $nbOffres;
    }

    // ------------------------------------------------------------
    // CONVERSION : ligne SQL (tableau) -> objet
    // ------------------------------------------------------------

    public static function fromArray(array $row): self
    {
        $entreprise = new self();

        $entreprise->setId((int) ($row['id_entreprise'] ?? 0));
        $entreprise->setNom((string) ($row['nom'] ?? ''));
        $entreprise->setSecteur(isset($row['secteur']) ? (string) $row['secteur'] : null);
        $entreprise->setVille(isset($row['ville']) ? (string) $row['ville'] : null);
        $entreprise->setSiteWeb(isset($row['site_web']) ? (string) $row['site_web'] : null);
        $entreprise->setLogo(!empty($row['logo']) ? (string) $row['logo'] : null);
        $entreprise->setStatut((string) ($row['statut'] ?? 'en_attente'));
        $entreprise->setIdRecruteur((int) ($row['id_recruteur'] ?? 0));
        $entreprise->setRecruteur((string) ($row['recruteur'] ?? ''));
        $entreprise->setRecruteurEmail((string) ($row['recruteur_email'] ?? ''));
        $entreprise->setNbOffres((int) ($row['nb_offres'] ?? 0));

        return $entreprise;
    }

    // ------------------------------------------------------------
    // LOGO AUTOMATIQUE (quand l'entreprise n'a pas envoyé d'image)
    // ------------------------------------------------------------

    /** Initiales du nom : « Agence Digitale Sfax » -> « AD », « Vermeg » -> « VE » */
    public static function initialesDe(string $nom): string
    {
        $mots = array_values(array_filter(
            preg_split('/[\s\'’-]+/u', $nom) ?: [],
            fn($m) => mb_strlen($m) > 2 || preg_match('/^\p{Lu}/u', $m)   // on saute « de », « la », « et »…
        ));
        if (count($mots) >= 2) {
            return mb_strtoupper(mb_substr($mots[0], 0, 1) . mb_substr($mots[1], 0, 1));
        }
        return mb_strtoupper(mb_substr($mots[0] ?? $nom, 0, 2));
    }

    /** Couleur du logo automatique : toujours la même pour un même nom. Renvoie [fond, texte]. */
    public static function couleurDe(string $nom): array
    {
        return self::COULEURS_LOGO[crc32(mb_strtolower(trim($nom))) % count(self::COULEURS_LOGO)];
    }
}
