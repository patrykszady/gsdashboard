<?php

namespace App;

use App\Expense;
use App\Project;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $dates = ['date', 'expense_date'];
    protected $guarded = ['id', 'created_at', 'updated_at'];

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

    public function projects()
    {
        return $this->belongsToMany('App\Project', 'expenses');
    }

    public function receipts()
    {
        return $this->hasMany('App\Receipt');
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
    
    public function getHomephonerraw()
    {
        $home = preg_replace('/[^0-9]/','',$this->home_phone);
        return $home;
    }
    public function getFulladdress()
    {
        if ($this->address_2 === null) {
            $address1 = $this->address;
        } else {
            $address1 = $this->address . ', ' . $this->address_2;
        }
            $address2 = $this->city . ', ' . $this->state . ' ' . $this->zip_code;

            return $address1 . '<br>' .  $address2;
    }

    public function getName()
    {
        //delete. INC, DBA..and if it's too long
        $name = explode(",",$this->business_name);
        
        return $name[0];
    }

    public function getYTD()
    {
        $total = $this->expenses->sum('amount');

        return $total;
    }
    public function getBalance()
    {
  /*      $expenses = $this->expenses()->sum('amount');
        $bids = $this->bids->sum('amount');
        $total = $bids - $expenses;
        $total = $expenses;*/
        
        if($this->biz_type == 1){
            $total = 0;
            /*foreach($this->projects()->distinct()->get() as $project){*/
                foreach(Project::all() as $project){
                $balance = $project->getBidbalance($this);
                if($balance > 0){
                    $total += $project->getVendorBid($this) - $project->getTotal($this);   
                } 
            }  
        }else{
            $total = 0;
        }
        
     
/*        
        if($this->biz_type == 1){
            $total = 0;
            foreach($this->projects()->get() as $project){
                $balance = $project->getBidbalance($this);
                if($balance > 0){
                    $total += $balance;    
                }   
            }  
        }else{
            $total = 0;
        }
        */
        return $total;
    }
}
