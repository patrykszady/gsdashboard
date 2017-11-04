<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Bid extends Model
{
	protected $fillable = ['note', 'vendor_id', 'project_id', 'amount'];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }

	public function getDate()
    {
        $date = Carbon::parse($this->created_at)->toFormattedDateString();
        return $date;
    }

    public function getTotal()
    {
        $total = $this->amount;        
      
        $total = (floor($total) == $total) ? number_format($total,0, '.', ',') : number_format($total,2, '.', ',');

        return '$' .  $total;      
    }

    public function getTotal2()
    {
        $total = $this->sum('amount');        
        dd($total);
        $total = (floor($total) == $total) ? number_format($total,0, '.', ',') : number_format($total,2, '.', ',');

        return '$' .  $total;      
    }

    public function getBalance()
    {
        
        $total = $this->amount - Expense::where('project_id', $this->project_id)->where('vendor_id', $this->vendor_id)->sum('amount');
          
  /*    
        $total = (floor($total) == $total) ? number_format($total,0, '.', ',') : number_format($total,2, '.', ',');
*/
        return $total;      
    }
}
