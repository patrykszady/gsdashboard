<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
	protected $guarded = ['id', 'created_at', 'updated_at'];
	
	public function projects()
    {
        return $this->belongsToMany('App\Project')->withPivot('percent', 'created_by_user_id')->withTimestamps();
    }
    
    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }
    
    public function expenseSplits()
    {
        return $this->hasMany('App\ExpenseSplits');
    }

    public function getBalance()
    {
        $total = 0;
        foreach ($this->projects as $project){
            $total += Project::findOrFail($project->pivot->project_id)->getProfit() * ($project->pivot->percent * .01);
        }

        $total = $total - $this->getDistPaid();
        return $total;
    }

    public function getDistPaid()
    {
        $total = Expense::where('distribution_id', $this->id)->sum('amount');

        return $total;
    }
/*

	public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value; 
    }
    	*/
    
}
