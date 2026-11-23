<?php

namespace App\Models;

/**
 * Modèle (module P5) : table formation.
 * Jointure : formation.id_categorie_formation -> categorie_formation.
 */
class Formation extends Model
{
    /** READ + JOIN : toutes les formations avec le nom de leur catégorie */
    public static function allWithCategorie(): array
    {
        $sql = 'SELECT f.*, c.nom AS categorie
                FROM formation f
                JOIN categorie_formation c
                  ON f.id_categorie_formation = c.id_categorie_formation
                ORDER BY f.date_creation DESC';
        return self::db()->query($sql)->fetchAll();
    }

    /**
     * READ + JOIN (front office) : recherche par mot-clé et/ou par catégorie.
     * Les deux filtres sont facultatifs.
     */
    public static function search(string $motCle = '', int $idCategorie = 0): array
    {
        $sql = 'SELECT f.*, c.nom AS categorie
                FROM formation f
                JOIN categorie_formation c
                  ON f.id_categorie_formation = c.id_categorie_formation
                WHERE (f.titre LIKE :motCle OR f.description LIKE :motCle)
                  AND (:idCat = 0 OR f.id_categorie_formation = :idCat)
                ORDER BY f.date_creation DESC';
        $stmt = self::db()->prepare($sql);
        $stmt->execute(['motCle' => '%' . $motCle . '%', 'idCat' => $idCategorie]);
        return $stmt->fetchAll();
    }

    /** READ : une formation (avec sa catégorie) ; false si elle n'existe pas */
    public static function find(int $id): array|false
    {
        $stmt = self::db()->prepare(
            'SELECT f.*, c.nom AS categorie
             FROM formation f
             JOIN categorie_formation c
               ON f.id_categorie_formation = c.id_categorie_formation
             WHERE f.id_formation = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /** CREATE : $data contient les champs du formulaire ; renvoie le nouvel id */
    public static function create(array $data): int
    {
        $stmt = self::db()->prepare(
            'INSERT INTO formation
                (titre, description, niveau, duree_heures, mode, prix, date_debut, id_categorie_formation)
             VALUES
                (:titre, :description, :niveau, :duree_heures, :mode, :prix, :date_debut, :id_categorie_formation)'
        );
        $stmt->execute(self::params($data));
        return (int) self::db()->lastInsertId();
    }

    /** UPDATE */
    public static function update(int $id, array $data): bool
    {
        $stmt = self::db()->prepare(
            'UPDATE formation
             SET titre = :titre, description = :description, niveau = :niveau,
                 duree_heures = :duree_heures, mode = :mode, prix = :prix,
                 date_debut = :date_debut, id_categorie_formation = :id_categorie_formation
             WHERE id_formation = :id'
        );
        return $stmt->execute(self::params($data) + ['id' => $id]);
    }

    /** DELETE */
    public static function delete(int $id): bool
    {
        $stmt = self::db()->prepare('DELETE FROM formation WHERE id_formation = :id');
        return $stmt->execute(['id' => $id]);
    }

    /** Règle métier : ce titre existe-t-il déjà dans cette catégorie ? */
    public static function titreExiste(string $titre, int $idCategorie, int $exceptId = 0): bool
    {
        $stmt = self::db()->prepare(
            'SELECT COUNT(*) FROM formation
             WHERE titre = :titre
               AND id_categorie_formation = :idCat
               AND id_formation <> :id'
        );
        $stmt->execute(['titre' => $titre, 'idCat' => $idCategorie, 'id' => $exceptId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /** Prépare les paramètres communs à create() et update() */
    private static function params(array $data): array
    {
        return [
            'titre'                  => $data['titre'],
            'description'            => $data['description'] ?? null,
            'niveau'                 => $data['niveau'],
            'duree_heures'           => (int) $data['duree_heures'],
            'mode'                   => $data['mode'],
            'prix'                   => $data['prix'],
            'date_debut'             => ($data['date_debut'] ?? '') !== '' ? $data['date_debut'] : null,
            'id_categorie_formation' => (int) $data['id_categorie_formation'],
        ];
    }
}
