@extends('layouts.logged_in.out_of_app')


@section('content')
@include('childs.register_title')
<div class="d-flex align-items-center container out_of_app px-0 mw-970" >
    <div class="bg-white box-shadow full-width">
        <div class="d-flex justify-content-center">
            <div class="flex-grow-1 mw-720 py-20 px-30">
                <h1 class="text-center prata">{{ t('Code') }}</h1>

                <div class="text-center mb-30 position-relative">
                    @include('childs.notification-message')

                    <div class="custom-tabs mb-20 mb-xl-30 alert alert-info" >{{ getTokenMessage() }}:</div>
                </div>

                <form id="tokenForm" role="form" method="POST" action="{{ lurl(Request::path()) }}">
                {!! csrf_field() !!}

                <div class="input-group pb-20 mb-20 <?php echo (isset($errors) and $errors->has('email')) ? 'invalid-input' : ''; ?>">
                    {{ Form::label(getTokenLabel(), getTokenLabel(), ['class' => 'position-relative control-label select-label required']) }}
                    {{ Form::email('code', old('code'), ['class' => 'animlabel', 'id' => 'code', 'placeholder' => '', 'required' => 'true']) }}
                </div>

                <div class="text-center"><button type="submit" class="d-inline-block btn btn-success register mb-40" id="tokenBtn">{{ t('Submit') }}</button></div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection