<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PasswordResetCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'code',
        'expires_at',
    ];

    protected $dates = [
        'expires_at',
    ];

    // Optionnel : méthode pour vérifier si le code a expiré
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
