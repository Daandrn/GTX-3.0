<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlataformaGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    protected $table = [
        'plataforma_game'
    ];
}
