<?php

namespace App\Models;

/**
 * Table commune « utilisateur » : inscription et connexion.
 */
class Utilisateur extends Model
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = self::db()->prepare('SELECT * FROM utilisateur WHERE email = ?');
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    /** Crée un compte (mot de passe haché) et renvoie son id */
    public static function create(array $data): int
    {
        $stmt = self::db()->prepare(
            'INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, telephone, role)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $data['nom'],
            $data['prenom'],
            $data['email'],
            password_hash($data['mot_de_passe'], PASSWORD_DEFAULT),
            $data['telephone'] !== '' ? $data['telephone'] : null,
            $data['role'],
        ]);
        return (int) self::db()->lastInsertId();
    }
}
