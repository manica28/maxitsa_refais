<?php
namespace App\Controlleur;
use App\Core\App;
use App\Core\Validator;
use App\Core\ImageService;
use App\Service\SecurityService;
use App\Core\Abstract\AbstractControlleur;

class InscriptionControlleur extends AbstractControlleur 
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

    

    public function show(){}
    public function edit(){}
    public function store(){}
    public function create(){
         $this->renderHtml('login/inscription.php');
        }
    public function index(){ require_once '../templates/compte/home.php'; }

    private function validateForm(array &$data): array 
    {
        $this->validator->validate($data, 
        [
            'nom' => ['require', ['minLenght',3,"Le login doit contenir au minimum 3 caractères"]],
            'prenom' => ['require', ['minLenght',3,"Le login doit contenir au minimum 3 caractères"]] ,
            'login' => ['require', ['minLenght',3,"Le login doit contenir au minimum 3 caractères"]],
            'password' => ['require', ['minLenght',3,"Le login doit contenir au minimum 3 caractères"], 'isPassword'],
            'adresse' => ['require'],
            'telephone' => ['require', 'isPhone'],
            'numeroCNI' => ['require', 'isCNI']
        ]);
        return $this->validator->getError();
    }
    private function buildUserData(array $data, string $photoPath): array 
    {
        return [
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'login' => $data['login'],
            'password' => $data['password'],
            'adresse' => $data['adresse'],
            'numerocni' => $data['numeroCNI'],
            'photorecto' => $photoPath,
            'photoverso' => $photoPath,
            'profil_id' => 1
        ];
}
   
    // fonction qui crée un compte principal
    public function createComptePrincipal() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $data = $_POST;
            $numeroTelephone = $data['telephone'];    
            $errors = $this->validateForm($data);
        $this->session->set('errors', []);

        if (empty($errors)) {
            $photoPath = $this->uploadPhotos($_FILES);
            if (!$photoPath) {
                $this->session->set('errors', ['photoIdentite' => "Erreur lors de l'envoi des photos."]);
            } else {
                $userData = $this->buildUserData($data, $photoPath);

                $result = $this->securityService->inscription($userData, $numeroTelephone);
                if ($result === true) {
                    header("Location: ".APP_URL."/");

                    // $twilioService = new TwilioService();
                    // $message = "Bonjour {$userData['prenom']} {$userData['nom']}, votre compte principal a été  créé avec succès sur Maxit SA}.";
                    // $smsResult = $twilioService->sendSMS($numeroTelephone, $message);

                    // if ($smsResult !== true) {
                    //     error_log("Erreur SMS Twilio : " . $smsResult);
                    // }
                    // exit;
                }
                else 
                {
                    $this->session->set('errors', ['compte' => $result]);
                }
            }
        } else {
            $this->session->set('errors', $errors);
        }
    }
    $this->layout = 'security';
    $this->renderHtml("login/inscription.php");
}

public function createCompteSecondaire() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $data = $_POST;
            $numeroTelephone = $data['telephone']; 
            

            $errors = $this->validateForm($data);
            $this->session->set('errors', []);

        if (empty($errors)) {
            $photoPath = $this->uploadPhotos($_FILES);
            if (!$photoPath) {
                $this->session->set('errors', ['photoIdentite' => "Erreur lors de l'envoi des photos."]);
            } else {
                $userData = $this->buildUserData($data, $photoPath);

                $result = $this->securityService->createCompteSecondaire($this->session->get('user')['id'], $data['solde'], $numeroTelephone);
                if ($result === true) {
                    header("Location: ".APP_URL."/");

                    // $twilioService = new TwilioService();
                    // $message = "Bonjour {$userData['prenom']} {$userData['nom']}, votre compte principal a été  créé avec succès sur Maxit SA}.";
                    // $smsResult = $twilioService->sendSMS($numeroTelephone, $message);

                    // if ($smsResult !== true) {
                    //     error_log("Erreur SMS Twilio : " . $smsResult);
                    // }
                    // exit;
                }
                else 
                {
                    $this->session->set('errors', ['compte' => $result]);
                }
            }
        } else {
            $this->session->set('errors', $errors);
        }
    }
    $this->layout = 'security';
    $this->renderHtml("compte/newsecondaire.php");
}
}


