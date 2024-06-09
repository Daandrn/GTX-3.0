<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlataformaGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    protected $table = 'plataforma_game';

    /**
     * Get all of the membros for the PlataformaGame
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function membros(): HasMany
    {
        return $this->hasMany(Membro::class, 'plataforma', 'id');
    }
}
