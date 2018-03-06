<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

      

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'phone_number', 'client_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function vendors()
    {
        return $this->belongsToMany('App\Vendor');
    }

    public function hours()
    {
        return $this->hasMany('App\Hour');
    }

    public function scopeName($query, $client_id) 
    {
        return $query->where('client_id', $client_id)->groupBy('last_name');
    }

    public function scopeExcludeEmployees($query, $vendor)
    {
        return $query->whereNotIn('id', $vendor->users()->pluck('user_id'));
    }

    public function scopeEmployees($query)
    {
        $vendor = Vendor::findOrFail(Auth::user()->primary_vendor);
        return $query->whereIn('id', $vendor->users()->pluck('user_id'));       
    }

    public function getFullname()
    {
        $fullname = $this->first_name . ' ' . $this->last_name;
        return $fullname;
    }

    public function getPhoneNumberAttribute($value)
    {    
        if(isset($value)) {
            return "(".substr($value,0,3).") ".substr($value,3,3)."-".substr($value,6);    
        }
        return;                                         
    }

/*    public setPhoneNumberAttribute*/

    //undo the above. Easier way somehow?
    public function getCellnumberraw()
    {
        $cell = preg_replace('/[^0-9]/','',$this->phone_number);
        return $cell;
    }

    public function getEmployeeBalance()
    {
        $expenses = Expense::where('paid_by', $this->id)->where('check_id', null)->sum('amount');
        $hours = Hour::where('user_id', $this->id)->where('check_id', null)->where('invoice', null)->sum('amount');
        $total = $expenses + $hours; 

        $total = (floor($total) == $total) ? number_format($total,0, '.', ',') : number_format($total,2, '.', ',');

        return '$' .  $total;   
    }

}


   
