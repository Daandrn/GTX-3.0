<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Membro extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $fillable = [
        'nome',
        'nick',
        'plataforma',
        'status_solicit',
        'email',
        'senha',
    ];

    protected $table = 'membros';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'senha' => 'hashed',
    ];

    /**
     * Get the canal_stream associated with the Membro
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function canal_stream(): HasOne
    {
        return $this->hasOne(CanalStream::class, 'membro_id', 'id');
    }

    /**
     * Get the plataforma_game that owns the Membro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plataforma_game(): BelongsTo
    {
        return $this->belongsTo(PlataformaGame::class, 'plataforma', 'id');
    }


    /**
     * Get the status_membros that owns the Membro
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status_membros(): BelongsTo
    {
        return $this->belongsTo(StatusMembro::class, 'status_solcit', 'id');
    }
}
