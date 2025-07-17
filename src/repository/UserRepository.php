<?php
namespace App\Repository;

use App\Core\Abstract\AbstractRepository;
use App\Entity\Users;

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
 function selectAll(){

 }
 function update(){

 }
 function delete (){

 }
 function insert(array $array){

 }

 function selectById($id){

 }

function selectBy(array $filter) {
    
}
}

 