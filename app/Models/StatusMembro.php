<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statusmembro extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    protected $table = [
        'status_membro'
    ];
}
