<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Devis extends Model
{
    use HasFactory;
    public $table = "devis";

    protected $guarded = [];

    protected $appends = ['date_devis', 'debit', 'total'];

    public function lines()
    {
        return $this->hasMany('App\Models\LigneDevis', 'devis_id')->whereIn('state', ['En cours', 'A faire', 'fait'])->orderBy('state', 'desc');
    }
    /**
     * Get the comments for the blog post.
     */
    public function replicateRow()
    {
        $clone = $this->replicate();
        $clone->push();
        foreach ($this->lines as $line) {
            $clone->lines()->create($line->toArray());
        }
        $clone->save();

        return $clone;
    }
    public function linesInProgress()
    {
        return $this->hasMany('App\Models\LigneDevis', 'devis_id')->whereState('En cours')->orWhereState('A faire');
    }
    public function linesDone()
    {
        return $this->hasMany('App\Models\LigneDevis', 'devis_id')->whereState('fait');
    }
    public function lineAccepted()
    {
        return $this->hasOne('App\Models\LigneDevis', 'devis_id')->whereAcceptedState('1');
    }
    public function payments()
    {
        return $this->hasMany('App\Models\Versement', 'devis_id', 'id');
    }

    public function crediteur()
    {
        return $this->hasOne('App\Models\Versement', 'devis_id', 'id')
            ->select('devis_id', DB::raw('SUM(total_paid) as crediteur'))
            ->groupBy('devis_id');
    }
    public function totalDone()
    {
        return $this->hasOne('App\Models\LigneDevis', 'devis_id', 'id')
            ->whereState('fait')
            ->select('devis_id', DB::raw('SUM(price) as value'))
            ->groupBy('devis_id');
    }
    public function lastPayment()
    {
        $result = $this->hasOne('App\Models\Versement')
            ->select('paid_at')
            ->latest('paid_at')
            ->limit(1);

        return $result;
    }

    public function getDateDevisAttribute()
    {
        return date("d/m/Y", strtotime($this->created_at));
    }

    /**
     * Calculate Debit of Quotation
     *
     *
     *
     * @param
     * @return
     **/
    public function getDebitAttribute($value)
    {
        if ($this->crediteur)
            return $this->total_accept - $this->crediteur->crediteur;
        else
            return null;
    }

    public function getTotalAttribute()
    {
        $total = 0;
        $lines = $this->lines;

        foreach ($lines as $line) {
            $total += $line->price;
        }
        return $total;
    }
}
