<?php
namespace App\Controlleur ;
use App\Core\App;
use App\Service\CompteService;

use App\Service\TransactionService;
use App\Core\Abstract\AbstractControlleur;

class CompteControlleur extends AbstractControlleur
{
     private TransactionService $TransactionService ;

        public function __construct()
    {
         parent::__construct();
         $this->compteService = App::getDependencies('CompteService'); // au lieu de $this->compteService = new CompteService();
         $this->TransactionService = App::getDependencies('TransactionService'); // au lieu de $this->compteService = new CompteService();

    }

        public  function index (){
            $test=$this->session->get('user');
            // var_dump($test);
            // die;
            $user_id=$test['id'];
            $comptes = $this->compteService->recupcompt($user_id);
            $transactions = $this->TransactionService->recuptransac($user_id);
            // var_dump($comptes);
            // die;

            $this->renderHtml('compte/home.php', [
                "comptes"=>$comptes,
                "transactions"=>$transactions
            ] );
    }
    private CompteService $compteService ;




        
   
/*         require_once '../templates/login/connexion.php';
 */    

      public  function store(){}
    public  function edit (){}
     public function create()
    {
        $this->renderHtml('compte/newsecondaire.php');
    }
     public function show(){
        $this->renderHtml('compte/transactions.php');
     }


}