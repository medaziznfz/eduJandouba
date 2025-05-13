<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'titre', 'thumbnail', 'description', 'summary',
        'duree', 'lieu', 'capacite', 'sessions', 'deadline',
        'etablissement_id', 'status', 'nbre_demandeur', 'nbre_inscrit',
        'mode', 'start_at', 'link', 'formateur_name', 'formateur_email', // added
    ];

    /**
     * Casts for native types.
     */
    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Human-readable label for the status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available'   => 'Disponible',
            'in_progress' => 'En cours',
            'completed'   => 'Terminé',
            'canceled'    => 'Annulé',
            default       => ucfirst($this->status),
        };
    }

    /**
     * CSS classes for the badge.
     */
    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'available'   => 'bg-success-subtle text-success',
            'in_progress' => 'bg-primary-subtle text-primary',
            'completed'   => 'bg-secondary-subtle text-secondary',
            'canceled'    => 'bg-danger-subtle text-danger',
            default       => 'bg-light text-dark',
        };
    }

    /**
     * The grades this formation is for.
     */
    public function grades()
    {
        return $this->belongsToMany(Grade::class);
    }

    /**
     * The établissement that owns this formation.
     */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function applicants()
    {
        return $this->belongsToMany(User::class, 'formation_user')
                    ->withPivot('status', 'etab_confirmed', 'univ_confirmed', 'user_confirmed') // Include 'status'
                    ->withTimestamps();
    }


    public function applicationRequests()
    {
        return $this->hasMany(ApplicationRequest::class);
    }

    
}
