<?php
namespace App\Enums;

enum TypeTransaction : string {
    case PAIEMENT =  'paiement';
    case DEPOT = 'depot';
    case RETRAIT = 'retrait';
}