<?php
namespace App\Repository;

use App\Core\App;
use App\Entity\Users;
use App\Entity\NumeroTelephone;
use App\Core\Abstract\AbstractRepository;

class NumeroTelephoneRepository extends AbstractRepository 
{
      private string $table = 'numerotelephone';
      private CompteRepository $compteRepository;
      private UserRepository $userRepository;

      private static NumeroTelephoneRepository|null $instance = null ;

      public static function getInstance() 
      {
        if(self::$instance ===null)
        {
            self::$instance = new static();
        }
        return self::$instance ;
      }

  public function __construct ()
  {
    parent::__construct ();
        $this->compteRepository = App::getDependencies('CompteRepository');
        $this->userRepository = App::getDependencies('UserRepository');     
  }

 public function insertTransaction( $user, string $telephone)
 {
    $this->DB->beginTransaction();
    try 
    {
        //recuperation des id de user et compte
        $user_id= $this->userRepository->insert($user);
        $compte_id=  $this->compteRepository->inserCompte();

        $stmt=$this->DB->prepare("INSERT INTO $this->table (telephone, user_id, compte_id) 
                                                            VALUES(:telephone, :user_id , :compte_id)");
        $stmt->execute(
          [
          'telephone' => $telephone,
          'user_id' => $user_id,
          'compte_id' => $compte_id
        ]);
        $this->DB->commit();
        return true;
    } 
    catch (\PDOException $e) 
    {
      $this->DB->rollBack();
      throw new \Exception("Erreur lors de l'inscription :" .$e->getMessage());
    } 
 }

 public function insertSecondaire(int $user_id, float $solde, string $telephone)
 {
    $this->DB->beginTransaction();
    try 
    {
        //recuperation des id de user et compte
        $compte_id=  $this->compteRepository->insertSecondaire($solde);

        $stmt=$this->DB->prepare("INSERT INTO $this->table (telephone, user_id, compte_id) 
                                                          VALUES(:telephone, :user_id , :compte_id)");
        $stmt->execute(
          [
          'telephone' => $telephone,
          'user_id' => $user_id,
          'compte_id' => $compte_id
        ]);
        $this->DB->commit();
        return true;
    } 
    catch (\PDOException $e) 
    {
      $this->DB->rollBack();
      throw new \Exception("Erreur lors de l'inscription :" .$e->getMessage());
    } 
 }

      public function findByNumero($telephone): ?array {
        $query = "SELECT nt.*, c.*, u.nom, u.prenom FROM {$this->table} nt
                  JOIN compte c ON nt.compte_id = c.id
                  JOIN users u ON nt.user_id = u.id
                  WHERE nt.telephone = :telephone";
        $stmt = $this->DB->prepare($query);
        $stmt->execute(['telephone' => $telephone]);
        return $stmt->fetch() ?: null;
    }

    // public function findByUserId($userId): array {
    //     $query = "SELECT nt.*, c.numero as numero_compte, c.typecompte, c.solde, c.date
    //               FROM {$this->table} nt
    //               JOIN comptes c ON nt.compte_id = c.id
    //               WHERE nt.user_id = :id_user
    //               ORDER BY c.typecompte DESC, c.date ASC";
    //     $stmt = $this->DB>prepare($query);
    //     $stmt->execute(['id_user' => $userId]);
    //     return $stmt->fetchAll();
    // }

//     public function findUserIdByCompteId($compteId): int {
//     $query = "SELECT user_id FROM numeroTelephone WHERE compte_id = :compte_id";
//     $stmt = $this->DB->prepare($query);
//     $stmt->execute(['compte_id' => $compteId]);
//     $result = $stmt->fetch();
//     return $result ? $result['user_id'] : 0;
// }

//     public function findByCompteId($compteId): ?array {
//         $query = "SELECT * FROM {$this->table} WHERE compte_id = :id_compte";
//         $stmt = $this->DB->prepare($query);
//         $stmt->execute(['id_compte' => $compteId]);
//         return $stmt->fetch() ?: null;
//     }
 function selectAll(){}
 function update(){}
 function delete (){}
 function insert(array $array){}
 function selectById($id){}
function selectBy(array $filter) {}
}