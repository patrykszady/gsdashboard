<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Client extends Model

{
    protected $fillable = ['business_name', 'address', 'address_2', 'state', 'zip_code', 'city', 'note', 'home_phone'];
/*	protected $guarded = ['id', 'created_at', 'updated_at', 'user_id'];*/
	
    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function projects()
    {
        return $this->hasMany('App\Project');
    }

    public function getName()
    {
    	if ($this->business_name == null) {
    		
            return $this->getUsernames();
		    
    	} else {
    		return $this->business_name;
    	}
        
    }
    public function getUsernames()
    {
            $users = User::name($this->id)->get();

            //if 1 last name
            if ($users->count() == 1) { 
                $first_names = [];
                foreach ($this->users as $user)
                {
                    $first_names[] = $user->first_name;
                }

                return implode(' & ', $first_names) . ' ' . $this->users->first()->last_name;

            //if diff last names
            } else { 

                $names = [];
                foreach ($this->users as $user)
                {
                    $names[] = $user->first_name . ' ' . $user->last_name ;
                }

                return implode(' & ', $names);
            }
        
    }

    public function getLastnames()
    {
        if ($this->business_name == null) {
            
            $users = User::name($this->id)->get();

            //if 1 last name
            if ($users->count() == 1) { 

                return $this->users->first()->last_name;
                
            //if diff last names
            } else { 

                $names = [];
                foreach ($this->users as $user)
                {
                    $names[] = $user->last_name ;
                }

                return implode(' & ', $names);
            }
            
        } else {
            return $this->business_name;
        }
        
    }

    public function getHomePhoneAttribute($value)
    {    
        if(isset($value)) {
            return "(".substr($value,0,3).") ".substr($value,3,3)."-".substr($value,6);    
        }
        return;                                         
    }

        //undo the above. Easier way somehow?
    public function getHomephonerraw()
    {
        $home = preg_replace('/[^0-9]/','',$this->home_phone);
        return $home;
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
}
