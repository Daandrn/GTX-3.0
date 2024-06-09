<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSenha extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    protected $table = 'status_senha';
}
