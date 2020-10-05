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
	if ($originForm == 'post') {
		$classLeftCol = 'col-md-3';
		$classRightCol = 'col-md-8';
	}
} else {
	// Required var
	$originForm = null;
}
?>
<div id="sedcardFields">

	@if ($originForm != 'message')
		@if (isset($sedcard) and !empty($sedcard))
			<!-- name -->
			<div class="form-group <?php echo (isset($errors) and $errors->has('sedcard.name')) ? 'has-error' : ''; ?>">
				<label class="{{ $classLeftCol }} control-label" for="sedcard.name">{{ t('Name') }}</label>
				<div class="{{ $classRightCol }}">
					<input name="sedcard[name]"
						   placeholder="{{ t('Name') }}"
						   class="form-control input-md"
						   type="text"
						   value="{{ old('sedcard.name', (isset($sedcard->name) ? $sedcard->name : '')) }}">
				</div>
			</div>
		@endif

		<!-- filename -->
		<div class="form-group <?php echo (isset($errors) and $errors->has('sedcard.filename')) ? 'has-error' : ''; ?>">
			<label class="{{ $classLeftCol }} control-label" for="sedcard.filename"> {{ t('Your sedcard') }} </label>
			<div class="{{ $classRightCol }}">
				<div class="mb10">
					<input id="sedcardFilename" name="sedcard[filename]" type="file" class="file">
				</div>
				<p class="help-block">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('image')]) }}</p>
				@if (isset($sedcard))
					@if (!empty($sedcard) and !empty($sedcard->filename) and \Storage::exists($sedcard->filename))
					<div>
						<img src="{{ \Storage::url($sedcard->filename) }}" height="100px" width="100px">
						<a class="btn btn-default" href="{{ \Storage::url($sedcard->filename) }}" target="_blank">
							<i class="icon-attach-2"></i> {{ t('Download current Sedcard') }}
						</a>
					</div>
					@endif
				@endif
			</div>
		</div>
	@else
		<!-- filename -->
		<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="form-group required <?php echo (isset($errors) and $errors->has('sedcard.filename')) ? 'has-error' : ''; ?>">
			<label for="sedcard.filename" class="control-label">{{ t('Sedcard File') }} </label>
			<input id="sedcardFilename" name="sedcard[filename]" type="file" class="file">
			<p class="help-block">{{ t('File types: :file_types', ['file_types' => showValidFileTypes('file')]) }}</p>
			@if (!empty($sedcard) and \Storage::exists($sedcard->filename))
				<div>
					<a class="btn btn-default" href="{{ \Storage::url($sedcard->filename) }}" target="_blank">
						<i class="icon-attach-2"></i> {{ t('Download current Sedcard') }}
					</a>
				</div>
			@endif
		</div>
	@endif

</div>

@section('after_styles')
	@parent
	<style>
		#sedcardFields .select2-container {
			width: 100% !important;
		}
	</style>
@endsection

@section('after_scripts')
	@parent
	<script>
		/* Initialize with defaults (sedcard) */
		$('#sedcardFilename').fileinput(
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