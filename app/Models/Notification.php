<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'subtitle',
        'redirect_link',
        'read'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'read' => 'boolean',
    ];
    
    /**
     * Relationship to the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}