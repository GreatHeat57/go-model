<?php
// From Company's Form
$classLeftCol = 'col-sm-3';
$classRightCol = 'col-sm-9';

if (isset($originForm)) {
	// From User's Form
	if ($originForm == 'user') {
		$classLeftCol = 'col-md-3';
		$classRightCol = 'col-md-7';
	}
	
	// From Post's Form
	if ($originForm == 'post') 
	{
		$classLeftCol = 'col-md-3';
		$classRightCol = 'col-md-8';
	}
} else {
	// Required var
	$originForm = null;
}
?>
<div id="modelbookFields">
	
	@if ($originForm != 'message')
		
			<!-- name -->
			<div class="form-group <?php echo (isset($errors) and $errors->has('modelbook.name')) ? 'has-error' : ''; ?>">
				<!--label class="{{ $classLeftCol }} control-label" for="modelbook.name">{{ t('Name') }}</label-->
				<div class="{{ $classRightCol }}">
					<input type="hidden" name="modelbook[name]"
						   placeholder="{{ t('Name') }}"
						   class="form-control input-md" 
						   value="{{ old('modelbook.name', (isset($modelbook->name) ? $modelbook->name : '')) }}" style="display: none">
				</div>
			</div>
		
		
		<!-- filename -->
		<div class="form-group <?php echo (isset($errors) and $errors->has('modelbook.filename')) ? 'has-error' : ''; ?>">
			<label class="{{ $classLeftCol }} control-label" for="modelbook.filename"> {{ t('Select Your picture') }} </label>
			<div class="{{ $classRightCol }}">
				<div class="mb10">
					<input id="modelbookFilename" name="modelbook[filename]" type="file" class="file">
				</div>
				<p class="help-block">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
				@if (isset($modelbook))
					@if (!empty($modelbook) and !empty($modelbook->filename))
					<div>
						<img src="{{ \Storage::url('/album/'.$modelbook->filename) }}" height="100px" width="100px">
						
					</div>
					@endif
				@endif
			</div>
		</div>
	@else
		<!-- filename -->
		<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="form-group required <?php echo (isset($errors) and $errors->has('modelbook.filename')) ? 'has-error' : ''; ?>">
			<label for="modelbook.filename" class="control-label">{{ t('Model Book File') }} </label>
			<input id="modelbookFilename" name="modelbook[filename]" type="file" class="file">
			<p class="help-block">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('file')]) }}</p>
			@if (!empty($modelbook) and \Storage::exists($modelbook->filename))
				<div>
					<a class="btn btn-default" href="{{ \Storage::url($modelbook->filename) }}" target="_blank" download="Sedcard">
						<i class="icon-attach-2"></i> {{ t('Download current Model Book') }}
					</a>
				</div>
			@endif
		</div>
	@endif

</div>

@section('after_styles')
	@parent
	<style>
		#modelbookFields .select2-container {
			width: 100% !important;
		}
	</style>
@endsection

@section('after_scripts')
	@parent
	<script>
		/* Initialize with defaults (modelbook) */
		$('#modelbookFilename').fileinput(
		{
			language: '{{ config('app.locale') }}',
			@if (config('lang.direction') == 'rtl')
				rtl: true,
			@endif
			showPreview: false,
			allowedFileExtensions: {!! getUploadFileTypes('file', true) !!},
			showUpload: false,
			showRemove: false,
			maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }}
		});
	</script>
@endsection