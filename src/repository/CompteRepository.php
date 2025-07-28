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

    // insertion de données dans la table compte lors de l'inscription
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

    // ajout d'un compte secondaire
    public function insertSecondaire($solde)
    {
        $stmt2 = $this->DB->prepare("INSERT INTO $this->table (solde, numero, datecreation, typecompte) 
                                     VALUES(:solde, :numero, :datecreation, :typecompte)");
        $genernum = "COM-" . time() . "-" . rand(100, 999);
        
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
    
// fonction qui recupere le compte du client
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

    // public function getComptesSecondaires($userId): array
    // {
    //     $sql = "SELECT c.*, c.numero as numerocompte, nt.telephone as telephone 
    //             FROM $this->table c
    //             JOIN numerotelephone nt ON nt.compte_id = c.id 
    //             JOIN users u ON nt.user_id = u.id 
    //             WHERE c.typecompte = 'secondaire' AND u.id = :user_id 
    //             ORDER BY c.datecreation DESC";
        
    //     $stmt = $this->DB->prepare($sql);
    //     $stmt->execute(['user_id' => $userId]);
    //     return $stmt->fetchAll() ?: [];
    // }
/**
 * Récupère tous les comptes secondaires d'un utilisateur
 */
public function getComptesSecondaires($userId): array
{
    $sql = "SELECT c.*, c.numero as numerocompte, nt.telephone as telephone 
            FROM $this->table c
            JOIN numerotelephone nt ON nt.compte_id = c.id 
            JOIN users u ON nt.user_id = u.id 
            WHERE c.typecompte = 'secondaire' AND u.id = :user_id 
            ORDER BY c.datecreation DESC";
    
    $stmt = $this->DB->prepare($sql);
    $executeResult = $stmt->execute(['user_id' => $userId]);
    
    if (!$executeResult) {
        // En cas d'erreur, retourner un tableau vide
        return [];
    }
    
    return $stmt->fetchAll() ?: [];
}
    /**
     * Récupère un compte par son numéro de téléphone
     */
    public function getCompteByTelephone($telephone): array|null
    {
        $sql = "SELECT c.*, c.numero as numerocompte, nt.telephone as telephone 
                FROM $this->table c
                JOIN numerotelephone nt ON nt.compte_id = c.id 
                WHERE nt.telephone = :telephone 
                ORDER BY c.datecreation DESC
                LIMIT 1";
        
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['telephone' => $telephone]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Récupère un compte par son numéro de compte
     */
    public function getCompteByNumero($numero): array|null
    {
        $sql = "SELECT c.*, c.numero as numerocompte, nt.telephone as telephone,
                       u.nom, u.prenom 
                FROM $this->table c
                JOIN numerotelephone nt ON nt.compte_id = c.id 
                JOIN users u ON nt.user_id = u.id 
                WHERE c.numero = :numero";
        
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['numero' => $numero]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Récupère le dernier compte secondaire créé pour un utilisateur
     */
    public function getLatestCompteSecondaire($userId): array|null
    {
        $sql = "SELECT c.*, c.numero as numerocompte, nt.telephone as telephone 
                FROM $this->table c
                JOIN numerotelephone nt ON nt.compte_id = c.id 
                JOIN users u ON nt.user_id = u.id 
                WHERE c.typecompte = 'secondaire' AND u.id = :user_id 
                ORDER BY c.id DESC
                LIMIT 1";
        
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    /**
     * Récupère tous les comptes d'un utilisateur avec leurs détails
     */
    public function getAllUserComptesWithDetails($userId): array
    {
        $sql = "SELECT c.*, c.numero as numerocompte, nt.telephone as telephone,
                       CASE 
                           WHEN c.typecompte = 'principal' THEN 'Compte Principal'
                           ELSE 'Compte Secondaire'
                       END as type_libelle
                FROM $this->table c
                JOIN numerotelephone nt ON nt.compte_id = c.id 
                JOIN users u ON nt.user_id = u.id 
                WHERE u.id = :user_id 
                ORDER BY CASE WHEN c.typecompte = 'principal' THEN 0 ELSE 1 END, c.datecreation DESC";
        
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll() ?: [];
    }

    public function canCreateSecondaire($userId): bool
    {
        $principal = $this->findPrincipalByUserId($userId);
        if (!$principal) {
            return false;
        }

        $sql = "SELECT COUNT(*) as count FROM $this->table c
                JOIN numerotelephone nt ON nt.compte_id = c.id
                WHERE nt.user_id = :user_id AND c.typecompte = 'secondaire'";
        
        $stmt = $this->DB->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetch();
        
        return $result['count'] < 5;
    }
}