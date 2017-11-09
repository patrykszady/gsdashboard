<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Scout\Searchable;

class Project extends Model
{
/*    protected $fillable = ['project_name', 'client_id', 'source', 'project_total'];*/

    
    protected $guarded = ['id', 'created_at', 'updated_at', 'user_id'];
  	
  	public function hours()
    {
        return $this->hasMany('App\Hour');
    }

    public function expenses()
    {
        return $this->hasMany('App\Expense');
    }

    public function expenseSplits()
    {
        return $this->hasMany('App\ExpenseSplit');
    }

    public function clientPayments()
    {
        return $this->hasMany('App\clientPayment');
    }

    public function bids()
    {
        return $this->hasMany('App\Bid');
    }

    public function projectstatuses()
    {
        return $this->hasMany('App\Projectstatus');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function distributions()
    {
        return $this->belongsToMany('App\Distribution')->withPivot('percent', 'created_by_user_id')->withTimestamps();
    }

    public function scopeIsActive($query){
        //whereNotIn, pass in 1,2,3,4
        return $query->with('latestStatus')->orderBy('created_at', 'asc')->get()->where('latestStatus.title_id', 5);
    }

    public function scopeReimbursment($query){
        //whereNotIn, pass in 1,2,3,4
        return $query->with('expenses')->where('reimbursment', 'Client');
    }

    public function scopeNotActive($query){
        //whereNotIn, pass in 1,2,3,4
        return $query->with('latestStatus')->get()->where('latestStatus.title_id', '!=', 5);
    }

    public function scopeIsCompletee($query){
        return $query->with('latestStatus')->get()->where('latestStatus.title_id', 6);
    }

    public function latestStatus(){
        return $this->hasOne('App\Projectstatus')->latest(); //->first()->title_id
    }

    public function isComplete(){
        return $this->projectstatuses()->where('title_id', 6)->first();
    }

    public function getProjectname()
    {
        if ($this->client->business_name == null) {
            $projectname = $this->client->getLastnames() . ' - ' . $this->project_name;
        } else {
            $projectname = $this->project_name;
        }
        return $projectname;
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

    public function getBid($vendor)
    {
        $total = $this->bids->where('vendor_id', $vendor->id)->sum('amount');        
       
        $total = (floor($total) == $total) ? number_format($total,0, '.', ',') : number_format($total,2, '.', ',');

        return '$' .  $total;      
    }

    public function getBidbalance($vendor)
    {
        
        $total = $this->bids->where('vendor_id', $vendor->id)->sum('amount') - Expense::where('project_id', $this->id)->where('vendor_id', $vendor->id)->sum('amount');
          
      
        $total = (floor($total) == $total) ? number_format($total,0, '.', ',') : number_format($total,2, '.', ',');

        return '$' . $total;      
    }

    public function getTotal($vendor)
    {
        $total = $this->expenses->where('vendor_id', $vendor->id)->sum('amount');        
   
        $total = (floor($total) == $total) ? number_format($total,0, '.', ',') : number_format($total,2, '.', ',');

        return '$' .  $total;      
    }

    public function getVendortotal($vendor)
    {

     /*   dd($this->expenses()->has('expense_splits')->get());*/
     /*   dd($this->expenseSplits()->with('expense')->where('expense.vendor_id', $vendor)->get());*/
        $total = $this->expenses()->where('vendor_id', $vendor)->sum('amount'); /*+ 


                $this->expenseSplits()->with('expense')->where('expenses.vendor_id', $vendor)->sum('amount');*/
      
        $percent = ($total / $this->getProjectTotal()) * 100;
        $total = (floor($total) == $total) ? number_format($total,0, '.', ',') : number_format($total,2, '.', ',');
        $percent = (floor($percent) == $percent) ? number_format($percent,0, '.', ',') : number_format($percent,2, '.', ',');
        return '$' .  $total . ' | ' . $percent . '%';      
    }

    public function getTotalCost()
    {
        $total = $this->hours->sum('amount') + $this->expenses->sum('amount') + $this->expenseSplits->sum('amount');
        return $total;
    }

    public function getProfit()
    {
        $total = $this->getProjectTotal() - $this->getTotalCost();
        return $total;  
    }

    public function getProjectTotal()
    {
        $total = $this->getReimbursment() + $this->project_total + $this->change_order;
        return  $total;  
    }

    public function getReimbursment()
    {
        $total = 
            $this->expenses->where('reimbursment', 'Client')->sum('amount') + 
            $this->expenseSplits->where('reimbursment', 'Client')->sum('amount');
        return  $total;  
    }

    public function getProjectTotalFormat()
    {
        $total = $this->getProjectTotal();
        return  $total;  
    }

    public function getDistBalance($dist)
    {
        $total = $this->getProfit() * ($dist->pivot->percent * .01);
        return $total;
    }

}
