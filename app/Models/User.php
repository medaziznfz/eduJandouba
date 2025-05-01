<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs que l'on peut remplir (mass assignable).
     */
    protected $fillable = [
        'prenom',
        'nom',
        'email',
        'cin',
        'telephone',
        'password',
        'role',
        'etablissement_id', // ✅ à ajouter
    ];

    /**
     * Les attributs à cacher lors de la sérialisation.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs à caster automatiquement.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation avec l’établissement (un utilisateur appartient à un établissement).
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
}
