<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Patient extends Model
{
    use HasFactory;
    /**
     * Appends attributes to Model
     *
     * @var array
     */
    protected $appends = ['motivationFr'];

    /**
     * Restrict attributes for create or updates
     *
     * @var array
     */
    protected $guarded = [];

    //associate patient to pathologies
    public function pathologies()
    {
        return $this->BelongsToMany('App\Models\Pathologie');
    }

    //associate patient to antecedents
    public function antecedents()
    {
        return $this->BelongsToMany('App\Models\Antecedent');
    }
    public function createdBy()
    {
        return $this->belongsTo('\App\User', 'created_by', 'id');
    }
    public function plan()
    {
        return $this->hasOne('App\Models\Devis')->where('state', 'plan');
    }
    public function memo()
    {
        return $this->hasOne('App\Models\Memo');
    }
    public function quotations()
    {
        return $this->hasMany('App\Models\Devis')->where('state', 'devis');
    }
    public function hasPlan()
    {
        return $this->hasOne('App\Models\Devis')->where('state', 'plan');
    }
    public function radios()
    {
        return $this->hasMany('App\Models\Radio');
    }
    public function lastSchema()
    {
        return $this->hasOne('App\Models\Schema', 'patient_id', 'id')->latest()->limit(1);
    }
    public function initialSchema()
    {
        return $this->hasOne('App\Models\Schema', 'patient_id', 'id')->where('type', 'initial')->limit(1);
    }
    public function schemas()
    {
        return $this->hasMany('App\Models\Schema', 'patient_id', 'id');
    }
    public function prescriptions()
    {
        return $this->hasMany('App\Models\Prescription');
    }

    public function appointements()
    {
        return $this->hasMany('App\Models\Appointement')
            ->where('start_date', '>=', date('Y-m-d'))
            ->orderBy('start_date', 'asc');
    }
    public function appointementsHistory()
    {
        return $this->hasMany('App\Models\Appointement')
            ->where('start_date', '<', date('Y-m-d'))
            ->orderBy('start_date', 'desc');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Versement')->orderBy('paid_at', 'desc');
    }
    public function totalPaid()
    {
        return $this->hasOne('App\Models\Versement', 'patient_id', 'id')
            ->select('patient_id', DB::raw('SUM(total_paid) as value'))
            ->groupBy('patient_id');
    }
    public function totalPaids()
    {
        return $this->hasOne('App\Models\Versement', 'patient_id', 'id')
            ->select('patient_id', DB::raw('SUM(total_paid) as value'), DB::raw('paid_at as date_debt'))
            ->groupBy('patient_id', 'paid_at')
            ->orderBy('paid_at', 'desc');
    }

    //* GETTERS
    public function getMotivationFrAttribute()
    {
        if ($this->motivation == "less_motivate")
            return "Moyennement motivé";
        if ($this->motivation == "no_motivate")
            return "Non motivé";
        if ($this->motivation == "motivate")
            return "Motivé";
    }

    public function nom(): Attribute
    {
        return new Attribute(
            set: fn($value) => ucfirst($value),
        );
    }
    public function prenom(): Attribute
    {
        return new Attribute(
            set: fn($value) => ucfirst($value),
        );
    }


    // public function setFumeurAttribute($value)
    // {
    // 	$this->attributes['fumeur'] = $this->attributes['fumeur'] ? 'Oui' : 'Non';
    // }

    /**
     * Setting Age Attribute
     *
     * @param [Integer] $value
     * @return void
     */
    public function setAgeAttribute($value)
    {
        $this->attributes['age'] = $this->attributes['date_naissance'] ? intval(date('Y/m/d', strtotime("now"))) - intval(date('Y/m/d', strtotime($this->attributes['date_naissance']))) : '0';
    }

    public function scopeWhenDateOfCreation($query, $date)
    {
        return $query->whereDate('created_at', $date);
    }
}
