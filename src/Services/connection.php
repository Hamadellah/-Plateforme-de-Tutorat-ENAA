<?php

namespace Services;

use PDO;
use PDOException;

class Connection
{
    private static $pdo = null;

    public static function getConnection()
    {
        if(self::$pdo === null){

            $envPath = __DIR__ . '/../../.env';

            if (!file_exists($envPath)) {
                die("Erreur : Le fichier .env est introuvable dans : " . $envPath);
            }

            $env = parse_ini_file($envPath);

            
            $host = $env['DB_HOST'] ?? 'localhost';
            $dbname = $env['DB_NAME'] ?? '';
            $user = $env['DB_USER'] ?? 'root';
            $password = $env['DB_PASS'] ?? $env['DB_PASSWORD'] ?? ''; // kiy-9leb 3lihom bjoj

            try {
                self::$pdo = new PDO(
                    "mysql:host=$host;dbname=$dbname;charset=utf8",
                    $user,
                    $password
                );

                self::$pdo->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
                

            } catch(PDOException $e) {
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
                die("Connection failed : " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}