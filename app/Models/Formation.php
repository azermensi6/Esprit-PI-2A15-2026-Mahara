<?php

namespace App\Models;

/**
 * Modèle (entité) : une formation de la table « formation » (module P5).
 * L'attribut categorie (nom de la catégorie) vient de la jointure avec categorie_formation.
 */
class Formation
{
    // ------------------------------------------------------------
    // ATTRIBUTS
    // ------------------------------------------------------------

    private int $id = 0;
    private string $titre = '';
    private ?string $description = null;
    private string $niveau = 'debutant';   // debutant, intermediaire ou avance
    private int $dureeHeures = 0;
    private string $mode = 'en_ligne';   // en_ligne, presentiel ou hybride
    private float $prix = 0;   // en dinars (TND), 0 = gratuite
    private ?string $dateDebut = null;
    private string $dateCreation = '';
    private int $idCategorieFormation = 0;   // clé étrangère
    private string $categorie = '';   // jointure : nom de la catégorie

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getNiveau(): string
    {
        return $this->niveau;
    }

    public function getDureeHeures(): int
    {
        return $this->dureeHeures;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function getDateDebut(): ?string
    {
        return $this->dateDebut;
    }

    public function getDateCreation(): string
    {
        return $this->dateCreation;
    }

    public function getIdCategorieFormation(): int
    {
        return $this->idCategorieFormation;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
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

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setNiveau(string $niveau): void
    {
        $this->niveau = $niveau;
    }

    public function setDureeHeures(int $dureeHeures): void
    {
        $this->dureeHeures = $dureeHeures;
    }

    public function setMode(string $mode): void
    {
        $this->mode = $mode;
    }

    public function setPrix(float $prix): void
    {
        $this->prix = $prix;
    }

    public function setDateDebut(?string $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function setDateCreation(string $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public function setIdCategorieFormation(int $idCategorieFormation): void
    {
        $this->idCategorieFormation = $idCategorieFormation;
    }

    public function setCategorie(string $categorie): void
    {
        $this->categorie = $categorie;
    }

    // ------------------------------------------------------------
    // CONVERSION : ligne SQL (tableau) -> objet
    // ------------------------------------------------------------

    public static function fromArray(array $row): self
    {
        $formation = new self();

        $formation->setId((int) ($row['id_formation'] ?? 0));
        $formation->setTitre((string) ($row['titre'] ?? ''));
        $formation->setDescription(isset($row['description']) ? (string) $row['description'] : null);
        $formation->setNiveau((string) ($row['niveau'] ?? 'debutant'));
        $formation->setDureeHeures((int) ($row['duree_heures'] ?? 0));
        $formation->setMode((string) ($row['mode'] ?? 'en_ligne'));
        $formation->setPrix((float) ($row['prix'] ?? 0));
        $formation->setDateDebut(isset($row['date_debut']) ? (string) $row['date_debut'] : null);
        $formation->setDateCreation((string) ($row['date_creation'] ?? ''));
        $formation->setIdCategorieFormation((int) ($row['id_categorie_formation'] ?? 0));
        $formation->setCategorie((string) ($row['categorie'] ?? ''));

        return $formation;
    }
}
