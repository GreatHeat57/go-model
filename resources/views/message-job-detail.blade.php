@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

@section('content')
<?php
if (isset($conversation) && !empty($conversation) > 0) {

    // Conversation URLs
    $consUrl = lurl('account/conversations');
    $conDelAllUrl = lurl('account/conversations/' . $conversation->id . '/messages/delete');

    $post = !empty($conversation->post) ? $conversation->post : '';

    $job_url = '';
    if (!empty($conversation->post)) {
        $post = $conversation->post;
        $job_url = $post->uri;
    }
    ?>
    <div class="container pt-40 px-0">
        <h1 class="prata text-center">{{ t("Messages") }} </h1>
        <div class="divider mx-auto"></div>
        <h4 class="prata text-center pt-20 pb-20 bold"><a>{{ $post->title }}</a></h4>

        <?php /*
        <div class="text-center mb-30 position-absolute-xl xl-to-right-0 xl-to-top-0" wfd-id="34">
           <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-default arrow_left  mini-mobile">{{ t('Back') }}</a>
        </div>
        <?php */ ?>

        <div class="row">
            <div class="col-md-12 text-center mb-30 xl-to-right-0 xl-to-top-0" wfd-id="34">
               <a href="{{ lurl(trans('routes.messages')) }}" class="btn btn-default arrow_left  mini-mobile">{{ t('Back') }}</a>
            </div>
        </div>

        <div class="dividermx-auto"></div>
        <div class="custom-tabs mb-20 mb-xl-30">
            <?php /* {{ Form::select('tabs',[1 => 'Details', 2 => 'Messages'],null) }} {{ route('message-details') }} */ ?>
            <ul class="d-none d-md-block">
                <li><a class="active" href="{{ route('message-job',['id' => $conversation->id, 'jobId' => $post->id]) }}">{{ t('Job Details')  }}</a></li>
                <li><a href="{{ route('message-texts',['id' => $conversation->id]) }}" class="position-relative">{{ t('Messages') }}</a></li>
            </ul>
        </div>
        <div class="w-xl-1220 mx-xl-auto">
            <div class="w-xl-1220 mx-auto">
                @include('childs.notification-message')
            </div>
            <div class="box-shadow bg-white py-60 px-38 px-lg-0 w-xl-1220 mx-xl-auto mb-40">
                <div class="w-lg-750 w-xl-970 mx-auto">
                    @include('post.job_detail_section')
                </div>
            </div>
<?php }?>
        </div>
    </div>  
@endsection