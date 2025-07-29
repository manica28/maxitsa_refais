<?php

namespace App\Core;


use \PDO;
use \PDOException;

class Database{
    
    private $connection;
    private  static Database|null $instance = null;

      protected function __construct() {

          //         DSN=pgsql:host=dpg-d1v830ali9vc73besm10-a.oregon-postgres.render.com;port=5432;dbname=maxittsa
// DB_USER=postgres_z0d6_user
// DB_PASSWORD=HAjA4dvUdXRqSKNEp2uJCSnpWm6BeFsO
          $dsn='pgsql:host=dpg-d1v830ali9vc73besm10-a.oregon-postgres.render.com;port=5432;dbname=maxittsa';
          $user='postgres_z0d6_user';
          $password='HAjA4dvUdXRqSKNEp2uJCSnpWm6BeFsO';
        

        try {
           
            $this->connection = new PDO($dsn, $user, $password
             
              [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
              ]
              );
 
        }catch(PDOException $e){
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection():PDO{
        return $this->connection;
    }


    
}
