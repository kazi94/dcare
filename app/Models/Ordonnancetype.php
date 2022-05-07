<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordonnancetype extends Model
{
    public $timestamps = false;

    public function medicaments()
    {
        return $this->hasMany('App\Models\OrdonnanceTypeLine');
    }

}
