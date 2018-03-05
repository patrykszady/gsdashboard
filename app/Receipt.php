<?php

namespace App;

use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $guarded = ['id'];

    public function receiptAccounts()
    {
        return $this->hasMany('App\ReceiptAccount');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Vendor');
    }

    public function scopeAvaliableAccounts($query)
    {
        return $query->  
			whereDoesntHave('receiptAccounts', function ($where_query) {
    			$where_query->whereIn('company_email_id', CompanyEmail::where('vendor_id', Auth::user()->primary_vendor)->get()->pluck('id')); //Auth:user ->primary vendor ->company_emails
		});
    }

    public function scopeActiveAccounts($query)
    {
        return $query->
			whereHas('receiptAccounts', function ($where_query) {
    			$where_query->whereIn('company_email_id', CompanyEmail::where('vendor_id', Auth::user()->primary_vendor)->get()->pluck('id')); //Auth:user ->primary vendor ->company_emails
		});
    }

}
