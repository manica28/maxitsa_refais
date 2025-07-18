<?php
namespace App\Repository;
use PDO;

use App\Entity\Users;

use App\Enums\TypeCompte;

use App\Core\Abstract\AbstractRepository;
use App\Entity\Compte;
use App\Entity\NumeroTelephone;
use DateTime;

class UserRepository extends AbstractRepository {

 private string $table = 'users';
 private static UserRepository|null $instance = null ;

 public static function getInstance() {
   if(self::$instance ===null){
   self::$instance = new static();
   }
   return self::$instance ;
}

 public function __construct (){
    parent::__construct ();
 }


 public function selectLoginPassword ($login , $password) : Users|null{

   $sql = "SELECT * FROM $this->table WHERE login = :login  and password = :password";
   $stmt = $this->DB->prepare($sql);
   $stmt->execute(
            [
               'login'    => $login ,
               'password' => $password
            ]
                 );
    $result = $stmt->fetch();
    return $result ? Users::toObject($result) : null ;

  /*   if ($result){
      return  Users::toObject($result);
    }
    return null ; 
*/
 } 
//  fonction qui gere l'inscription:
 public function inssertUser(Users $user, NumeroTelephone $tel)
{
   // on utilise une transaction car on insere sur plusieurs tableaux
   try 
   {
      $this->DB->beginTransaction();
      $stmt= $this->DB->prepare("INSERT INTO $this->table ( nom, prenom, login, password, adresse, numerocni, photorecto, photoverso, profil_id) 
                              VALUES ( :nom, :prenom, :login, :password, :adresse, :numerocni, :photorecto, :photoverso, :profil_id )");
      $stmt->execute(
            
   [
               'nom'  => $user->getNom() ,
               'prenom' => $user->getPrenom (),
               'login' => $user->getLogin() ,
               'password'=> $user->getPassword() ,
               'adresse' => $user->getAdresse(),
               'numerocni' => $user->getNumerocni(),
               'photorecto' => $user->getPhotorecto() ,
               'photoverso' => $user->getPhotoverso() ,
               'profil_id'=> $user->getProfil()->getId(),
            ]
                 );
      $userId = (int) $this->DB->lastInsertId();
      $user->setId($userId);

     

      // on inserer aussi dans la table numero telephone
      $stmt3= $this->DB->prepare("INSERT INTO numerotelephone (telephone, user_id, compte_id) VALUES (:telephone, :user_id, :compte_id)");
       $stmt3->execute(
[
         'telephone' =>$tel->getTelephone(),
         'user_id' => $userId,
         'compte_id' => $compteId ,
      ]);

   $this->DB->commit();
      
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

 