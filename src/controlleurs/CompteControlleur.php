<?php
namespace App\Controlleur ;
use App\Service\CompteService;
use App\Core\App;

use App\Core\Abstract\AbstractControlleur;

class CompteControlleur extends AbstractControlleur
{
        public function __construct()
    {
         parent::__construct();
         $this->compteService = App::getDependencies('CompteService'); // au lieu de $this->compteService = new CompteService();
    }

        public  function index (){
            $test=$this->session->get('user');
            // var_dump($test);
            // die;
            $user_id=$test['id'];
            $comptes = $this->compteService->recupcompt($user_id);
            // var_dump($comptes);
            // die;

            $this->renderHtml('compte/home.php', [
                "comptes"=>$comptes
            ] );
    }
    private CompteService $compteService ;




        
   
/*         require_once '../templates/login/connexion.php';
 */    

      public  function show(){

      }
    public  function edit (){

    }
    public  function store (){

    }
    public  function create (){

    }


}