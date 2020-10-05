@extends('layouts.app')

@section('content')
    <div class="subcover smaller colored-very-light-blue">
        <h1>{!! trans('frontPage.post_job_page_title') !!}</h1>
    </div>

    <div class="block mg-b">
        <div class="form">
            <div class="inner">
                <div class="row">
                    {!! csrf_field() !!}
                    <h2>{{ trans('frontPage.post_job_form_title') }}</h2>

                    <p>{!! trans('frontPage.post_job_form_sub_title') !!}</p>

                    @if (isset($errors) and $errors->any())
                        @if($errors->has('g-recaptcha-response') || $errors->has('terms'))
                            <div class="alert alert-danger col-lg-12">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <ul style="padding-left: 20px; text-align: left;">
                                    @if(isset($errors) && $errors->has('g-recaptcha-response'))
                                        <li>{{ $errors->first('g-recaptcha-response') }}</li>
                                    @endif
                                    @if(isset($errors) && $errors->has('terms'))
                                        <li>{{ $errors->first('terms') }}</li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    @endif
                @if (Session::has('flash_notification'))
                    @include('flash::message')
                @endif
                </div>

                <div class="alert alert-success print-success-msg" style="display:none"></div>

                <form class="form-horizontal" id="post-request" role="form" method="post" action="{{ lurl(trans('routes.post-a-job')) }}">
                    <input type="hidden" id="post_url" name="post_url" value="{{ lurl(trans('routes.post-a-job')) }}">
                    {!! csrf_field() !!}
                    <div class="row">
                        {{ Form::text('name',old('name'),['placeholder' => t('Name').'*', 'required' => 'required']) }}
                        <?php /*
                        @if(isset($errors) && $errors->has('name'))
                            <span class="help-block error-p">{{ $errors->first('name') }}</span>
                        @endif
                        */ ?>
                        <span class="help-block error-input" id='name'></span>
                    </div>

                    <div class="row">
                        {{ Form::email('email',old('email'),['placeholder' => t('Email').'*', 'required' => 'required']) }}
                        <?php /*
                            @if(isset($errors) && $errors->has('email'))
                                <span class="help-block error-p">{{ $errors->first('email') }}</span>
                            @endif
                        */ ?>
                        <span class="help-block error-input" id='email'></span>
                    </div>

                    <div class="row">
                        {{ Form::text('company',old('company'),['placeholder' => t('Company Name').'*', 'required' => 'required']) }}
                        <?php /*
                            @if(isset($errors) && $errors->has('company'))
                                <span class="help-block error-p">{{ $errors->first('company') }}</span>
                            @endif
                        */ ?>
                        <span class="help-block error-input" id='company'></span>
                    </div>
                    <div class="row">
                    <label class="control-label" for="">{{ t('Message (upto 500 letters)') }}</label>
                    {{ Form::textarea('message', old('message') ,['class' => $errors->has('message') ? 'error-input-border' : '', 'required' => 'required', "maxlength"=>"500", "minlength" =>"5"]) }}
                    <?php /*
                        @if(isset($errors) && $errors->has('message'))
                            <p class="help-block error-p">{{ $errors->first('message') }}</p>
                        @endif
                    */ ?>
                    <span class="help-block error-input" id='message'></span>
                </div>
                    @if (config('settings.security.recaptcha_activation'))
                        <!-- g-recaptcha-response -->
                        <div class="form-group required <?php echo (isset($errors) and $errors->has('g-recaptcha-response')) ? 'has-error' : ''; ?>" style="margin-left: unset;margin-right: unset;">
                            <label class="control-label" for="g-recaptcha-response"></label>
                            <div class="no-label">
                                {!! Captcha::display($attributes = [], $options = ['lang' => config('lang.locale')]) !!}
                            </div>
                        </div>
                        <span class="help-block error-input" id="error-recaptcha-msg"></span>
                    @endif
                    <?php /*
                    <div class="checkbox terms-div">
                        {{ Form::checkbox('terms',1,false,['class' => 'css-checkbox', 'id' => 'terms2']) }}
                        <label for="terms2" class="css-label term-label">{!! t('Job post terms and condition') !!}</label>
                    </div>
                    */ ?>
                    <div class="btn pt-20">
                        {{ Form::button(trans('frontPage.post_job_btn'),['type' => 'submit', 'class' => 'green next']) }}
                    </div>
                </form>
            </div>
        </div>

        <?php echo (isset($pageContent)) ? $pageContent : '';  ?>

        <?php /*
        <!-- new text after form -->
        <div class="block" style="border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;margin-top:80px;">
            <h2>go- easy - Models finden war noch nie so einfach</h2>
            <br>
            <h5>Deine Vorteile als Auftraggeber:</h5>

            <div class="cols-2 nested">
                <div class="col">
                    <div class="howto">
                        <ul class="bullet-pipe">
                            <li>Du kannst in nur wenigen Minuten einen Job einstellen mit allen Anforderungen und Details</li>
                            <li>Bei uns findest Du eine Vielzahl der verschiedensten Models - ob Baby,- und Kindermodels, Models, 50plus Models oder auch Plus Size und Fitness Models. So ist für jeden Auftrag der passende Typ dabei!</li>
                            <li>Nur die für Deinen Auftrag passenden Models können sich auf den Modeljob bewerben - So ersparst du Dir wertvolle Zeit</li>
                        </ul>
                    </div>
                </div>

                <div class="col">
                    <div class="howto">
                        <ul class="bullet-pipe">
                            <li>Durch Deinen uneingeschränkten online Zugriff auf Dein Profil kannst Du jederzeit nach Models suchen sowie auch die Job Bewerber ansehen</li>
                            <li>Als Auftraggeber nutzt du go-models kostenlos</li>                            
                            <li>Nicht nur Du kannst Jobs einstellen - sondern auch selbst Jobs erhalten. Lerne neue Leute aus den unterschiedlichsten Branchen kennen!</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="block colored-light-blue2">
            <div class="book">
                <h2>Worauf wartest Du?</h2>

                <p>Find models and clients for your project!</p>

                <ul class="bullet-pipe">
                    <li><span>Knüpfe jetzt Kontakte und finde Models in Deiner Umgebung oder international</span></li>
                    <li><span>Entdecke die verschiedensten Modeltypen und Persönlichkeiten!</span></li>
                    <li><span>Verwalte Dein Profil online und nutze unsere einfache und moderne Model Suche wo und wann immer Du willst!</span></li>
                    <li><span>Finde nicht nur Models - sondern werde auch Du von Firmen und Auftraggebern gefunden!</span></li>
                </ul>
            </div>
        </div>
        <div class="block colored2">
            <div class="have-a-job">
                <div class="col">
                    <h3>Du bist unter Zeitdruck?</h3>
                </div>

                <div class="col">
                    <ul class="bullet-pipe no-mg-b">
                        <li>Unser Team unterstützt Dich auch gerne bei der Suche nach passenden Models</li>
                        <li>Wenn Du das Formular oben ausfüllst, setzen wir uns gerne mit Dir in Verbindung und besprechen alles bezüglich Deines Auftrags</li>
                        <li>Auch bei Fragen oder Anliegen sind wir Dir gerne jederzeit behilflich!</li>
                    </ul>
                </div>
                <div class="col">
                    <div class="btn">
                        <a href="javascript:void()" class="next register mfp-register-form">Jetzt als Auftraggeber registrieren</a>
                    </div>
                </div>
            </div>
        </div>
        <?php */ ?>
    </div>
@endsection
@section('page-script')
<?php /* {{ Html::script(config('app.cloud_url').'/js/bladeJs/post_a_jobs-blade.js') }} */ ?>
@endsection
@push('scripts')
@endpush