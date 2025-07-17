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
    private string $cni ; 
    private string $recto ; 
    private string $verso ; 
    private Profil $profil ;
    private array $numeros ;

  public   function __construct (int $id =1, string $login = "", string $password = "", string $nom = "" , string $prenom = "", string $adresse = "", string $cni = "", 
    string $recto = "" ,string  $verso = ""){
        $this->id = $id ; 
        $this->login = $login ;
        $this->password = $password;
        $this->nom = $nom ;
        $this->prenom =  $prenom ;  
        $this->adresse = $adresse;
        $this->cni = $cni;
        $this->recto = $recto;
        $this->verso = $verso ;
        $this->profil = new Profil();
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
    public function getCni(): string {
        return $this->cni;
    }
    public function setCni(string $cni): void {
        $this->cni = $cni;
    }
    public function getRecto(): string {
        return $this->recto;
    }
    public function setRecto(string $recto): void {
        $this->recto = $recto;
    }
    public function getVerso(): string {
        return $this->verso;
    }
    public function setVerso(string $verso): void {
        $this->verso = $verso;
    }



    /**
     * Get the value of profil
     */ 
    public function getprofil()
    {
        return $this->profil;
    }

    /**
     * Set the value of profil
     *
     * @return  self
     */ 
    public function setprofil($profil)
    {
        $this->profil = $profil;

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
            'cni'      => $this->cni ,
            'recto'    => $this->recto , 
            'verso'    => $this->verso ,
/*             'profil'   => $this->profil->toArray() ,
 */            'numeros'  => array_map(fn ($num) => $num->toArray() , $this->numeros)

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
            $array['cni'] ?? "",
            $array['recto'] ?? "",
            $array['verso'] ?? ""
            // Les champs 'profil' et 'numeros' sont gérés par le constructeur
         ) ;

    }
}
