<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class JobsTranslation extends BaseModel
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'jobs_translation';
	public $timestamps = false;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'job_id',
		'translation_lang',
		'title',
		'description'
	];
}
