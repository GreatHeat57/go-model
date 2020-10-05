<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExperiences extends Model
{
    protected $table = 'user_experiences';

    public $timestamps = true;

    protected $appends = ['from', 'to'];

    public function getFromAttribute() {
    	if($this->from_date !== ""){
			return $this->from_date;
    	}
    	return '0000-00-00';
	}

	public function getToAttribute() {
		if($this->up_to_date == 1){
			return  date('Y-m-d');
		}

		if($this->to_date !== ""){
			return $this->to_date;
		}

		return '0000-00-00';
	}

}
