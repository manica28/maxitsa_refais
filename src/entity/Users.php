<?php
namespace App\Entity;

use App\Core\AbstractEntity;

class Users /* extends AbstractEntity */ {
    private int $id ;
    private string $login ; 
    private string $password ; 
    private string $nom ;
    private string $prenom ;
    private string $adresse ; 
    private string $numerocni ; 
    private string $photorecto ; 
    private string $photoverso ; 
    private Profil $profil_id ;
    private array $numeros ;

  public   function __construct (int $id =1, string $login = "", string $password = "", string $nom = "" , string $prenom = "", string $adresse = "", string $numerocni = "", 
    string $photorecto = "" ,string  $photoverso = ""){
        $this->id = $id ; 
        $this->login = $login ;
        $this->password = $password;
        $this->nom = $nom ;
        $this->prenom =  $prenom ;  
        $this->adresse = $adresse;
        $this->numerocni = $numerocni;
        $this->photorecto = $photorecto;
        $this->photoverso = $photoverso ;
        $this->profil_id = new Profil();
        $this->numeros= [];
    }

    public function getId(): int {
        return $this->id;
    }   
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getLogin(): string {
        return $this->login;
    }
    public function setLogin(string $login): void {
        $this->login = $login;
    }
    public function getPassword(): string {
        return $this->password;
    }
    public function setPassword(string $password): void {
        $this->password = $password;

    }
    public function getNom(): string {
        return $this->nom;
    }
    public function setNom(string $nom): void {
        $this->nom = $nom;
    }
    public function getPrenom(): string {
        return $this->prenom;
    }
    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }
    public function getAdresse(): string {
        return $this->adresse;
    }
    public function setAdresse(string $adresse): void {
        $this->adresse = $adresse;
    }
    public function getNumerocni(): string {
        return $this->numerocni;
    }
    public function setNumerocni(string $numerocni): void {
        $this->numerocni = $numerocni;
    }
    public function getPhotorecto(): string {
        return $this->photorecto;
    }
    public function setPhotoecto(string $photorecto): void {
        $this->photorecto = $photorecto;
    }
    public function getPhotoverso(): string {
        return $this->photoverso;
    }
    public function setPhotoverso(string $photoverso): void {
        $this->photoverso = $photoverso;
    }

    /**
     * Get the value of profil
     */ 
    public function getProfil()
    {
        return $this->profil_id;
    }

    /**
     * Set the value of profil
     *
     * @return  self
     */ 
    public function setProfil($profil)
    {
        $this->profil_id = $profil;

        return $this;
    }

    /**
     * Get the value of numeros
     */ 
    public function getNumeros()
    {
        return $this->numeros;
    }

    /**
     * Set the value of numeros
     *
     * @return  self
     */ 
    public function AddNumeros(NumeroTelephone $numero)
    {
        $this->numeros[] = $numero;

        return $this;
    }
    public  function toArray():array{

        return [
            'id'       => $this->id,
            'login'    => $this->login ,
            'password' => $this->password ,
            'nom'      => $this->nom,
            'prenom'   => $this->prenom,
            'adresse'  => $this->adresse ,
            'cni'      => $this->numerocni ,
            'recto'    => $this->photorecto , 
            'verso'    => $this->photoverso ,
            // 'profil'   => $this->profil_id->toArray() ,
             'numeros'  => array_map(fn ($num) => $num->toArray() , $this->numeros)

        ];
    }
    public static function toObject (array $array) : static {
       return  new static( 
            $array['id'] ?? 1,
            $array['login'] ?? "",
            $array['password'] ?? "",
            $array['nom' ] ?? "",
            $array['prenom'] ?? "",
            $array['adresse'] ?? "",
            $array['numerocni'] ?? "",
            $array['photorecto'] ?? "",
            $array['photoverso'] ?? ""
            // Les champs 'profil' et 'numeros' sont gérés par le constructeur
         ) ;

    }
}
