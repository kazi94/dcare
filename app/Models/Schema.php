<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schema extends Model
{
	protected $fillable = ['patient_id', 'type', 'created_by'];

	public function lastQuotation()
	{
		return $this->hasOne('App\Models\Devis', 'schema_id', 'id')
			->where('devis.state', '=', 'devis')
			->latest()
			->limit(1);
	}
	public function quotations()
	{
		return $this->hasMany('App\Models\Devis', 'schema_id', 'id');
	}

	public function traitements()
	{
		return $this->belongsToMany('App\Models\Formule', 'traitements', 'schema_id', 'formule_id')
			//->withPivot('teeth')
			->withTimestamps();
	}
	/**
	 * Return the Patient where the schema is created for
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function createdTo()
	{
		return $this->belongsTo('App\Models\Patient', 'patient_id', 'id');
	}
}
