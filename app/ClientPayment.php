<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
	protected $fillable = ['project_id', 'check_id', 'note', 'amount', 'date'];

	protected $dates = ['date'];
    
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
