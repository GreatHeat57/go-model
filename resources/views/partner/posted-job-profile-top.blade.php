

<h1 class="text-center prata">{{ mb_ucfirst($post->title) }}</h1>
<div class="position-relative" wfd-id="33">
    <div class="divider mx-auto" wfd-id="35"></div>
    <p class="text-center mb-30 w-lg-596 mx-lg-auto prata"><h2 class=" text-center prata">{{ ucWords(t(':type Job', ['type' => $postType->name])) }}</h2></p>
    <!-- <div class="text-center mb-30 position-absolute-xl xl-to-right-0 xl-to-top-0" wfd-id="34">
       <a href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-default arrow_left  mini-mobile">{{ t('Back to Results') }}</a>
    </div> -->

    <div class="row">
        <div class="col-md-12 pt-20 text-center mb-30 xl-to-right-0 xl-to-top-0" wfd-id="34">
           <a href="{{ Session::get('prev_url') }}" class="btn btn-default arrow_left  mini-mobile">{{ t('Back to Results') }}</a>
        </div>
    </div>
</div>




<?php /*
<div class="custom-tabs mb-20 mb-xl-30">
    <ul class="d-none d-md-block">
        <!-- add active class to the "a" tag -->
        <li><a class="active" href="#">{{ t('Details') }}</a></li>
        <!-- <li><a href="{{ URL::previous() }}">{{ t('Back to Results') }}</a></li> -->
        <!-- <li><a href="#" class="position-relative">Participants<span class="msg-num tab ongoing">10</span></a></li>
        <li><a href="#" class="position-relative">Appliers<span class="msg-num tab applied">7</span></a></li>
        <li><a href="#" class="position-relative">Invite<span class="msg-num tab invited">7</span></a></li>
        <li><a href="#" class="position-relative">Messages<span class="msg-num tab">7</span></a></li> -->
    </ul>
</div> */ ?>
