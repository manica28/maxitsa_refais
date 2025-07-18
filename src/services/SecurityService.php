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

}