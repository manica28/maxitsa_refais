<?php

namespace App\Repository;
use App\Core\Abstract\AbstractRepository;
use App\Entity\Transaction;

class TransactionRepository extends AbstractRepository 
{
    private string $table = 'transactions';
    private static TransactionRepository|null $instance = null;
    
    public static function getInstance() 
    {
        if(self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __construct() 
    {
        parent::__construct();
    }  

    function selectAll() {}
    function update() {}
    function delete() {}
    function insert(array $array) {}
    function selectById($id) {}
    function selectBy(array $filter) {}

    // Méthode originale pour obtenir les transactions de l'utilisateur connecté
    public function getTransactions($user_id): array|null
    {
        $sql = "SELECT t.*, c.solde, cl.prenom, cl.nom 
                FROM compte c 
                JOIN numerotelephone n ON c.id = n.compte_id 
                JOIN users cl ON n.user_id = cl.id  
                JOIN transactions t ON t.compte_id = c.id 
                WHERE c.typecompte = 'principal' AND cl.id = :user_id 
                ORDER BY t.date DESC 
                LIMIT 10";
                
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $result = $stmt->fetchAll();
        
        return $result ?: null;
    }

    // Méthode pour obtenir les transactions avec filtres
    public function getTransactionsWithFilters($user_id, $filters): array
    {
        $sql = "SELECT t.*, c.solde, cl.prenom, cl.nom,
                       t.date as date,
                       t.typetransaction,
                       t.montant
                FROM compte c 
                JOIN numerotelephone n ON c.id = n.compte_id 
                JOIN users cl ON n.user_id = cl.id  
                JOIN transactions t ON t.compte_id = c.id 
                WHERE c.typecompte = 'principal' AND cl.id = :user_id";

        $params = ['user_id' => $user_id];

        // Appliquer les filtres
        if (!empty($filters['date_debut'])) {
            $sql .= " AND DATE(t.date) >= :date_debut";
            $params['date_debut'] = $filters['date_debut'];
        }

        if (!empty($filters['date_fin'])) {
            $sql .= " AND DATE(t.date) <= :date_fin";
            $params['date_fin'] = $filters['date_fin'];
        }

        if (!empty($filters['type'])) {
            $sql .= " AND t.typetransaction = :type";
            $params['type'] = $filters['type'];
        }

        $sql .= " ORDER BY t.date DESC";

        $stmt = $this->DB->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll() ?: [];
    }

    // Méthode pour compter les transactions d'un utilisateur
    public function countTransactionsByUserId(int $user_id): int
    {
        $sql = "SELECT COUNT(*) 
                FROM compte c 
                JOIN numerotelephone n ON c.id = n.compte_id 
                JOIN users cl ON n.user_id = cl.id  
                JOIN transactions t ON t.compte_id = c.id 
                WHERE c.typecompte = 'principal' AND cl.id = :user_id";
                
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        
        return (int) $stmt->fetchColumn();
    }

    // Méthode pour obtenir toutes les transactions d'un utilisateur avec pagination
    public function getAllTransactionsByUserId(int $user_id, int $limit = null, int $offset = 0): array
    {
        $sql = "SELECT t.*, c.solde, cl.prenom, cl.nom,
                       t.date as date,
                       t.typetransaction,
                       t.montant
                FROM compte c 
                JOIN numerotelephone n ON c.id = n.compte_id 
                JOIN users cl ON n.user_id = cl.id  
                JOIN transactions t ON t.compte_id = c.id 
                WHERE c.typecompte = 'principal' AND cl.id = :user_id
                ORDER BY t.date DESC";
                
        if ($limit) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->DB->prepare($sql);
        $stmt->bindValue('user_id', $user_id);
        
        if ($limit) {
            $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
            $stmt->bindValue('offset', $offset, \PDO::PARAM_INT);
        }
        
        $stmt->execute();
        
        return $stmt->fetchAll() ?: [];
    }
}