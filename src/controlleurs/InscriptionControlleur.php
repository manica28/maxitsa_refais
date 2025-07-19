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
    public function index(){ 
        require_once '../templates/compte/home.php'; 
    }

    private function validateForm(array &$data): array 
    {
        $this->validator->validate($data, 
        [
            'nom' => ['require', ['minLenght',3,"Le nom doit contenir au minimum 3 caractères"]],
            'prenom' => ['require', ['minLenght',3,"Le prénom doit contenir au minimum 3 caractères"]] ,
            'login' => ['require', ['minLenght',3,"Le login doit contenir au minimum 3 caractères"]],
            'password' => ['require', ['minLenght',3,"Le mot de passe doit contenir au minimum 3 caractères"], 'isPassword'],
            'adresse' => ['require'],
            'telephone' => ['require', 'isPhone'],
            'numeroCNI' => ['require', 'isCNI']
        ]);
        return $this->validator->getError();
    }

    // Validation spécifique pour les comptes secondaires
    private function validateSecondaireForm(array &$data): array 
    {
        $this->validator->validate($data, 
        [
            'telephone' => ['require', 'isPhone'],
            'solde' => ['numeric'] // optionnel mais doit être numérique si fourni
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
                        exit;
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
            try 
            {
                // Nettoyer les erreurs précédentes
                $this->session->set('errors', []);
                $data = $_POST;

                // Validation spécifique pour compte secondaire
                $errors = $this->validateSecondaireForm($data);
                
                if (!empty($errors)) {
                    $this->session->set('errors', $errors);
                    $this->showNewSecondaire();
                    return;
                }

                // Vérifier que l'utilisateur est connecté
                $userId = $this->session->get('user')['id'] ?? null;
                if (!$userId) {
                    $this->session->set('errors', ['compte' => 'Utilisateur non connecté']);
                    header("Location: " . APP_URL . "/");
                    exit;
                }

                $numeroTelephone = $data['telephone']; 
                $soldeInitial = isset($data['solde']) && $data['solde'] !== '' ? (float)$data['solde'] : 0; 

                // Appeler le service pour créer le compte secondaire
                $result = $this->securityService->createCompteSecondaire($userId, $soldeInitial, $numeroTelephone);
                
                if ($result === true) 
                {
                    $this->session->set('success', 'Compte secondaire créé avec succès !');
                    // Rediriger vers la même page pour afficher le nouveau compte
                    header("Location: " . APP_URL . "/newsecondaire");
                    exit;
                }
                else 
                {
                    $this->session->set('errors', ['compte' => $result]);
                }
            } 
            catch (\Exception $e) 
            {
                error_log("Erreur création compte secondaire: " . $e->getMessage());
                $this->session->set('errors', ['compte' => 'Erreur interne: ' . $e->getMessage()]);
            }
        }
        
        $this->showNewSecondaire();
    }

    // Afficher la page de création de compte secondaire avec la liste des comptes
   public function showNewSecondaire()
{
    $this->layout = 'base'; 
    
    $comptesSecondaires = [];
    $userId = $this->session->get('user')['id'] ?? null;
    
    if ($userId) {
        $compteRepository = App::getDependencies('CompteRepository');
        $comptesSecondaires = $compteRepository->getComptesSecondaires($userId);
    }
    
    $this->renderHtml("compte/newsecondaire.php", [
        'comptesSecondaires' => $comptesSecondaires,
        'errors' => $this->session->get('errors', []),
        'success' => $this->session->get('success', '')
    ]);
    
    $this->session->unset('errors');
    $this->session->unset('success');
}
    
}