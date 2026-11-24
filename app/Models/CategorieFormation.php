<?php

namespace App\Models;

/**
 * Modèle (entité) : une catégorie de la table « categorie_formation » (module P5).
 * L'attribut nbFormations est calculé par la jointure avec formation.
 */
class CategorieFormation
{
    // ------------------------------------------------------------
    // ATTRIBUTS
    // ------------------------------------------------------------

    private int $id = 0;
    private string $nom = '';
    private ?string $description = null;
    private int $nbFormations = 0;   // calculé par la jointure avec formation

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getNbFormations(): int
    {
        return $this->nbFormations;
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

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setNbFormations(int $nbFormations): void
    {
        $this->nbFormations = $nbFormations;
    }

    // ------------------------------------------------------------
    // CONVERSION : ligne SQL (tableau) -> objet
    // ------------------------------------------------------------

    public static function fromArray(array $row): self
    {
        $categorieFormation = new self();

        $categorieFormation->setId((int) ($row['id_categorie_formation'] ?? 0));
        $categorieFormation->setNom((string) ($row['nom'] ?? ''));
        $categorieFormation->setDescription(isset($row['description']) ? (string) $row['description'] : null);
        $categorieFormation->setNbFormations((int) ($row['nb_formations'] ?? 0));

        return $categorieFormation;
    }
}
