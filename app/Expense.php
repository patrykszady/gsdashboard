<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;
use App\Vendor;
use App\Project;
use App\ExpenseSplit;
use App\Distribution;
use App\User;

use Carbon\Carbon;

class Expense extends Model
{
    
    protected $guarded = ['id', 'created_at', 'updated_at', 'user_id', 'another', 'done', 'split', 'update'];

    protected $dates = ['expense_date', 'date'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }

    public function distribution()
    {
        return $this->belongsTo('App\Distribution');
    }

    public function check()
    {
        return $this->belongsTo('App\Check', 'check', 'check_id');
    }
/*    public function splitExpenses()
    {
        return $this->hasMany('App\Expense', 'parent_expense_id', 'id')->where('parent_expense_id', $this->id);
    }*/

    public function expense_splits()
    {
        return $this->hasMany('App\ExpenseSplit');
    }

    public function scopeDuplicate($query, $request)
    {
        return $query->
            where('expense_date', Carbon::parse($request->expense_date)->toDateString())->
            where('amount', $request->amount)->where('project_id', $request->project_id)->
            where('vendor_id', $request->vendor_id);     
    }

    public function scopeNotSplitNoProject($query)
    {
        return $query->  
            where('project_id', 0)->where('distribution_id', NULL)->
            doesntHave('expense_splits')->
            orderBy('amount');
    }

    public function scopeExpenseWithSplits($query)
    {
        $splits = ExpenseSplit::with('expense')->get();
        $expenses = Expense::where('distribution_id', '!=', NULL)->orWhere('project_id', '!=', 0)->get();
        return $expenses->merge($splits);
    }
    public function setExpenseDateAttribute($date)
    {
    	$this->attributes['expense_date'] = new Carbon($date);
    }

    // public function getExpenseDateAttribute($date)
    // {

    // }
    public function getDate()
    {
        $date = Carbon::parse($this->expense_date)->toFormattedDateString();
        return $date;
        // if Year is current, dont show, if it's past or future show
      /*  if(date('Y', $date == date('Y')))
        {
            return Carbon::parse($date)->toFormattedDateString();
        } else {
            return Carbon::parse($date)->format('m/d/y');
        }*/  
    }
/*
    public function getAmount()
    {      
        return $this->getAmountFormatted($this->amount); 
    }*/

/*    public function getAmountFormatted($amount)
    {      
        $total = (floor($amount) == $amount) ? number_format($amount,0, '.', ',') : number_format($amount,2, '.', ',');
        return '$' .  $total; 
    }*/

    public function getPaidBy()
    {
        if($this->paid_by === "0") {
            $paid_by = Vendor::findOrFail(User::findOrFail($this->created_by_user_id)->primary_vendor)->getName();
        }elseif(is_numeric($this->paid_by)){
            $paid_by = User::findOrFail($this->paid_by)->first_name;
        }else {
            $paid_by = Vendor::findOrFail(preg_replace("/[^0-9]/","",$this->paid_by))->business_name; 
        }

        return $paid_by;      
    }
    public function getReceipt()
    {
        $receipt = $this->receipt;

        return $receipt;      
    }
    public function getReimbursment()
    {       
        if($this->reimbursment == "0") {
            $reimbursment = '';
        } elseif($this->reimbursment == "Client") {
            $reimbursment = 'Client';
        } else {
            $reimbursment = Vendor::findOrFail($this->reimbursment)->getName();
        }

        return $reimbursment;      
    }

    public function getCreatedBy()
    {
        $created_by = User::findOrFail($this->created_by_user_id)->first_name;
        return $created_by;      
    }
    
    public function getId()
    {
        $id = $this->id;
        return $id;
        // if Year is current, dont show, if it's past or future show
      /*  if(date('Y', $date == date('Y')))
        {
            return Carbon::parse($date)->toFormattedDateString();
        } else {
            return Carbon::parse($date)->format('m/d/y');
        }*/  
    }

}
