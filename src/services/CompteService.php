<?php
namespace App\Service;
use App\Core\App;
use App\Repository\CompteRepository;


class CompteService 
{
    private CompteRepository $compteRepository;

    private static CompteService|null $instance = null ;

    static function getInstance():CompteService 
    {
        if(self::$instance === null)
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function __construct ()
    {
        $this->compteRepository = App::getDependencies('CompteRepository');
    }
    public function recupcompt($user_id):array|null
    {
        return $this->compteRepository->getCompteClient($user_id);
    }


    //  // Méthode pour obtenir le nombre de transactions d'un compte
    // public function countTransactionsCompte(int $clientId): int
    // {
    //     return $this->compteRepository->countTransactionsByCompteId($clientId);
    // }

    // public function transactionsCompte(int $clientId, int $limit = null)
    // {
    //     return $this->compteRepository->getTransactionsByCompteId($clientId, $limit);
    // }
    
}