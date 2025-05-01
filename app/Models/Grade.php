<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    //

    public function formations()
    {
        return $this->belongsToMany(Formation::class);
    }
}
