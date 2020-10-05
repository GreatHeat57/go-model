@extends('layouts.app')

@section('content')
<?php $defaultErrorMessage = "An internal server error has occurred. If the error persists please contact the development team.";?>
    <div class="notfoundsection">
         <div class="notfoundsectionwrap">
            <div class="notfoundcontent">
               <div class="somethingwrongtext"><img src="images/error_images/500.png" alt="500 {{ t('internal_error_label') }}"><span>{{ t('internal_error_label') }}</span></div>
               <div class="notfoundcontentwrap">
                  <h3 class="somethingwrongh3">{{ t('internal_error') }}</h3>
                  <p>{{-- t('not_found_paragrah') --}}</p>
                  <div class="btn"><a href="{{ lurl('/') }}" class="next section_1">{{ t('go_back') }}</a></div>
               </div>
            </div> 
        </div> 
    </div>
    <div class="block no-pd-b" style="background: #f1f6fa;"></div>
    <?php /*
	<div class="block no-pd-b" style="background: #f1f6fa;">
        <h3 class=""></h2>
        <h3 class="playfair warning-font"></h3>

        <div class="try-it mg-b-20">
        	<!-- <h4 class="warning-font" style="color: #e40909;"> {!! isset($exception) ? ($exception->getMessage() ? $exception->getMessage() : $defaultErrorMessage) : $defaultErrorMessage !!} </h4> -->
            <!-- <h2 class="mg-b-20">404</h2> -->
        </div>

        	<?php
$requirements = [];
if (!version_compare(PHP_VERSION, '7.0.0', '>=')) {
	$requirements[] = 'PHP 7.0.0 or higher is required.';
}
if (!extension_loaded('openssl')) {
	$requirements[] = 'OpenSSL PHP Extension is required.';
}
if (!extension_loaded('mbstring')) {
	$requirements[] = 'Mbstring PHP Extension is required.';
}
if (!extension_loaded('pdo')) {
	$requirements[] = 'PDO PHP Extension is required.';
}
if (!extension_loaded('tokenizer')) {
	$requirements[] = 'Tokenizer PHP Extension is required.';
}
if (!extension_loaded('xml')) {
	$requirements[] = 'XML PHP Extension is required.';
}
if (!extension_loaded('fileinfo')) {
	$requirements[] = 'PHP Fileinfo Extension is required.';
}
if (!(extension_loaded('gd') && function_exists('gd_info'))) {
	$requirements[] = 'PHP GD Library is required.';
}
?>
            @if (isset($requirements) && count($requirements) > 0)
			<div class="text-center mg-b-20">
				<div class="book">
					<ul class="max no-mg-b warning-font warning-ul">
						@foreach ($requirements as $key => $item)
							<li>
								<span class="status rejected">Error #{{ $key }}</span>
								<p>{{ $item }}</p>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
			@endif
        <div class="btn ">
            <a href="<?php echo url('/'); ?>">{{ t('Home') }}!</a>
          <!--   route('book_a_model') -->
        </div>
    </div>
    */ ?>
@endsection
