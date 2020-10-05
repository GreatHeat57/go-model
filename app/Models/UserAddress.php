<?php

namespace App\Models;

use Larapen\Admin\app\Models\Crud;

class UserAddress extends BaseUser {
	use Crud;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'user_address';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var boolean
	 */
	public $timestamps = true;

	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'address_type',
		'first_name',
		'email',
		'phone',
		'address_line1',
		'address_line2',
		'post_code',
		'city',
		'country',
		'user_id',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = ['created_at', 'updated_at'];

	/*
		    |--------------------------------------------------------------------------
		    | FUNCTIONS
		    |--------------------------------------------------------------------------
	*/
	protected static function boot() {
		parent::boot();

		UserAddress::observe(AddressObserver::class);
	}

	/*
		    |--------------------------------------------------------------------------
		    | RELATIONS
		    |--------------------------------------------------------------------------
	*/

	public function user() {
		return $this->belongsToMany(User::class, 'user_id', 'id');
	}

	/*
		    |--------------------------------------------------------------------------
		    | SCOPES
		    |--------------------------------------------------------------------------
	*/

	/*
		    |--------------------------------------------------------------------------
		    | ACCESORS
		    |--------------------------------------------------------------------------
	*/
	public function getNameAttribute() {
		$value = null;

		if (isset($this->attributes) && isset($this->attributes['name'])) {
			$value = $this->attributes['name'];
		}

		if (empty($value)) {
			$value = last(explode('/', $this->attributes['logo']));
		}

		return $value;
	}

}
