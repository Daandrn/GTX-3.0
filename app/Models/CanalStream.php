<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CanalStream extends Model
{
    use HasFactory;

    protected $fillable = [
        'membro_id',
        'plataforma',
        'link_canal',
        'nick_stream',
    ];

    protected $table = 'canal_stream';

    /**
     * Get all of the membros for the CanalStream
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function membros(): HasMany
    {
        return $this->hasMany(Membro::class, 'membro_id', 'id');
    }
}
