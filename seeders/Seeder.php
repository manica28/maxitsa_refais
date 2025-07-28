<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = new PDO($_ENV['DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

// PROFILS
$pdo->exec("INSERT INTO profil (libelle) VALUES 
    ('client'),
    ('commercial')
    
");

// USERS
$pdo->exec("INSERT INTO users (nom, prenom, login, password, adresse, numerocni, photorecto, photoverso, profil_id) VALUES 
    ('Mbaye', 'Nianga', 'mbaye28', 'passer', 'Dakar', '1234567890123', 'recto.png', 'verso.png', 1),
    ('Sow', 'Fatou', 'client1', 'passer', 'Thies', '2345678901234', 'recto.png', 'verso.png', 1),
    ('Diallo', 'Ousmane', 'client2', 'passer', 'Kaolack', '3456789012345', 'recto.png', 'verso.png', 1)
");

// COMPTES
$pdo->exec("INSERT INTO comptes (solde, numero, datecreation, typecompte) VALUES 
    (50000, 'CPT001', '2025-01-01', 'courant'),
    (100000, 'CPT002', '2025-01-02', 'epargne')
");

// NUMEROS
$pdo->exec("INSERT INTO numerotelephone (telephone, user_id, compte_id) VALUES 
    ('770000001', 2, 1),
    ('770000002', 3, 2)
");

// TRANSACTIONS (13 transactions)
$pdo->exec("
    INSERT INTO transactions (date, montant, typetransaction, compte_id) VALUES
    ('2025-07-01 08:00:00', 10000, 'depot', 1),
    ('2025-07-01 10:00:00', 5000, 'retrait', 1),
    ('2025-07-02 09:30:00', 15000, 'virement', 1),
    ('2025-07-02 14:00:00', 2000, 'depot', 2),
    ('2025-07-03 11:15:00', 10000, 'retrait', 2),
    ('2025-07-04 16:00:00', 2500, 'depot', 1),
    ('2025-07-05 09:00:00', 3000, 'retrait', 1),
    ('2025-07-06 13:00:00', 8000, 'virement', 2),
    ('2025-07-07 10:45:00', 12000, 'depot', 2),
    ('2025-07-08 12:30:00', 4000, 'retrait', 1),
    ('2025-07-09 15:00:00', 7000, 'virement', 2),
    ('2025-07-10 17:30:00', 9000, 'depot', 1),
    ('2025-07-11 19:00:00', 1000, 'retrait', 2)
");

echo "✅ Données insérées avec succès.\n";
