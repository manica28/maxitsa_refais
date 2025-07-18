<?php
namespace App\Repository;

use App\Entity\Users;
use App\Entity\NumeroTelephone;
use App\Core\Abstract\AbstractRepository;

class NumeroTelephoneRepository extends AbstractRepository 
{

 private string $table = 'numerotelephone';

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
  }

 public function insertTransaction(Users $user, string $telephone)
 {
    try 
    {
        
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