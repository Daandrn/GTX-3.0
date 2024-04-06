<?php declare(strict_types=1);

namespace App\Models;

use Vendor\Model\Model;

require __DIR__.'/../..//Vendor/Model/Model.php';

class Membros extends Model
{
}

$fillable = [
    'nome', 
    'nick', 
    'plataforma', 
    'status_solicit', 
    'senha',
];

$membrosModel = new Membros('membros', $fillable);
