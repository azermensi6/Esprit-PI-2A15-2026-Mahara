<?php

namespace App\Models;

use PDO;

/**
 * Modèle de base : connexion unique à la base « mahara » (PDO).
 * Paramètres par défaut de XAMPP / WAMP : utilisateur root, sans mot de passe.
 */
abstract class Model
{
    private static ?PDO $pdo = null;

    protected static function db(): PDO
    {
        if (self::$pdo === null) {
            self::$pdo = new PDO(
                'mysql:host=localhost;dbname=mahara;charset=utf8mb4',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        }
        return self::$pdo;
    }
}
