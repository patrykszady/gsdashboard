<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptAccount extends Model
{
	protected $fillable = ['company_email_id', 'vendor_id', 'project_id'];
    public function receipt()
    {
        return $this->belongsTo('App\Receipt');
    }

    public function companyEmail()
    {
        return $this->belongsTo('App\CompanyEmail');
    }

    public function scopeEmployees($query)
    {
        return $query->whereIn('created_by_user_id', User::employees()->get()->pluck('id'));     
    }
}
