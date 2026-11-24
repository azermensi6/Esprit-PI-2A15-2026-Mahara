<?php

namespace App\Models;

/**
 * Modèle (entité) : une mission de la table « mission » (module P2).
 * L'attribut categorie (nom de la catégorie) vient de la jointure avec categorie.
 * Le SQL (ex : liste avec jointure) se met dans le contrôleur du module, jamais ici.
 */
class Mission
{
    // ------------------------------------------------------------
    // ATTRIBUTS
    // ------------------------------------------------------------

    private int $id = 0;
    private string $titre = '';
    private ?string $description = null;
    private float $budget = 0;   // en dinars (TND)
    private int $delaiJours = 0;
    private ?string $ville = null;
    private string $statut = 'ouverte';   // ouverte, en_cours, terminee ou annulee
    private string $datePublication = '';
    private int $idCategorie = 0;   // clé étrangère
    private int $idClient = 0;   // clé étrangère vers utilisateur
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

    public function getBudget(): float
    {
        return $this->budget;
    }

    public function getDelaiJours(): int
    {
        return $this->delaiJours;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getDatePublication(): string
    {
        return $this->datePublication;
    }

    public function getIdCategorie(): int
    {
        return $this->idCategorie;
    }

    public function getIdClient(): int
    {
        return $this->idClient;
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

    public function setBudget(float $budget): void
    {
        $this->budget = $budget;
    }

    public function setDelaiJours(int $delaiJours): void
    {
        $this->delaiJours = $delaiJours;
    }

    public function setVille(?string $ville): void
    {
        $this->ville = $ville;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }

    public function setDatePublication(string $datePublication): void
    {
        $this->datePublication = $datePublication;
    }

    public function setIdCategorie(int $idCategorie): void
    {
        $this->idCategorie = $idCategorie;
    }

    public function setIdClient(int $idClient): void
    {
        $this->idClient = $idClient;
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
        $mission = new self();

        $mission->setId((int) ($row['id_mission'] ?? 0));
        $mission->setTitre((string) ($row['titre'] ?? ''));
        $mission->setDescription(isset($row['description']) ? (string) $row['description'] : null);
        $mission->setBudget((float) ($row['budget'] ?? 0));
        $mission->setDelaiJours((int) ($row['delai_jours'] ?? 0));
        $mission->setVille(isset($row['ville']) ? (string) $row['ville'] : null);
        $mission->setStatut((string) ($row['statut'] ?? 'ouverte'));
        $mission->setDatePublication((string) ($row['date_publication'] ?? ''));
        $mission->setIdCategorie((int) ($row['id_categorie'] ?? 0));
        $mission->setIdClient((int) ($row['id_client'] ?? 0));
        $mission->setCategorie((string) ($row['categorie'] ?? ''));

        return $mission;
    }
}
