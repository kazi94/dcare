<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class Traitement extends Pivot
{
    protected $fillable = ['num_dent', 'formules', 'created_by', 'schema_id'];

    public $table = 'traitements';
    // public function generalCoords() {
    //     return $this->hasMany('App\Models\Formule' , 'teeth' , 'num_dent');

    // }
    // public function coords(){
    //     return $this->generalCoords()->where('formulas' ,$this->formules);
    // }

    public function formulas()
    {
        return $this->hasMany('App\Models\Formule',  'id', 'formule_id');
    }
}
