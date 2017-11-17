<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use DB;

class Hour extends Model
{
	protected $dates = ['date'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function check()
    {
        return $this->belongsTo('App\Check','check', 'check_id');
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = new Carbon($date);
    }

    public function scopeSumHours($query, $user_id, $date)
    {
        return $query->where('user_id', $user_id)->where('date', $date)->sum('hours');     
    }

    public function scopeSumOfHours($query, $user_id, $date)
    {
        return $query->where('user_id', $user_id)->where('date', $date)->sum(DB::raw('hours * hourly'));     
    }

    public function scopeTimesheets($query)
    {
        return $query->groupBy('date')->groupBy('user_id')->latest('date');     
    }

    public function scopeUnpaidTimesheets($query)
    {
        return $query->timesheets()->where('check_id', '=', NULL);     
    }

    public function scopeLastHourly($query, $user_id)
    {
        return $query->where('user_id', '=', $user_id)->orderBy('id', 'desc');     
    }
        //undo the above. Easier way somehow?
    public function getFullname()
    {
        $fullname = $this->first_name . ' ' . $this->last_name;
        return $fullname;
    }

    public function getDate()
    {

        $date = Carbon::parse($this->date)->toFormattedDateString();
        return $date;
        // if Year is current, dont show, if it's past or future show
      /*  if(date('Y', $date == date('Y')))
        {
            return Carbon::parse($date)->toFormattedDateString();
        } else {
            return Carbon::parse($date)->format('m/d/y');
        }*/
      
    }


}
