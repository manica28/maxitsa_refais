<?php

namespace App\Repository;

use PDO;

use App\Entity\Users;

use App\Enums\TypeCompte;

use App\Core\Abstract\AbstractRepository;
use App\Entity\Compte;
use App\Entity\NumeroTelephone;
use DateTime;

class UserRepository extends AbstractRepository
{

   private string $table = 'users';
   private static UserRepository|null $instance = null;

   public static function getInstance()
   {
      if (self::$instance === null) {
         self::$instance = new static();
      }
      return self::$instance;
   }

   public function __construct()
   {
      parent::__construct();
   }


   public function selectLoginPassword($login, $password): Users|null
   {

      $sql = "SELECT * FROM $this->table WHERE login = :login  and password = :password";
      $stmt = $this->DB->prepare($sql);
      $stmt->execute(
         [
            'login'    => $login,
            'password' => $password
         ]
      );
      $result = $stmt->fetch();
      return $result ? Users::toObject($result) : null;
   }
   //  fonction qui gere l'inscription:
   public function insert(array $user)
   {
      // on utilise une transaction car on insere sur plusieurs tableaux
      $stmt = $this->DB->prepare("INSERT INTO $this->table ( nom, prenom, login, password, adresse, numerocni, photorecto, photoverso, profil_id) 
                                    VALUES ( :nom, :prenom, :login, :password, :adresse, :numerocni, :photorecto, :photoverso, :profil_id )");
      $resultat = $stmt->execute(
         $user
         // 'nom'  => $user->getNom() ,
         // 'prenom' => $user->getPrenom (),
         // 'login' => $user->getLogin() ,
         // 'password'=> $user->getPassword() ,
         // 'adresse' => $user->getAdresse(),
         // 'numerocni' => $user->getNumerocni(),
         // 'photorecto' => $user->getPhotorecto() ,
         // 'photoverso' => $user->getPhotoverso() ,
         // 'profil_id'=> $user->getProfil()->getId(),
      );
      if ($resultat) 
      {
         return (int) $this->DB->lastInsertId();
      }
      return null;
   }
   public function selectById($id){
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->DB->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
     }
   function selectAll() {}
   function update() {}
   function delete() {}
   function selectBy(array $filter) {}
}

