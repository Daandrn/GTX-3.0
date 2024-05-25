<?php declare(strict_types=1);

namespace App\Models;

use Vendor\Model\Model;

require_once __DIR__ . '/../../Vendor/autoload.php';

class Membros extends Model
{
    //
}

$fillable = [
    'nome',
    'nick',
    'plataforma',
    'status_solicit',
    'senha',
];

$membrosModel = new Membros('membros', $fillable);
