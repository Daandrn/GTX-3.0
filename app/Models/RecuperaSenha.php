<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recuperasenha extends Model
{
    use HasFactory;

    protected $fillable = [
        'membro_id',
        'nick',
        'nova_senha',
        'status_solicit',
    ];

    protected $table = [
        'recupera_senha'
    ];
}
