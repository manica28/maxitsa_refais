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


 function selectAll(){}
 function update(){}
 function delete (){}
 function insert(array $array){}
 function selectById($id){}
function selectBy(array $filter) {}
}