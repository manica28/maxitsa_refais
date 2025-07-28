<?php
namespace App\Controlleur;
use App\Core\App;
use App\Core\Validator;
use App\Core\ImageService;
use App\Service\SecurityService;
use App\Core\Abstract\AbstractControlleur;

class InscriptionControlleur extends AbstractControlleur 
{
    private SecurityService $securityService;
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

    private function validateSecondaireForm(array &$data): array 
    {
        $this->validator->validate($data, 
        [
            'telephone' => ['require', 'isPhone'],
            'solde' => ['numeric']
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
                $this->session->set('errors', []);
                $data = $_POST;

                $errors = $this->validateSecondaireForm($data);
                
                if (!empty($errors)) {
                    $this->session->set('errors', $errors);
                    // $this->showNewSecondaire();
                    return;
                }

                $userId = $this->session->get('user')['id'] ?? null;
                if (!$userId) {
                    $this->session->set('errors', ['compte' => 'Utilisateur non connecté']);
                    header("Location: " . APP_URL . "/");
                    exit;
                }

                $numeroTelephone = $data['telephone']; 
                $soldeInitial = isset($data['solde']) && $data['solde'] !== '' ? (float)$data['solde'] : 0; 

                // Créer le compte secondaire
                $result = $this->securityService->createCompteSecondaire($userId, $soldeInitial, $numeroTelephone);
                
                if (is_array($result)) {
                    // Succès - le résultat contient les données du nouveau compte
                    $this->session->set('success', 'Compte secondaire créé avec succès !');
                    $this->session->set('nouveau_compte', $result); // Stocker temporairement les données
                    
                    // Optionnel : log pour debug
                    error_log("Nouveau compte créé: " . print_r($result, true));
                    
                    header("Location: " . APP_URL . "/newsecondaire");
                    exit;
                }
                else 
                {
                    // Erreur
                    $this->session->set('errors', ['compte' => $result]);
                }
            } 
            catch (\Exception $e) 
            {
                error_log("Erreur création compte secondaire: " . $e->getMessage());
                $this->session->set('errors', ['compte' => 'Erreur interne: ' . $e->getMessage()]);
            }
        }
        
        // $this->showNewSecondaire();
    }

    /**
     * Afficher la page de création de compte secondaire avec la liste des comptes
     */

 
public function affichecomptesecondaire($user_id)
{
    // Récupérer les comptes secondaires
    $secondaires = $this->securityService->recupcomptesecondaire($user_id);
    
    // Récupérer le compte principal
    $comptePrincipal = $this->securityService->getAllUserComptes($user_id);
    
    // Debug pour voir ce qu'on récupère
    var_dump("Secondaires:", $secondaires);
    var_dump("Principal:", $comptePrincipal);
    
    $this->renderHtml('compte/newsecondaire.php', [
        "secondaires" => $secondaires,
        "principal" => $comptePrincipal
    ]);
}


    // public function showNewSecondaire()
    // {
    //     $this->layout = 'base'; 
        
    //     $comptesSecondaires = [];
    //     $nouveauCompte = null;
    //     $userId = $this->session->get('user')['id'] ?? null;
        
    //     if ($userId) {
    //         $compteRepository = App::getDependencies('CompteRepository');
            
    //         // Récupérer tous les comptes secondaires
    //         $comptesSecondaires = $compteRepository->getComptesSecondaires($userId);
            
    //         // Récupérer le nouveau compte s'il existe
    //         $nouveauCompte = $this->session->get('nouveau_compte');
    //         if ($nouveauCompte) {
    //             // Marquer le nouveau compte pour le mettre en évidence
    //             foreach ($comptesSecondaires as &$compte) {
    //                 if ($compte['id'] == $nouveauCompte['id']) {
    //                     $compte['nouveau'] = true;
    //                     break;
    //                 }
    //             }
    //         }
    //     }
        
    //     $this->renderHtml("compte/newsecondaire.php", [
    //         'comptesSecondaires' => $comptesSecondaires,
    //         'nouveauCompte' => $nouveauCompte,
    //         'errors' => $this->session->get('errors', []),
    //         'success' => $this->session->get('success', '')
    //     ]);
        
    //     // Nettoyer les données de session après affichage
    //     $this->session->unset('errors');
    //     $this->session->unset('success');
    //     $this->session->unset('nouveau_compte');
    // }

    // /**
    //  * API pour récupérer les comptes d'un utilisateur en JSON
    //  */
    // public function getComptes()
    // {
    //     $userId = $this->session->get('user')['id'] ?? null;
    //     if (!$userId) {
    //         http_response_code(401);
    //         echo json_encode(['error' => 'Utilisateur non connecté']);
    //         return;
    //     }

    //     $comptes = $this->securityService->getAllUserComptes($userId);
        
    //     header('Content-Type: application/json');
    //     echo json_encode($comptes);
    // }

    // /**
    //  * API pour récupérer un compte par son numéro
    //  */
    // public function getCompteByNumero($numero = null)
    // {
    //     if (!$numero) {
    //         $numero = $_GET['numero'] ?? null;
    //     }
        
    //     if (!$numero) {
    //         http_response_code(400);
    //         echo json_encode(['error' => 'Numéro de compte requis']);
    //         return;
    //     }

    //     $compte = $this->securityService->getCompteByNumero($numero);
        
    //     header('Content-Type: application/json');
    //     if ($compte) {
    //         echo json_encode($compte);
    //     } else {
    //         http_response_code(404);
    //         echo json_encode(['error' => 'Compte non trouvé']);
    //     }
    // }
}