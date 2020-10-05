<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class States extends Model
{	
	public $timestamps = false;
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'states';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['country_code', 'state_name', 'time_zone_id'];

	/*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function timeZone()
    {
        return $this->belongsTo(TimeZone::class, 'time_zone_id', 'id');
    }
}
