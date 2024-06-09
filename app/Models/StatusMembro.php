<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StatusMembro extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
    ];

    protected $table = 'status_membros';


    /**
     * Get all of the membros for the StatusMembro
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function membros(): HasMany
    {
        return $this->hasMany(Membro::class, 'status_solicit', 'id');
    }
}
