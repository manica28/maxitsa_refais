<?php
namespace App\Controlleur ;
use App\Core\App;
use App\Service\CompteService;
use App\Service\TransactionService;
use App\Core\Abstract\AbstractControlleur;

class CompteControlleur extends AbstractControlleur
{
    private TransactionService $TransactionService;
    private CompteService $compteService;

    public function __construct()
    {
        parent::__construct();
        $this->compteService = App::getDependencies('CompteService');
        $this->TransactionService = App::getDependencies('TransactionService');
    }
    

    public function index()
    {
        $test = $this->session->get('user');
        $user_id = $test['id'];
        $comptes = $this->compteService->recupcompt($user_id);
        $transactions = $this->TransactionService->recuptransac($user_id);

        $this->renderHtml('compte/home.php', [
            "comptes" => $comptes,
            "transactions" => $transactions
        ]);
    }

    public function edit() 
    {
        $this->renderHtml('compte/woyofal.php');
    }
    

    public function create()
    {
        $this->renderHtml('compte/newsecondaire.php');
    }

    // Méthode pour afficher les transactions avec filtres et statistiques
    public function show()
    {
        try {
            $test = $this->session->get('user');
            if (!$test || !isset($test['id'])) {
                throw new \Exception('Utilisateur non connecté');
            }
            
            $user_id = $test['id'];
            
            // Récupération des filtres
            $filters = [
                'date_debut' => $_GET['date_debut'] ?? '',
                'date_fin' => $_GET['date_fin'] ?? '',
                'type' => $_GET['type'] ?? ''
            ];
            
            // Récupération des transactions avec filtres
            $transactions = $this->TransactionService->getTransactionsWithFilters($user_id, $filters);
            
            // Calcul des statistiques
            $statistics = $this->TransactionService->getTransactionStatistics($user_id, $filters);
            
            $this->renderHtml('compte/transactions.php', [
                'transactions' => $transactions,
                'statistics' => $statistics,
                'filters' => $filters
            ]);
            
        } catch (\PDOException $e) {
            $this->renderHtml('compte/transactions.php', [
                'error' => $e->getMessage(),
                'transactions' => [],
                'statistics' => [
                    'formatted_deposits' => '0 CFA',
                    'formatted_withdrawals' => '0 CFA', 
                    'formatted_payments' => '0 CFA',
                    'total_transactions' => 0
                ],
                'filters' => []
            ]);
        }
    }

    

    public function store() {
        $this->renderHtml('compte/newtransaction.php');

    }

    
}