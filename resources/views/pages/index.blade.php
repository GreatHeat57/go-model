{{--
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - 
 http://codecanyon.net/licenses/standard
--}}

<?php /*
@extends('layouts.plain') */ ?>
@extends('layouts.app')
@section('content')

    @if(isset($page->page_layout) && $page->page_layout == "standard")
        <div class="subcover colored-light-blue">
            <h1>{{ $page->title }}</h1>
        </div>

        <div class="block">
            <div class="form">
                <div class="inner-page-content">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    @else
        <div class="static_page_content">
            {!! $page->content !!}
        </div>
    @endif

    <?php /*
    @if(isset($is_featured) && $is_featured == true)
        @include('childs.featured',['class' => 'mg-b'])
    @endif
    */?>
    
@endsection
@section('page-script')
{{ Html::style(config('app.cloud_url').'/css/bladeCss/table-blade.min.css') }}
<script type="text/javascript">
  is_auth = "<?php echo (auth()->check())? true : false; ?>";
  user_type_id = "<?php echo (auth()->check())? auth()->user()->user_type_id : ''; ?>";
  login_url = "<?php echo lurl(trans('routes.login')); ?>";
  model_list_url = "<?php echo lurl(trans('routes.model-list')); ?>";
  post_job_url = "<?php echo lurl(trans('routes.post-a-job')); ?>";
</script>
 {{ Html::script(config('app.cloud_url').'/js/bladeJs/page-blade.js') }}
@endsection