<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{	
	public $timestamps = false;
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'api_log';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'time',
		'wpusername',
		'action',
		'request',
		'reaponse'
	];
}
