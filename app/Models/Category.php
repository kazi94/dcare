<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'categories';
    protected $fillable = ['name', 'color'];

    public function acts()
    {
        return $this->hasMany('App\Models\Acte', 'category_id');
    }
}
