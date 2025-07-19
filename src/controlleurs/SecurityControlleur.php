<?php
namespace App\Controlleur;
use App\Core\App;
use App\Core\Abstract\AbstractControlleur;
use App\Service\SecurityService;
use App\Core\Validator;

class SecurityControlleur extends AbstractControlleur 
{
    private SecurityService $securityService ;
    private Validator $validator;

    function __construct()
    {
            $this->layout = 'security';
            parent::__construct();
            $this->securityService = App::getDependencies('SecurityService');
            $this->validator = App::getDependencies('Validator');
    }

    public function login() 
    {
         $this->session->unset('erreurs');

        // $data va recuperer les name dans le formulaire ayant comme methode post
        if($_SERVER['REQUEST_METHOD']  === 'POST')
        {
                $data= $_POST;
            // $login = $_POST['login'] ?? '';
            // $password = $_POST['password'] ?? '';

            // $connect = $this->securityService->getConnected($login, $password);

            //on teste avant la connexion les champs
            $rules = 
            [
                'login' =>  ['require', ['minLenght',3,"Le login doit contenir au minimum 3 caractères"]   ],
                'password' =>['require', ['minLenght',5,"Le Password de passe doit contenir au moins 5 caractères"] ]
            ];
            if($this->validator->validate( $data,  $rules)) 
            {
                $connect = $this->securityService->getConnected($data['login'], $data['password']);
                if ($connect) 
                {
                    $this->session->set('user',$connect->toArray());
                    header('Location: /home' );
                } 
                else
                {
                    $this->validator::addError('identifiants', 'Les identifiants ne correspondent pas');
                     $this->session->set('erreurs', $this->validator::getError());
                }
            }
            $this->session->set('erreurs', $this->validator::getError());
        }
        $this->renderHtml('login/connexion.php' );
    }
    public function show(){
        
    }
    public function edit(){}
    public function store(){}
    public function create(){}
    
    public function index()
    { require_once '../templates/compte/home.php'; }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }

    
}


