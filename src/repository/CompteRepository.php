<?php
namespace App\Repository ;

use App\Entity\Compte;
use App\Enums\TypeCompte;
use App\Core\Abstract\AbstractRepository;

class CompteRepository extends AbstractRepository 
{
        private string $table = 'compte';
        private static CompteRepository|null $instance = null ;
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

      public function inserCompte()
      {
        //on inserer aussi dans la table compte
         $stmt2= $this->DB->prepare("INSERT INTO $this->table (solde, numero, datecreation, typecompte) 
                                                          VALUES(:solde, :numero, :datecreation, :typecompte)");
        $genernum = "COM-" .time();
         $resultat=$stmt2->execute( 
        [  'solde' =>0,
                    'numero' => $genernum, //fonction qui genere les matricules
                    'datecreation' => date("Y-m-d"),
                    'typecompte' =>TypeCompte::PRINCIPAL->value,]
        );
        if($resultat)
        {
           return (int) $this->DB->lastInsertId();
        }
        return false;

      }

      public function insertSecondaire($solde){
        $stmt2= $this->DB->prepare("INSERT INTO $this->table (solde, numero, datecreation, typecompte) 
                                                          VALUES(:solde, :numero, :datecreation, :typecompte)");
        $genernum = "COM-" .time();
        
        $resultat=$stmt2->execute( 
        [  'solde' =>$solde,
                    'numero' => $genernum, 
                    'datecreation' => date("Y-m-d"),
                    'typecompte' =>TypeCompte::SECONDAIRE->value,
                ]
        );
        if($resultat)
        {
           return (int) $this->DB->lastInsertId();
        }
        return false;
      }

      function selectById($id){}
      function selectBy(array $filter) {}
      // pour obtenir les information de l'utilisateur connecté: solde , tel, etc...
      public function  getCompteClient ($user_id):array|null
      {
          $sql = "SELECT * from compte c join numerotelephone n on c.id = n.compte_id join users cl on n.user_id = cl.id  where c.typecompte='principal' and cl.id= :user_id";
          $stmt = $this->DB->prepare($sql);
          $stmt->execute(
                      [
                        'user_id' => $user_id
                      ]
                );
        $result=$stmt->fetch();
        return $result ?: null;
              // var_dump($result); pour verifier si les données sont recuperer
      }

    
      
}