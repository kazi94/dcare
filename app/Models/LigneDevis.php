<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneDevis extends Model
{
    public $table = "lignedevis";

    protected $fillable = ['devis_id', 'acte_id', 'num_dent', 'state', 'accepted_state', 'price', 'created_at', 'updated_at', 'lock'];

    protected $appends = ['date_done', 'teeth', 'accepted_state_title'];

    public function act()
    {
        return $this->hasOne('App\Models\Acte', 'id', 'acte_id');
    }

    public function devis()
    {
        return $this->belongsTo("\App\Models\Devis", "devis_id", "id");
    }

    public function getDateDoneAttribute()
    {
        return date("d/m/Y", strtotime($this->updated_at));
    }



    public function getNumDentAttribute($val)
    {
        // if ($val == "all")
        //     return "Bouche";
        // if ($val == "s1" || $val == "s2" || $val == "s3" || $val == "s4")
        //     return "Secteur 0" . substr($val, 1);
        // return $val;

        switch (strval($val)) {
            case '11,12,13,14,15,16,17,18,21,22,23,24,25,26,27,28,41,42,43,44,45,46,47,48,31,32,33,34,35,36,37,38':
                return "Bouche";
            case '11, 12, 13, 14, 15, 16, 17, 18':
                return "Secteur 01";
            case '21, 22, 23, 24, 25, 26, 27, 28':
                return "Secteur 02";
            case '41, 42, 43, 44, 45, 46, 47, 48':
                return "Secteur 03";
            case '31, 32, 33, 34, 35, 36, 37, 38':
                return "Secteur 04";
            default:
                return $val;
        }
    }

    public function getTeethAttribute()
    {
        return
            strval($this->getOriginal('num_dent'));
    }

    public function getAcceptedStateTitleAttribute()
    {
        return $this->accepted_state ? "Accepter" : "Rejeter";
    }

    public function getActeAttribute()
    {
        return $this->act()->nom;
    }
}
