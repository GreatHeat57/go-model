<?php /*
@if (Session::has('flash_notification'))
	<div class="container">
		<div class="row">
			<div class="col-lg-12 pt-20">
				@include('flash::message')
			</div>
		</div>
	</div>
@endif
@if (isset($errors) and $errors->any())
	<div class="container">
		<div class="row pt-20">
			<div class="col-lg-12 pt-20">
				<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<ul style="padding-left: 20px; text-align: left;">
						@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
@endif
*/ ?>


@if (Session::has('flash_notification'))
	<div class="pt-40">
		@include('flash::message')
	</div>
@endif
@if (isset($errors) and $errors->any())
	<div class="pt-20">
		<div class="alert alert-danger" style="padding-bottom: 0px !important;">
		
		<?php /*
			<!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
		*/ ?>
		
			<ul style="padding-left: 20px; text-align: left; list-style-type: none !important;">
				@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	</div>
@endif
{{ Html::style(config('app.cloud_url').'/css/bladeCss/notification_message-blade.css') }}