<?php
namespace App\Repository;

use App\Entity\Compte;
use App\Enums\TypeCompte;
use App\Core\Abstract\AbstractRepository;

class CompteRepository extends AbstractRepository 
{
    private string $table = 'compte';
    private static CompteRepository|null $instance = null;
    
    public static function getInstance() 
    {
        if(self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __construct() {
        parent::__construct();
    }  
    
    function selectAll(){}
    function update(){}
    function delete(){}
    function insert(array $array){}

    public function inserCompte()
    {
        $stmt2 = $this->DB->prepare("INSERT INTO $this->table (solde, numero, datecreation, typecompte) 
                                     VALUES(:solde, :numero, :datecreation, :typecompte)");
        $genernum = "COM-" . time();
        $resultat = $stmt2->execute([
            'solde' => 0,
            'numero' => $genernum,
            'datecreation' => date("Y-m-d"),
            'typecompte' => TypeCompte::PRINCIPAL->value,
        ]);
        
        if($resultat) {
            return (int) $this->DB->lastInsertId();
        }
        return false;
    }

    public function insertSecondaire($solde)
    {
        $stmt2 = $this->DB->prepare("INSERT INTO $this->table (solde, numero, datecreation, typecompte) 
                                     VALUES(:solde, :numero, :datecreation, :typecompte)");
        $genernum = "COM-" . time() . "-" . rand(100, 999); // Éviter les doublons
        
        $resultat = $stmt2->execute([
            'solde' => $solde,
            'numero' => $genernum, 
            'datecreation' => date("Y-m-d"),
            'typecompte' => TypeCompte::SECONDAIRE->value,
        ]);
        
        if($resultat) {
            return (int) $this->DB->lastInsertId();
        }
        return false;
    }

    function selectById($id){}
    function selectBy(array $filter) {}

    // Pour obtenir les informations de l'utilisateur connecté: solde, tel, etc...
    public function getCompteClient($user_id): array|null
    {
        $sql = "SELECT * FROM compte c 
                JOIN numerotelephone n ON c.id = n.compte_id 
                JOIN users cl ON n.user_id = cl.id  
                WHERE c.typecompte='principal' AND cl.id = :user_id";
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findPrincipalByUserId($userId): ?array 
    {
        $sql = "SELECT *, compte.numero as numerocompte, nt.telephone as telephone 
                FROM $this->table 
                JOIN numerotelephone nt ON nt.compte_id = compte.id 
                JOIN users u ON nt.user_id = u.id 
                WHERE compte.id IN (
                    SELECT compte_id FROM numerotelephone WHERE user_id = :user_id
                ) AND compte.typecompte = 'principal'";
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    // Nouvelle méthode pour récupérer les comptes secondaires d'un utilisateur
    public function getComptesSecondaires($userId): array
    {
        $sql = "SELECT c.*, c.numero as numerocompte, nt.telephone as telephone 
                FROM $this->table c
                JOIN numerotelephone nt ON nt.compte_id = c.id 
                JOIN users u ON nt.user_id = u.id 
                WHERE c.typecompte = 'secondaire' AND u.id = :user_id 
                ORDER BY c.datecreation DESC";
        
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll() ?: [];
    }

    // Méthode pour vérifier si un utilisateur peut créer un compte secondaire
    public function canCreateSecondaire($userId): bool
    {
        // Vérifier qu'il a un compte principal
        $principal = $this->findPrincipalByUserId($userId);
        if (!$principal) {
            return false;
        }

        // Optionnel: limiter le nombre de comptes secondaires
        $sql = "SELECT COUNT(*) as count FROM $this->table c
                JOIN numerotelephone nt ON nt.compte_id = c.id
                WHERE nt.user_id = :user_id AND c.typecompte = 'secondaire'";
        
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetch();
        
        // Limiter à 5 comptes secondaires par exemple
        return $result['count'] < 5;
    }
}