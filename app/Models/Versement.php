<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Versement extends Model
{

	public $timestamps =  false;

	// protected $fillable = ['patient_id', 'total_paid', 'paid_by', 'paid_at'];

	protected $guarded = [];

	public function lignes()
	{
		return $this->hasMany('App\Models\LigneDevis', 'devis_id');
	}
	/**
	 * returns the user who validated the payment
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function validatedPaymentBy()
	{
		return $this->belongsTo('App\User', 'paid_by', 'id');
	}
	/**
	 * Return the Patient where the quote is created for
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function createdTo()
	{
		return $this->belongsTo('App\Models\Patient', 'patient_id', 'id');
	}

	public function getPaidAtAttribute($val)
	{
		return date("Y-m-d", strtotime($val));
	}



	public function updatesLog()
	{
		return $this->hasMany('App\Models\VersementsLog');
	}
}
