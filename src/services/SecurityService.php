<?php
namespace App\Service;
use App\Core\App;
use App\Repository\UserRepository;

class SecurityService 
{
    private  UserRepository $userRepository;

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

}