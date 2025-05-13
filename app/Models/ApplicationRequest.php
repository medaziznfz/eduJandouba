<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApplicationRequest extends Model
{
    use HasFactory;

    // ← point at your pivot table
    protected $table = 'formation_user';

    // mass‐assignable fields
    protected $fillable = [
        'formation_id',
        'user_id',
        'status',
        'hash',
        'etab_confirmed',
        'univ_confirmed',
        'user_confirmed',
    ];

    // ↓ if you want dates to be cast
    protected $casts = [
        'etab_confirmed'  => 'boolean',
        'univ_confirmed'  => 'boolean',
        'user_confirmed'  => 'boolean',
        'created_at'      => 'datetime',
        'updated_at'      => 'datetime',
    ];

    // relations
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
