<?php

namespace App\Models;

/**
 * Modèle (entité) : une entreprise de la table « entreprise » (module P3 · Recrutement).
 * Relation du MCD : Utilisateur (recruteur) 1 ---- N Entreprise  (« Gérer »)
 * Les attributs recruteur, recruteurEmail et nbOffres viennent des jointures.
 */
class Entreprise
{
    // ------------------------------------------------------------
    // ATTRIBUTS
    // ------------------------------------------------------------

    private int $id = 0;
    private string $nom = '';
    private ?string $secteur = null;
    private ?string $ville = null;
    private ?string $siteWeb = null;
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
        $entreprise->setStatut((string) ($row['statut'] ?? 'en_attente'));
        $entreprise->setIdRecruteur((int) ($row['id_recruteur'] ?? 0));
        $entreprise->setRecruteur((string) ($row['recruteur'] ?? ''));
        $entreprise->setRecruteurEmail((string) ($row['recruteur_email'] ?? ''));
        $entreprise->setNbOffres((int) ($row['nb_offres'] ?? 0));

        return $entreprise;
    }
}
