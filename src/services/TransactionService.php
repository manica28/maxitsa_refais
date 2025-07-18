<?php
namespace App\Service;
use App\Core\App;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;


class TransactionService 
{
    private TransactionRepository $TransactionRepository;

    private static TransactionService|null $instance = null ;

    static function getInstance():TransactionService 
    {
        if(self::$instance === null)
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function __construct ()
    {
        $this->TransactionRepository = App::getDependencies('TransactionRepository');
    }
    
    public function recuptransac($user_id):array|null
    {
        return $this->TransactionRepository->getTransactions($user_id);
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