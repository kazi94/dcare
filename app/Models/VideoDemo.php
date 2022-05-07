<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoDemo extends Model
{
    protected $table = "videos_demo";

    public function act()
    {
        return $this->belongsTo('App\Models\Acte');
    }
}
