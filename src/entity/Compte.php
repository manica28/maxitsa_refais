<?php
namespace App\Entity;

use App\Enums\TypeCompte;
use DateTime;

class Compte {
    private int $id ; 
    private int $solde ; 
    private string $numero  ; 
    private string $date ; 
    private int $type ; 
    private array $transactions ;
    private NumeroTelephone $num ; 

    function __construct (int $id =0 , int $solde = 0, $numero = "",string $date = '', $type = 1){

        $this->id = $id ;
        $this->solde = $solde ;
        $this->numero = $numero ; 
        $this->date = $date ;
        $this->type = $type ; 
        $this->transactions = [];
        $this->num = new NumeroTelephone();
    }

    

     public  function toArray():array{

        return [
            'id'       => $this->id,
            'solde'      => $this->solde,
            'numero'   => $this->numero,
            'date'  => $this->date ,
            'type_id'      => $this->type,
            'num_id'    => $this->num 
/*             'profil'   => $this->profil->toArray() ,
          'transactions'  => array_map(fn ($num) => $num->toArray() , $this->transactions)*/

        ];
    }
    public static function toObject (array $array) : static {
       return  new static( 
        isset($array['id']) ? (int)$array['id'] : 1,
        isset($array['solde']) ? (int)$array['solde'] : 0,
        $array['numero'] ?? "",
            $array['date' ] ?? "",
        isset($array['type_id']) ? (int)$array['type'] : 1,
           /*  $array['adresse'] ?? "",
            $array['cni'] ?? "",
            $array['recto'] ?? "",
            $array['verso'] ?? "" */
            // Les champs 'profil' et 'numeros' sont gérés par le constructeur
         ) ;

    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of solde
     */ 
    public function getSolde()
    {
        return $this->solde;
    }

    /**
     * Set the value of solde
     *
     * @return  self
     */ 
    public function setSolde($solde)
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * Get the value of numero
     */ 
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */ 
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of transactions
     */ 
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Set the value of transactions
     *
     * @return  self
     */ 
    public function AddTransactions(Transaction $transaction)
    {
        $this->transactions [] = $transaction;

        return $this;
    }

    /**
     * Get the value of num
     */ 
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Set the value of num
     *
     * @return  self
     */ 
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }
}