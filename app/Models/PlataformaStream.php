<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlataformaStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    protected $table = 'plataforma_stream';
}
