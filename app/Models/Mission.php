<?php

namespace App\Models;

/**
 * Exemple de modèle (module P2) : la classe Mission et sa jointure avec Categorie.
 * Pas encore utilisé par les pages : servira à l'étape CRUD.
 */
class Mission extends Model
{
    /** Missions avec le nom de leur catégorie (jointure mission -> categorie) */
    public static function allWithCategorie(): array
    {
        $sql = 'SELECT m.*, c.nom AS categorie
                FROM mission m
                JOIN categorie c ON m.id_categorie = c.id_categorie
                ORDER BY m.date_publication DESC';
        return self::db()->query($sql)->fetchAll();
    }
}
