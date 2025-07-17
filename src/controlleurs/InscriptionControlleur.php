<?php

namespace App\Controlleur ;

use App\Core\Abstract\AbstractControlleur;

class InscriptionControlleur extends AbstractControlleur {

    function create (){
        require_once '../templates/login/inscription.php';
    }
    function show (){
        require_once '../templates/login/connexion.php';
    }
    function edit () {

    }
    function store (){

$infos = [
    'nom' => $_POST['nom'] ?? '',
    'prenom' => $_POST['prenom'] ?? '',
    'numero' =>  $_POST['numero']?? '',
    'cni' =>  $_POST['cni']?? '',
    'numero' =>  $_POST['numero']?? '',
    'password' =>  $_POST['password']?? '',
    'typeUser_id' => 1

] ;

    }
    function index (){

    }
}