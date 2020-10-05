<?php

namespace App\Models;

// use App\Models\Scopes\ActiveScope;
// use App\Models\Traits\TranslatedTrait;
// use App\Observer\PageObserver;
// use Cviebrock\EloquentSluggable\Sluggable;
// use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
// use Illuminate\Support\Facades\Storage;
// use Intervention\Image\Facades\Image;
// use Larapen\Admin\app\Models\Crud;
// use Prologue\Alerts\Facades\Alert;

class JobView extends BaseModel
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'job_views';
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'job_id',
		'ip_address',
		'date'
	];

	
}
