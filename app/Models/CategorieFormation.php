<?php

namespace App\Models;

/**
 * Modèle (module P5) : table categorie_formation.
 * CRUD complet en PDO, avec des requêtes préparées.
 */
class CategorieFormation extends Model
{
    /** READ : toutes les catégories, triées par nom */
    public static function all(): array
    {
        $sql = 'SELECT * FROM categorie_formation ORDER BY nom';
        return self::db()->query($sql)->fetchAll();
    }

    /** READ + LEFT JOIN : catégories avec le nombre de formations de chacune */
    public static function allWithCount(): array
    {
        $sql = 'SELECT c.*, COUNT(f.id_formation) AS nb_formations
                FROM categorie_formation c
                LEFT JOIN formation f
                  ON f.id_categorie_formation = c.id_categorie_formation
                GROUP BY c.id_categorie_formation
                ORDER BY c.nom';
        return self::db()->query($sql)->fetchAll();
    }

    /** READ : une catégorie par son id (false si elle n'existe pas) */
    public static function find(int $id): array|false
    {
        $stmt = self::db()->prepare(
            'SELECT * FROM categorie_formation WHERE id_categorie_formation = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /** CREATE : ajoute une catégorie et renvoie son nouvel id */
    public static function create(string $nom, ?string $description): int
    {
        $stmt = self::db()->prepare(
            'INSERT INTO categorie_formation (nom, description) VALUES (:nom, :description)'
        );
        $stmt->execute(['nom' => $nom, 'description' => $description]);
        return (int) self::db()->lastInsertId();
    }

    /** UPDATE : modifie une catégorie */
    public static function update(int $id, string $nom, ?string $description): bool
    {
        $stmt = self::db()->prepare(
            'UPDATE categorie_formation
             SET nom = :nom, description = :description
             WHERE id_categorie_formation = :id'
        );
        return $stmt->execute(['nom' => $nom, 'description' => $description, 'id' => $id]);
    }

    /** DELETE : supprime une catégorie */
    public static function delete(int $id): bool
    {
        $stmt = self::db()->prepare(
            'DELETE FROM categorie_formation WHERE id_categorie_formation = :id'
        );
        return $stmt->execute(['id' => $id]);
    }

    /** Règle métier : le nom est-il déjà pris ? (on ignore la catégorie $exceptId en modification) */
    public static function nomExiste(string $nom, int $exceptId = 0): bool
    {
        $stmt = self::db()->prepare(
            'SELECT COUNT(*) FROM categorie_formation
             WHERE nom = :nom AND id_categorie_formation <> :id'
        );
        $stmt->execute(['nom' => $nom, 'id' => $exceptId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /** Règle métier : combien de formations dépendent de cette catégorie ? */
    public static function countFormations(int $id): int
    {
        $stmt = self::db()->prepare(
            'SELECT COUNT(*) FROM formation WHERE id_categorie_formation = :id'
        );
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn();
    }
}
