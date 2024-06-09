<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanalStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'membro_id',
        'plataforma',
        'link_canal',
        'nick_stream',
    ];

    protected $table = [
        'canal_stream'
    ];
}
