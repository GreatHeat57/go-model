<div id="stepWizard" class="container">
    <div class="row">
        <div class="full-width">
            <section>
                <div class="wizard">

                    <ul class="nav nav-wizard">
                            <li class="{{ ($uriPath == 'yourContract') ? 'active' : 'disabled' }}">
                                <a>{{ t('Your Contract') }}</a>
                            </li>

                            @if(isset($show_payment_link) && $show_payment_link == true)
                                <li class="{{ ($uriPath == 'payment' || $uriPath == 'finish') ? 'active' : 'disabled' }}">
                                    <a>{{ t('Payment') }}</a>
                                </li>
                            @endif

                            @if(isset($show_payment_link) && $show_payment_link == false)
                                <li class="{{ ($uriPath == 'payment' || $uriPath == 'finish') ? 'active' : 'disabled' }}"> <a>{{ t('Finish') }}</a> </li>
                            @endif
                            

                            <!-- <li class="{{-- ($uriPath == 'finish') ? 'active' : 'disabled' --}}">
                                <a>{{-- t('Finish') --}}</a>
                            </li> -->
                    </ul>

                </div>
            </section>
        </div>
    </div>
</div>

@section('after_styles')
    @parent
    @if (config('lang.direction') == 'rtl')
        <link href="{{ url(config('app.cloud_url').'/assets/css/rtl/wizard.css') }}" rel="stylesheet">
    @else
        <link href="{{ url(config('app.cloud_url').'/assets/css/wizard.css') }}" rel="stylesheet">
    @endif
@endsection
@section('after_scripts')
    @parent
@endsection