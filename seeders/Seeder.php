<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class Seeder
{
    private static ?\PDO $pdo = null;

    private static function connect()
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO(
                $_ENV['DSN'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD']
            );
        }
    }

    public static function run()
    {
        self::connect();

        // 🧹 Nettoyage des tables (⚠ à activer uniquement en développement)
        self::$pdo->exec("DELETE FROM numerotelephone;");
        self::$pdo->exec("DELETE FROM transactions;");
        self::$pdo->exec("DELETE FROM users;");
        self::$pdo->exec("DELETE FROM compte;");
        self::$pdo->exec("DELETE FROM profil;");

        // 🔁 Réinitialisation des séquences auto-incrémentées
        self::$pdo->exec("ALTER SEQUENCE profil_id_seq RESTART WITH 1;");
        self::$pdo->exec("ALTER SEQUENCE compte_id_seq RESTART WITH 1;");
        self::$pdo->exec("ALTER SEQUENCE users_id_seq RESTART WITH 1;");
        self::$pdo->exec("ALTER SEQUENCE transactions_id_seq RESTART WITH 1;");
        self::$pdo->exec("ALTER SEQUENCE numerotelephone_id_seq RESTART WITH 1;");

        // ✅ Insertion des données
        // Profils
        self::$pdo->exec("INSERT INTO profil (libelle) VALUES 
            ('client'),
            ('commercial');");

        // Compte
        self::$pdo->exec("INSERT INTO compte (solde, numero, datecreation, typecompte) VALUES 
            (200000.00, 'CPT28', '2002-02-28', 'principal');");

        // Utilisateur
        self::$pdo->exec("INSERT INTO users (nom, prenom, login, password, adresse, numerocni, photorecto, photoverso, profil_id) 
            VALUES ('Amina', 'Diouf', 'aminata', 'amina1234', 'mariste', '1234567899', NULL, NULL, 1);");

        // Transaction
        self::$pdo->exec("INSERT INTO transactions (date, montant, typetransaction, compte_id) 
            VALUES ('2025-07-16 08:30:00', 100000.00, 'depot', 1);");

        // Numéro de téléphone
        self::$pdo->exec("INSERT INTO numerotelephone (telephone, user_id, compte_id) 
            VALUES ('771122334', 1, 1);");

        echo "✅ Les données de test ont été insérées avec succès.\n";
    }
}

Seeder::run();
