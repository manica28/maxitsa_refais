<?php

namespace App\Repository;
use App\Core\Abstract\AbstractRepository;
use App\Entity\Transaction;
class TransactionRepository extends AbstractRepository 
{
        private string $table = 'transactions';
        private static TransactionRepository|null $instance = null ;
        public static function getInstance() 
        {
          if(self::$instance ===null)
          {
              self::$instance = new static();
          }
          return self::$instance ;
        }

      public function __construct() {parent::__construct ();}  
      function selectAll(){}
      function update(){}
      function delete (){}
      function insert(array $array){}
      function selectById($id){}
      function selectBy(array $filter) {}

      // pour obtenir les information de l'utilisateur connecté: solde , tel, etc...
      public function  getTransactions ($user_id):array|null
      {
          $sql="SELECT * from compte c join numerotelephone n on c.id = n.compte_id join users cl on n.user_id = cl.id  join transactions t on t.compte_id=c.id where c.typecompte='principal' and cl.id= :user_id limit 10";
          $stmt = $this->DB->prepare($sql);
          $stmt->execute(
                      [
                        'user_id' => $user_id
                      ]
                );
         $result = $stmt->fetchAll();
        return $result ?: null;
              // var_dump($result); pour verifier si les données sont recuperer
      }
}
// public function countTransactionsByCompteId(int $user_id): int
// {
//     $query = "SELECT COUNT(*) FROM transactions WHERE user_id = :user_id";
//     $stmt = $this->DB->prepare($query);
//     $stmt->execute(['user_id' => $user_id]);
//     return (int) $stmt->fetchColumn();
// }
//     public function getTransactionsByCompteId(int $userId, int $limit = null): array
// {
//     $query = "SELECT * FROM transactions WHERE user_id = :user_id ORDER BY datetransaction DESC";
//     if ($limit) {
//         $query .= " LIMIT :limit";
//     }
    
//     $stmt = $this->DB->prepare($query);
//     $stmt->bindValue('user_id', $userId);
    
//     if ($limit) {
//         $stmt->bindValue('limit', $limit );
//     }
    
//     $stmt->execute();
//     return $stmt->fetchAll();
