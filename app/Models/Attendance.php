<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // If you don’t want `created_at`/`updated_at`, set this to false
    public $timestamps = false;

    protected $fillable = [
        'formation_id',
        'user_id',
        'date',
        'present',
    ];
}
