<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acte extends Model
{
    use HasFactory;
    public $timestamps = false;


    public $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function coords()
    {
        return $this->belongsToMany('App\Models\Formule', 'acte_formule', 'acte_id', 'formule_id')->withPivot('color');
    }

    public function formes()
    {
        return $this->belongsToMany('App\Models\Formule', 'acte_formule', 'acte_id', 'formule_id')->select('formulas', 'coord')->where('teeth', '12')->withPivot('color');
    }

    public function videos()
    {
        return $this->hasMany('App\Models\VideoDemo', 'act_id', 'id');
    }
}
