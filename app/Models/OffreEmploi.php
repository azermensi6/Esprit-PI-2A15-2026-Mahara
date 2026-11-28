<?php

namespace App\Models;

/**
 * Modèle (entité) : une offre de la table « offre_emploi » (module P3 · Recrutement).
 * Relation du MCD : Entreprise 1 ---- N Offre d'emploi  (« Proposer »)
 * Les attributs entreprise*, idRecruteur et recruteurEmail viennent de la jointure
 * offre_emploi -> entreprise -> utilisateur.
 */
class OffreEmploi
{
    // ------------------------------------------------------------
    // ATTRIBUTS
    // ------------------------------------------------------------

    private int $id = 0;
    private string $titre = '';
    private string $typeOffre = 'stage';       // stage ou emploi
    private ?string $description = null;
    private ?string $ville = null;
    private ?float $salaire = null;            // par mois, en TND (NULL = à négocier)
    private bool $accessible = false;          // poste accessible aux personnes en situation de handicap
    private string $datePublication = '';
    private ?string $dateLimite = null;        // NULL = sans date limite
    private int $idEntreprise = 0;             // clé étrangère : l'entreprise qui propose l'offre
    private string $entreprise = '';           // jointure : nom de l'entreprise
    private ?string $entrepriseSecteur = null; // jointure
    private ?string $entrepriseVille = null;   // jointure
    private ?string $entrepriseSiteWeb = null; // jointure
    private ?string $entrepriseLogo = null;    // jointure : fichier du logo de l'entreprise
    private string $entrepriseStatut = '';     // jointure
    private int $idRecruteur = 0;              // jointure : propriétaire de l'entreprise
    private string $recruteurEmail = '';       // jointure

    // ------------------------------------------------------------
    // GETTERS
    // ------------------------------------------------------------

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getTypeOffre(): string
    {
        return $this->typeOffre;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function isAccessible(): bool
    {
        return $this->accessible;
    }

    public function getDatePublication(): string
    {
        return $this->datePublication;
    }

    public function getDateLimite(): ?string
    {
        return $this->dateLimite;
    }

    public function getIdEntreprise(): int
    {
        return $this->idEntreprise;
    }

    public function getEntreprise(): string
    {
        return $this->entreprise;
    }

    public function getEntrepriseSecteur(): ?string
    {
        return $this->entrepriseSecteur;
    }

    public function getEntrepriseVille(): ?string
    {
        return $this->entrepriseVille;
    }

    public function getEntrepriseLogo(): ?string
    {
        return $this->entrepriseLogo;
    }

    public function getEntrepriseSiteWeb(): ?string
    {
        return $this->entrepriseSiteWeb;
    }

    public function getEntrepriseStatut(): string
    {
        return $this->entrepriseStatut;
    }

    public function getIdRecruteur(): int
    {
        return $this->idRecruteur;
    }

    public function getRecruteurEmail(): string
    {
        return $this->recruteurEmail;
    }

    /** Vrai si la date limite est dépassée */
    public function estExpiree(): bool
    {
        return $this->dateLimite !== null && $this->dateLimite < date('Y-m-d');
    }

    /** Salaire lisible : « 1 400 TND / mois » ou « À négocier » */
    public function getSalaireTexte(): string
    {
        return $this->salaire === null
            ? 'À négocier'
            : number_format($this->salaire, 0, ',', ' ') . ' TND / mois';
    }

    // ------------------------------------------------------------
    // SETTERS
    // ------------------------------------------------------------

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    public function setTypeOffre(string $typeOffre): void
    {
        $this->typeOffre = $typeOffre;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setVille(?string $ville): void
    {
        $this->ville = $ville;
    }

    public function setSalaire(?float $salaire): void
    {
        $this->salaire = $salaire;
    }

    public function setAccessible(bool $accessible): void
    {
        $this->accessible = $accessible;
    }

    public function setDatePublication(string $datePublication): void
    {
        $this->datePublication = $datePublication;
    }

    public function setDateLimite(?string $dateLimite): void
    {
        $this->dateLimite = $dateLimite;
    }

    public function setIdEntreprise(int $idEntreprise): void
    {
        $this->idEntreprise = $idEntreprise;
    }

    public function setEntreprise(string $entreprise): void
    {
        $this->entreprise = $entreprise;
    }

    public function setEntrepriseSecteur(?string $entrepriseSecteur): void
    {
        $this->entrepriseSecteur = $entrepriseSecteur;
    }

    public function setEntrepriseVille(?string $entrepriseVille): void
    {
        $this->entrepriseVille = $entrepriseVille;
    }

    public function setEntrepriseLogo(?string $entrepriseLogo): void
    {
        $this->entrepriseLogo = $entrepriseLogo;
    }

    public function setEntrepriseSiteWeb(?string $entrepriseSiteWeb): void
    {
        $this->entrepriseSiteWeb = $entrepriseSiteWeb;
    }

    public function setEntrepriseStatut(string $entrepriseStatut): void
    {
        $this->entrepriseStatut = $entrepriseStatut;
    }

    public function setIdRecruteur(int $idRecruteur): void
    {
        $this->idRecruteur = $idRecruteur;
    }

    public function setRecruteurEmail(string $recruteurEmail): void
    {
        $this->recruteurEmail = $recruteurEmail;
    }

    // ------------------------------------------------------------
    // CONVERSION : ligne SQL (tableau) -> objet
    // ------------------------------------------------------------

    public static function fromArray(array $row): self
    {
        $offre = new self();

        $offre->setId((int) ($row['id_offre'] ?? 0));
        $offre->setTitre((string) ($row['titre'] ?? ''));
        $offre->setTypeOffre((string) ($row['type_offre'] ?? 'stage'));
        $offre->setDescription(isset($row['description']) ? (string) $row['description'] : null);
        $offre->setVille(isset($row['ville']) ? (string) $row['ville'] : null);
        $offre->setSalaire(isset($row['salaire']) ? (float) $row['salaire'] : null);
        $offre->setAccessible(!empty($row['accessible']));
        $offre->setDatePublication((string) ($row['date_publication'] ?? ''));
        $offre->setDateLimite(isset($row['date_limite']) ? (string) $row['date_limite'] : null);
        $offre->setIdEntreprise((int) ($row['id_entreprise'] ?? 0));
        $offre->setEntreprise((string) ($row['entreprise'] ?? ''));
        $offre->setEntrepriseSecteur(isset($row['entreprise_secteur']) ? (string) $row['entreprise_secteur'] : null);
        $offre->setEntrepriseVille(isset($row['entreprise_ville']) ? (string) $row['entreprise_ville'] : null);
        $offre->setEntrepriseSiteWeb(isset($row['entreprise_site_web']) ? (string) $row['entreprise_site_web'] : null);
        $offre->setEntrepriseLogo(!empty($row['entreprise_logo']) ? (string) $row['entreprise_logo'] : null);
        $offre->setEntrepriseStatut((string) ($row['entreprise_statut'] ?? ''));
        $offre->setIdRecruteur((int) ($row['id_recruteur'] ?? 0));
        $offre->setRecruteurEmail((string) ($row['recruteur_email'] ?? ''));

        return $offre;
    }
}
