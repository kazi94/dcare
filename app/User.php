<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasFactory;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'color'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['doctor'];

    // public function role () {

    //     return $this->BelongsTo('App\Models\Role');

    // }

    public function cabinet()
    {
        return $this->belongsTo('App\Models\Cabinet');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    public function getDoctorAttribute()
    {
        return "Dr." . $this->name . " " . $this->prenom;
    }
}
