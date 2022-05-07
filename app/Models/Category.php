<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public    $timestamps = false;
    protected $table = 'categories';
    protected $fillable = ['name', 'color'];

    public function acts()
    {
        return $this->hasMany('App\Models\Acte', 'category_id');
    }
}
