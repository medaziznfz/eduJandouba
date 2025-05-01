<?php
// app/Models/Demande.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    public const STATUS_PROCESSING           = 'request_processing';
    public const STATUS_WAITING_ACCOUNT      = 'waiting_account_creation';
    public const STATUS_CREATED              = 'account_created';
    public const STATUS_DECLINED             = 'account_declined';

    protected $fillable = [
        'cin',
        'prenom',
        'nom',
        'email',
        'etablissement_id',
        'grade_id',
        'status',
        'confirmation_token',
    ];

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_PROCESSING      => 'Demande en cours',
            self::STATUS_WAITING_ACCOUNT => 'En attente de création de compte',
            self::STATUS_CREATED         => 'Compte créé',
            self::STATUS_DECLINED        => 'Demande refusée',
            default                      => 'Inconnu',
        };
    }

    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            self::STATUS_PROCESSING      => 'bg-warning-subtle text-warning',
            self::STATUS_WAITING_ACCOUNT => 'bg-primary-subtle text-primary',
            self::STATUS_CREATED         => 'bg-success-subtle text-success',
            self::STATUS_DECLINED        => 'bg-danger-subtle text-danger',
            default                      => 'bg-secondary-subtle text-secondary',
        };
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
}
