<?php

namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointement extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['date_appointement', 'hour_appointement', 'remaining_days', 'waiting_time', 'is_delayed'];

    public function patient()
    {
        return $this->belongsTo('App\Models\Patient');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function assignedTo()
    {
        return $this->belongsTo('App\User', 'assign_to', 'id');
    }

    public function getDateAppointementAttribute()
    {
        $ed = new Carbon($this->end_date);
        $sd = new Carbon($this->start_date);
        $d = date("d/m/Y", strtotime($this->start_date));
        return $d . " | " . $sd->roundMinute()->format('H:i') . "-" . $ed->roundMinute()->format('H:i');
    }
    public function getHourAppointementAttribute()
    {
        $ed = new Carbon($this->end_date);
        $sd = new Carbon($this->start_date);
        return $sd->roundMinute()->format('H:i') . "-" . $ed->roundMinute()->format('H:i');
    }

    public function getIsDelayedAttribute()
    {
        return strtotime($this->end_date) - strtotime($this->state_modified_at) < 0 ? true : false;
    }

    /**
     * get remaining days from NOW
     */
    public function getRemainingDaysAttribute()
    {
        $start_date = new Carbon($this->start_date);

        $start_date->year(date('Y'));

        $remaining_days = Carbon::now()->diffInDays($start_date, false);

        return $remaining_days;
    }

    public function getWaitingTimeAttribute()
    {
        return "";
    }

    public function scopeWhenStartDateIs($query, $date)
    {
        return $query->whereDate('start_date', '=', $date);
    }
}
