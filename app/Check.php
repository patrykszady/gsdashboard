<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Vendor;
Use App\User;

class Check extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];
	protected $dates = ['date', 'expense_date'];
    
    public function getRouteKeyName()
    {
        return 'check';
    }
	
    public function expenses()
    {
        return $this->hasMany('App\Expense','check_id', 'check');
    }

    public function hours()
    {
        return $this->hasMany('App\Hour', 'check_id', 'check');
    }

    public function getDate()
    {
        $date = Carbon::parse($this->date)->toFormattedDateString();
        return $date;     
    }

    public function getPayee()
    {
        if($this->hours->count() > 0) {
            $payee = $this->hours->first()->user->id;
            $user = User::findOrFail($payee);

        } elseif($this->expenses->count() > 0 and $this->expenses->last()->paid_by == 0) {  //paid by 0
            $payee = $this->expenses->last()->vendor->id;
            $user = Vendor::findOrFail($payee);

 
        } elseif ($this->expenses->count() > 0 and $this->expenses->first()->paid_by > 0){
            
            $user = User::findOrFail($this->expenses->first()->paid_by);
        }

        return $user;

    }

    public function getName()
    {
        if(isset($this->getPayee()->first_name)) {
            $payee = $this->getPayee()->first_name;
        } else {
            $payee = $this->getPayee()->business_name;
        }

        return $payee;
    }

    public function getTotal($vendor)
    {
        if(isset($vendor)){
            $total = $this->expenses->where('vendor_id', $vendor->id)->sum('amount'); 
        } else {
            $total = $this->expenses->sum('amount') + $this->hours->sum('amount'); 
        }
        
        $total = (floor($total) == $total) ? number_format($total,0, '.', ',') : number_format($total,2, '.', ',');

        return '$' .  $total;      
    }
}
