<?php

namespace App;

use App\Expense;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $dates = ['date', 'expense_date'];

    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function bids()
    {
        return $this->hasMany('App\Bid');
    }

    public function expenseSplits()
    {
        return $this->hasManyThrough('App\ExpenseSplit', 'App\Expense');
    }
 
/*    public function checks()
    {
        return $this->hasManyThrough('App\Check', 'App\Expense');
        return $this->hasManyThrough(
            'App\Check', 'App\Expense',
            'vendor_id', 'check_id', 'id'
        );

    }*/

    public function getBizPhoneAttribute($value)
    {    
        if(isset($value)) {
            return "(".substr($value,0,3).") ".substr($value,3,3)."-".substr($value,6);    
        }
        return;                                         
    }

/*    public function getIdAttribute($id)
    {
        if(is_null($id)) {
            return 'NONE';
        }

        return;
    }*/

        //undo the above. Easier way somehow?
    public function getHomephonerraw()
    {
        $home = preg_replace('/[^0-9]/','',$this->home_phone);
        return $home;
    }
    //COMBIME both into one function and have a line break.
    public function getFulladdress1()
    {
    	if ($this->address_2 === null) {
    		return $this->address;
    	} else {
    		return $this->address . ', ' . $this->address_2;
    	}
    	
    }
    public function getFulladdress2()
    {
    	return $this->city . ', ' . $this->state . ' ' . $this->zip_code;
    }

    public function getName()
    {
        //delete. INC, DBA..and if it's too long
        $name = explode(",",$this->business_name);
        
        return $name[0];
    }

    public function getYTD()
    {
        $total = Expense::where('vendor_id', $this->id)->sum('amount');

        return $total;
    }
}
