<?php
namespace App\Entity;

class Profil {
    private int $id ; 
    private string $libelle ; 
    private  array $users ;
     function __construct (int $id = 0 , string $libelle = ''){
    $this->id = $id ;
    $this->libelle = $libelle ;
    $this->users = [];

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
     * Get the value of libelle
     */ 
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set the value of libelle
     *
     * @return  self
     */ 
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get the value of users
     */ 
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set the value of users
     *
     * @return  self
     */ 
    public function AddUsers(Users $user)
    {
        $this->users[] = $user;

        return $this;
    }
}