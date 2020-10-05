@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )

@section('content')

    <div class="container pt-40 pb-60 px-0 w-xl-1220">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="text-center prata">{{ t('Messages') }}</h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="javascript:void(0)" class="btn btn-white search mini-under-desktop">{{ t('Search') }}</a>
            </div>
        </div>

        <div class="row searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-md-auto">

                <form method="POST" action="{{ lurl(trans('routes.messages')) }}" accept-charset="UTF-8" id="search-form">
                
                    {{ csrf_field() }}
                    
                    <div class="input-bar">
                        <div class="input-bar-item width100">
                            <div class="form-group">
                                <?php /*
                                <!-- <input class="search_notification width100"  placeholder="{{ t('search messages') }}" name="search" type="text" value="{{old('search', '')}}" autocomplete="off" required="required"> --> */ ?>
                                {{ Form::text('search', null, ['id' => 'searchtext', 'class' => 'width100', 'placeholder' => t('search messages'),'autofocus'=>'autofocus', 'required'=> 'required']) }}
                            </div>
                        </div>
                        <div class="input-bar-item">
                            <input type="button" class="btn btn-white search no-bg" value="" id="msg-search-submit">
                        </div>
                    </div>
                </form>
                <?php /*
              <form name="listForm" class="listForm" method="POST" action="{{ lurl(trans('routes.messages')) }}">
                {!! csrf_field() !!}
                {{ Form::text('search', null, ['class' => 'search', 'placeholder' => t('search messages'), 'id' => 'filter', 'id' => 'search_input']) }}
                <input type="submit" id='submit-button' value="Keresés" style="cursor: pointer;">
               </form>
               <?php */ ?>
            </div>
        </div>
        
        @include('childs.notification-message')
        @include('messages-ajax')
    </div>


    @include('childs.bottom-bar')
@endsection

@section('page-script')
<script type="text/javascript">
    var siteUrl = '<?php echo url('/'); ?>';
</script>
@endsection