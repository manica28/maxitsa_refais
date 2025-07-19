<?php
namespace App\Service;
use App\Core\App;
use App\Entity\NumeroTelephone;
use App\Repository\UserRepository;
use App\Repository\NumeroTelephoneRepository;

class SecurityService 
{
    private  UserRepository $userRepository;
    private  NumeroTelephoneRepository $NumeroTelephoneRepository;

    private static SecurityService|null $instance = null ;

    static function getInstance():SecurityService 
    {
        if(self::$instance === null)
        {
            self::$instance = new static();
        }
    return self::$instance;
    }

    function __construct ()
    {
        $this->userRepository = App::getDependencies('UserRepository');
        $this->NumeroTelephoneRepository = App::getDependencies('NumeroTelephoneRepository');
    }

    function getConnected ($login , $password)
    {
        $user =  $this->userRepository->selectLoginPassword($login , $password);

        if ($user)
        {
            return $user ;
        }
        return null ;
    }

public function inscription($user, $telephone)
{
    return $this->NumeroTelephoneRepository->insertTransaction($user, $telephone);
}

// public function createCompteSecondaire($user_id, $solde, $telephone){
//     return $this->NumeroTelephoneRepository->insertSecondaire($user_id, $solde ,$telephone);
// }
public function createCompteSecondaire($user_id, $solde, $telephone){
    error_log("SecurityService::createCompteSecondaire appelé avec: user_id=$user_id, solde=$solde, telephone=$telephone");
    $result = $this->NumeroTelephoneRepository->insertSecondaire($user_id, $solde ,$telephone);
    error_log("Résultat insertSecondaire: " . print_r($result, true));
    return $result;
}

}