<?php

namespace App;

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
}
