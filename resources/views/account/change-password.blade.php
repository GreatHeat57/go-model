@extends(Auth::user()->user_type_id == 2 ? 'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model')

@section('content')
    <div class="container pt-40 pb-60 px-0">
        <h1 class="text-center prata">{{t('Change Password')}}</h1>
        <div class="position-relative">
            <div class="divider mx-auto"></div>
            <!-- <p class="text-center mb-30 w-lg-596 mx-lg-auto">Your username, name, bio and links appear on your model profile. Your real name, email address and other contact details remaining private</p> -->
            
        </div>
        <div class="w-xl-1220 mx-auto">
            @include('childs.notification-message')
        </div>
        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto">
            <div class="w-lg-750 mx-auto px-38 px-lg-0 ">
                <h2 class="bold f-18 lh-18">{{t('set new password')}}</h2>
                <div class="divider"></div>
                
            @if(config('app.locale') == 'de')
            <?php $lang = '';?>
            @else
            <?php $lang = config('app.locale');?>
            @endif
            {{ Form::open(array('url' => lurl('account/settings'), 'method' => 'post')) }}
               
                <div class="input-group">
                     <input name="_method" type="hidden" value="PUT">
                    {{ Form::password('old_password',['class' => 'old_password animlabel','id'=> 'old_password', 'required'=>'required']) }}
               
                    {{ Form::label('old_password', t('old password') , ['class' => 'required']) }}
                     <!-- <small class="errors">{--!!$errors->first('old_password')!!--}  </small> -->
                </div>
                <div class="input-group">
                    {{ Form::password('password', ['class' => 'new_password animlabel' ,'id'=> 'new_password','required'=>'required']) }}

                    {{ Form::label('new_password', t('new password'), ['class' => 'required']) }}
                     <!-- <small class="errors">{--!! $errors->first('password')!!--} </small> -->
                </div>
                <div class="input-group">
                    {{ Form::password('password_confirmation',['class' => 'new_password_confirmation animlabel','id'=> 'new_password_confirmation','required'=>'required']) }}

                    {{ Form::label('password_confirmation', t('new password again'), ['class' => 'required']) }}

                    <!-- <small class="errors">{--!! $errors->first('password_confirmation')!!--}</small> -->
                </div>
                 <!-- <div class="input-group"> -->
                    {{-- Form::submit('submit',['class'=>'required btn btn-primary']) --}}

                 <!-- </div>  -->  
                 @include('childs.bottom-bar-reset')
                 </div>
            {{ Form::close() }}
            </div>
        </div>
    </div>


@endsection