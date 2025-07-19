<?php

require_once  __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Migration
{
    private static ?\PDO $pdo = null;

    private static function connect()
    {
        if (self::$pdo === null) {
            $dsn = $_ENV['DSN'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];
            self::$pdo = new \PDO($dsn, $user, $pass);
        }
    }

    public static function up()
    {
        self::connect();

        $queries = [

            // Type ENUM (à créer si pas déjà fait via une migration séparée)
            "DO $$
             BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_compte') THEN
                    CREATE TYPE type_compte AS ENUM ('courant', 'epargne');
                END IF;
             END$$;",

            "DO $$
             BEGIN
                IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'type_transaction') THEN
                    CREATE TYPE type_transaction AS ENUM ('depot', 'retrait', 'virement');
                END IF;
             END$$;",

            // Tables
            "CREATE TABLE IF NOT EXISTS comptes (
                id SERIAL PRIMARY KEY,
                solde NUMERIC(15,2) NOT NULL DEFAULT 0.00,
                numero VARCHAR(50),
                datecreation DATE NOT NULL,
                typecompte type_compte NOT NULL
            );",

            "CREATE TABLE IF NOT EXISTS profil (
                id SERIAL PRIMARY KEY,
                libelle VARCHAR(100) NOT NULL
            );",

            "CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                login VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                adresse TEXT,
                numerocni VARCHAR(20),
                photorecto TEXT,
                photoverso TEXT,
                profil_id INTEGER NOT NULL,
                FOREIGN KEY (profil_id) REFERENCES profil(id)
            );",

            "CREATE TABLE IF NOT EXISTS numerotelephone (
                id SERIAL PRIMARY KEY,
                telephone VARCHAR(20) NOT NULL,
                user_id INTEGER NOT NULL,
                compte_id INTEGER NOT NULL,
                FOREIGN KEY (compte_id) REFERENCES comptes(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );",

            "CREATE TABLE IF NOT EXISTS transactions (
                id SERIAL PRIMARY KEY,
                date TIMESTAMP NOT NULL,
                montant NUMERIC(15,2) NOT NULL,
                typetransaction type_transaction NOT NULL,
                compte_id INTEGER NOT NULL,
                FOREIGN KEY (compte_id) REFERENCES comptes(id) ON DELETE CASCADE
            );"
        ];

        foreach ($queries as $sql) {
            self::$pdo->exec($sql);
        }

        echo "✅ Migration terminée avec succès.\n";
    }
}

Migration::up();
