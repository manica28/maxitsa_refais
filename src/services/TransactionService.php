<?php
namespace App\Service;
use App\Core\App;
use App\Entity\Transaction;
use App\Repository\TransactionRepository;

class TransactionService 
{
    private TransactionRepository $TransactionRepository;
    private static TransactionService|null $instance = null;

    static function getInstance(): TransactionService 
    {
        if(self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function __construct()
    {
        $this->TransactionRepository = App::getDependencies('TransactionRepository');
    }
    
    public function recuptransac($user_id): array|null
    {
        return $this->TransactionRepository->getTransactions($user_id);
    }

    // Méthode pour récupérer les transactions avec filtres
    public function getTransactionsWithFilters($user_id, $filters): array
    {
        return $this->TransactionRepository->getTransactionsWithFilters($user_id, $filters);
    }

    // Méthode pour calculer les statistiques des transactions
    public function getTransactionStatistics($user_id, $filters): array
    {
        $transactions = $this->getTransactionsWithFilters($user_id, $filters);
        
        $deposits = 0;
        $withdrawals = 0;
        $payments = 0;
        $totalTransactions = count($transactions);

        foreach ($transactions as $transaction) {
            $type = strtolower($transaction['typetransaction']);
            $montant = floatval($transaction['montant']);
            
            switch ($type) {
                case 'depot':
                    $deposits += $montant;
                    break;
                case 'retrait':
                    $withdrawals += $montant;
                    break;
                case 'paiement':
                    $payments += $montant;
                    break;
            }
        }

        return [
            'formatted_deposits' => number_format($deposits, 0, ',', ' ') . ' CFA',
            'formatted_withdrawals' => number_format($withdrawals, 0, ',', ' ') . ' CFA',
            'formatted_payments' => number_format($payments, 0, ',', ' ') . ' CFA',
            'total_transactions' => $totalTransactions,
            'raw_deposits' => $deposits,
            'raw_withdrawals' => $withdrawals,
            'raw_payments' => $payments
        ];
    }
}