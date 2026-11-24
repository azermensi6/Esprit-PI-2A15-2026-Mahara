<?php
/**
 * config/database.php
 * Connexion PDO sécurisée à la base « mahara » (patron Singleton).
 * Une seule connexion est créée puis partagée par toute l'application.
 */

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnexion(): PDO
    {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO(
                    // --- À adapter à votre MySQL local (XAMPP / WAMP) ---
                    'mysql:host=localhost;dbname=mahara;charset=utf8mb4',
                    'root',
                    '',
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // erreur SQL = exception
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // lignes en tableaux associatifs
                        PDO::ATTR_EMULATE_PREPARES   => false,                  // vraies requêtes préparées (anti injection SQL)
                    ]
                );
            } catch (Exception $e) {
                // Message clair, sans afficher les paramètres de connexion
                http_response_code(500);
                die('Erreur : base de données indisponible. Démarrez MySQL dans XAMPP et importez database/mahara.sql.');
            }
        }
        return self::$pdo;
    }
}
