<div class="modal fade" id="applyJob" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">{{ t('Close') }}</span>
				</button>
				<h4 class="modal-title"><i class=" icon-mail-2"></i> {{ t('Contact Employer') }} </h4>
			</div>
			<form role="form" method="POST" action="{{ lurl('posts/' . $post->id . '/contact') }}" enctype="multipart/form-data">
				{!! csrf_field() !!}
				<div class="modal-body">

					@if (isset($errors) and $errors->any() and old('messageForm')=='1')
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					@if (auth()->check())
						<input type="hidden" name="name" value="{{ auth()->user()->name }}">
						@if (!empty(auth()->user()->email))
							<input type="hidden" name="email" value="{{ auth()->user()->email }}">
						@else
							<!-- email -->
							<div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
								<label for="email" class="control-label">{{ t('E-mail') }}
									@if (!isEnabledField('phone'))
										<sup>*</sup>
									@endif
								</label>
								<div class="input-group">
									<span class="input-group-addon"><i class="icon-mail"></i></span>
									<input id="email" name="email" type="text" placeholder="{{ t('i e you@gmail') }}"
										   class="form-control" value="{{ old('email', auth()->user()->email) }}">
								</div>
							</div>
						@endif
					@else
						<!-- name -->
						<div class="form-group required <?php echo (isset($errors) and $errors->has('name')) ? 'has-error' : ''; ?>">
							<label for="name" class="control-label">{{ t('Name') }} <sup>*</sup></label>
							<input id="name" name="name" class="form-control" placeholder="{{ t('Your name') }}" type="text"
								   value="{{ old('name') }}">
						</div>
							
						<!-- email -->
						<div class="form-group required <?php echo (isset($errors) and $errors->has('email')) ? 'has-error' : ''; ?>">
							<label for="email" class="control-label">{{ t('E-mail') }}
								@if (!isEnabledField('phone'))
									<sup>*</sup>
								@endif
							</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="icon-mail"></i></span>
								<input id="email" name="email" type="text" placeholder="{{ t('i e you@gmail') }}"
									   class="form-control" value="{{ old('email') }}">
							</div>
						</div>
					@endif
					
					<!-- phone -->
					<div class="form-group required <?php echo (isset($errors) and $errors->has('phone')) ? 'has-error' : ''; ?>">
						<label for="phone" class="control-label">{{ t('Phone Number') }}
							@if (!isEnabledField('email'))
								<sup>*</sup>
							@endif
						</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="icon-phone-1"></i></span>
							<input id="phone" name="phone" type="text"
								   placeholder="{{ t('Phone Number') }}"
								   maxlength="60" class="form-control" value="{{ old('phone', (auth()->check()) ? auth()->user()->phone : '') }}">
						</div>
					</div>
					
					<!-- message -->
					<div class="form-group required <?php echo (isset($errors) and $errors->has('message')) ? 'has-error' : ''; ?>">
						<label for="message" class="control-label">{{ t('Message') }} <span class="text-count">(500 max)</span> <sup>*</sup></label>
						<textarea id="message" name="message" class="form-control required" placeholder="{{ t('Your message here') }}" rows="5">{{ old('message') }}</textarea>
					</div>

					<a id="add_line">+ {{ t('Add new picture') }}</a>
					
					<!-- recaptcha -->
					@if (config('settings.security.recaptcha_activation'))
						<div class="form-group required <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>">
							<label class="control-label" for="g-recaptcha-response">{{ t('We do not like robots') }}</label>
							<div>
								{!! Captcha::display($attributes = [], $options = ['lang' => config('lang.locale')]) !!}
							</div>
						</div>
					@endif
					
					<input type="hidden" name="country" value="{{ $post->country_code }}">
					<input type="hidden" name="post" value="{{ $post->id }}">
					<input type="hidden" name="messageForm" value="1">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ t('Cancel') }}</button>
					<button type="submit" class="btn btn-success pull-right">{{ t('Send message') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>
@section('after_styles')
	@parent
	<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	<style>
		.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
	</style>
@endsection

@section('after_scripts')
	@parent
	
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	@if (file_exists(public_path() . '/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js'))
		<script src="{{ url(config('app.cloud_url').'/assets/plugins/bootstrap-fileinput/js/locales/'.config('app.locale').'.js') }}" type="text/javascript"></script>
	@endif
	<script>		
		$(document).ready(function () {
			@if (isset($errors) and $errors->any())
				@if ($errors->any() and old('messageForm')=='1')
					$('#applyJob').modal();
				@endif
			@endif
		});
	</script>
	<script>
		/* Initialize with defaults (logo) */
		function initFile()
		{
			$('.file').fileinput({
				language: '{{ config('app.locale') }}',
				@if (config('lang.direction') == 'rtl')
					rtl: true,
				@endif
				showPreview: false,
				allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
				showUpload: false,
				showRemove: false,
				maxFileSize: {{ (int)config('settings.upload.max_file_size', 1000) }},
			});
		}
		
		initFile();
		
		var num = 0;
		$('#add_line').click(function(){
			var len = $('.photo-form').length;
			num++;
			if (len < 5) {
				var element = `<div class="form-group photo-form">
									<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading mb10">
										<input name="special[filename` + len + `]" type="file" class="file" required>
									</div>
									<div style="margin-bottom: 15px;"></div>
								</div>`;
				$( element ).insertBefore( "#add_line" );
				initFile();
			}
			if (len == 4) {
				$('#add_line').hide();
			}
		});
	</script>
@endsection