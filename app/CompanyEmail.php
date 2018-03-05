<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyEmail extends Model
{
    public function receipt_accounts()
    {
        return $this->hasMany('App\ReceiptAccount');
    }
}
