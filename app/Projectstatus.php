<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projectstatus extends Model
{
	protected $fillable = ['title', 'title_id', 'project_id'];
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    
}
