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
        'grade_id',
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

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function requestedFormations()
    {
        return $this->belongsToMany(Formation::class)
                    ->withPivot('etab_confirmed', 'univ_confirmed', 'status')
                    ->withTimestamps();
    }

    public function applicationRequests()
    {
        return $this->hasMany(ApplicationRequest::class);
    }

    /**
     * Relationship: A User has many Notifications.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->latest();
    }


    /**
     * Get unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->where('read', false);
    }
}
