<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Vendor;
Use App\User;

class Check extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
	protected $dates = ['date', 'expense_date', 'deleted_at'];
    
/*    public function getRouteKeyName()
    {
        return 'check';
    }
	*/
    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }

    public function hours()
    {
        return $this->hasMany('App\Hour');
    }

    public function getDate()
    {
        $date = Carbon::parse($this->date)->toFormattedDateString();
        return $date;     
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = new Carbon($date);
    }

    public function getPayee()
    {
        if($this->hours->where('invoice', '!=', NULL)->count() > 0){
            $payee = $this->hours->where('invoice', '!=', NULL)->first()->paid_by;
            $user = User::findOrFail($payee);
        } elseif($this->hours->count() > 0) {
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

    public function getPayeeRoute()
    {
        if(isset($this->getPayee()->first_name)){
            $route = route('users.show', $this->getPayee()->id);
        } elseif(isset($this->getPayee()->business_name)) {
            $route = route('vendors.show', $this->getPayee()->id);
        }

        return $route;
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

    public function getTotal($vendor = NULL)
    {
        if(!empty($vendor)){
            $total = $this->expenses->where('vendor_id', $vendor->id)->sum('amount'); 
        } else {
            $total = $this->expenses->sum('amount') + $this->hours->sum('amount'); 
        }

        return $total;      
    }

    public function getCreatedBy()
    {
        $created_by = User::findOrFail($this->created_by_user_id)->first_name;
        return $created_by;      
    }
}
