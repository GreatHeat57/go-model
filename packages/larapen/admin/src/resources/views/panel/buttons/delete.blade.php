@if (
		(
			$xPanel->hasAccess('delete') &&
			/* Security for SuperAdmin */
			!\Illuminate\Support\Str::contains(\Illuminate\Support\Facades\Route::currentRouteAction(), 'UserController')
		)
		or
		(
			/* Security for SuperAdmin */
			$xPanel->hasAccess('delete') &&
			\Illuminate\Support\Str::contains(\Illuminate\Support\Facades\Route::currentRouteAction(), 'UserController') && $entry->id != 1
		)
   )
	<a href="{{ url($xPanel->route.'/'.$entry->getKey()) }}" class="btn btn-xs btn-default" data-button-type="delete">
        <i class="fa fa-trash"></i>
		{{ trans('admin::messages.delete') }}
	</a>
@endif