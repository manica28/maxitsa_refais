<?php
namespace App\Service;
use App\Core\App;
use App\Entity\NumeroTelephone;
use App\Repository\UserRepository;
use App\Repository\CompteRepository;
use App\Repository\NumeroTelephoneRepository;

class SecurityService 
{
    private UserRepository $userRepository;
    private NumeroTelephoneRepository $NumeroTelephoneRepository;
    private CompteRepository $compteRepository;

    private static SecurityService|null $instance = null;

    static function getInstance(): SecurityService 
    {
        if(self::$instance === null)
        {
            self::$instance = new static();
        }
        return self::$instance;
    }

    function __construct()
    {
        $this->userRepository = App::getDependencies('UserRepository');
        $this->compteRepository = App::getDependencies('CompteRepository');
        $this->NumeroTelephoneRepository = App::getDependencies('NumeroTelephoneRepository');
    }

    function getConnected($login, $password)
    {
        $user = $this->userRepository->selectLoginPassword($login, $password);

        if ($user)
        {
            return $user;
        }
        return null;
    }

    public function inscription($user, $telephone)
    {
        return $this->NumeroTelephoneRepository->insertTransaction($user, $telephone);
    }

    // recuperer le compte secondaire crée dans le repository
    public function createCompteSecondaire($user_id, $solde, $telephone)
    {
        // Vérifications préliminaires
        $user = $this->userRepository->selectById($user_id);
        if (!$user) 
        {
            return "Utilisateur non trouvé.";
        }

        $existingNumero = $this->NumeroTelephoneRepository->findByNumero($telephone);
        if ($existingNumero) 
        {
            return "Ce numéro de téléphone est déjà associé à un compte.";
        }

        $comptePrincipal = $this->compteRepository->findPrincipalByUserId($user_id);
        if (!$comptePrincipal) 
        {
            return "Vous devez d'abord créer un compte principal.";
        }

        // Créer le compte secondaire
        $result = $this->NumeroTelephoneRepository->insertSecondaire($user_id, $solde, $telephone);
        
        // Si la création a réussi, retourner les données du nouveau compte
        if ($result === true) {
            return $this->getLatestCompteSecondaire($user_id, $telephone);
        }
        
        return $result; // Retourner l'erreur si échec
    }

    /**
     * Récupère le dernier compte secondaire créé pour un utilisateur
     */
    public function getLatestCompteSecondaire($user_id, $telephone = null): array|null
    {
        if ($telephone) {
            // Récupérer le compte spécifique par téléphone
            return $this->compteRepository->getCompteByTelephone($telephone);
        } else {
            // Récupérer le dernier compte secondaire créé
            $comptesSecondaires = $this->compteRepository->getComptesSecondaires($user_id);
            return !empty($comptesSecondaires) ? $comptesSecondaires[0] : null;
        }
    }

    /**
     * Récupère tous les comptes d'un utilisateur (principal + secondaires)
     */
    public function getAllUserComptes($user_id): array
    {
        $comptes = [];
        
        // Récupérer le compte principal
        $comptePrincipal = $this->compteRepository->findPrincipalByUserId($user_id);
        if ($comptePrincipal) {
            $comptePrincipal['type'] = 'principal';
            $comptes[] = $comptePrincipal;
        }

        // Récupérer les comptes secondaires
        $comptesSecondaires = $this->compteRepository->getComptesSecondaires($user_id);
        foreach ($comptesSecondaires as $compte) {
            $compte['type'] = 'secondaire';
            $comptes[] = $compte;
        }

        return $comptes;
    }

    /**
     * Récupère un compte spécifique par son numéro
     */
    public function getCompteByNumero($numero): array|null
    {
        return $this->compteRepository->getCompteByNumero($numero);
    }

    // recuperer les comptes secondaores
public function recupcomptesecondaire($user_id) 
{
    return $this->compteRepository->getComptesSecondaires($user_id);
}
}