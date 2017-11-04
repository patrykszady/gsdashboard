<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Expense;
use App\Vendor;

use Carbon\Carbon;

class ExpenseSplit extends Model
{
	protected $guarded = ['id', 'created_at', 'updated_at'];

    public function expense()
    {
        return $this->belongsTo('App\Expense');
    }

    public function distribution()
    {
        return $this->belongsTo('App\Distribution');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function vendor()
    {
        return $this->expense->belongsTo('App\Vendor');
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

    public function getReceiptAttribute($receipt)
    {
        $receipt = $this->expense->receipt;
        return $receipt;      
    }

    public function getReceiptHtmlAttribute($receipt)
    {
        $receipt = $this->expense->receipt_html;
        return $receipt;      
    }


    public function getAmount()
    {
        $amount = $this->getAmountFormatted($this->amount);
        return $amount;
    }
    
    public function getAmountFormatted($amount)
    {      
        $total = (floor($amount) == $amount) ? number_format($amount,0, '.', ',') : number_format($amount,2, '.', ',');
        return '$' .  $total; 
    }


    public function getDate()
    {
        return $this->expense->getDate();     
    }

    public function getExpenseDateAttribute($date)
    {
        $date = $this->expense->expense_date;
        return $date;
        // if Year is current, dont show, if it's past or future show
      /*  if(date('Y', $date == date('Y')))
        {
            return Carbon::parse($date)->toFormattedDateString();
        } else {
            return Carbon::parse($date)->format('m/d/y');
        }*/  
    }
    public function getId()
    {
        $id = $this->expense->id;
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
