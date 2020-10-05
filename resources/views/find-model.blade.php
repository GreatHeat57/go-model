@extends('layouts.app-partner')

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="f-h2 prata">Find model</h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="#" class="btn btn-white filters mr-20 mini"></a>
                <a href="#" class="btn btn-white search mini"></a>
            </div>
        </div>

        <div class="row searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-440 mx-auto">
                {{ Form::open() }}
                {{ Form::text('search', null, ['class' => 'search', 'placeholder' => 'Search project or ID...']) }}
                {{ Form::submit('Keresés') }}
                {{ Form::close() }}
            </div>
        </div>
        <div class="row bg-white box-shadow filter-area py-30 px-38 mb-40 mx-0">
            <div class="col-md-6 form-group custom-checkbox bb-light-lavender3 pb-30 px-xs-0 pb-sm-10 pl-md-0 mb-30">
                {{ Form::checkbox('option_1', null, 1, ['class' => 'checkbox_field', 'id' => 'option_1']) }}
                {{ Form::label('option_1', 'Option 1', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_2', null, 0, ['class' => 'checkbox_field', 'id' => 'option_2']) }}
                {{ Form::label('option_2', 'Option 2', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_3', null, 0, ['class' => 'checkbox_field', 'id' => 'option_3']) }}
                {{ Form::label('option_3', 'Option 3', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_4', null, 0, ['class' => 'checkbox_field', 'id' => 'option_4', 'disabled']) }}
                {{ Form::label('option_4', 'Option 4', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_5', null, 0, ['class' => 'checkbox_field', 'id' => 'option_5', 'disabled']) }}
                {{ Form::label('option_5', 'Option 5', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_6', null, 0, ['class' => 'checkbox_field', 'id' => 'option_6']) }}
                {{ Form::label('option_6', 'Option 6', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_7', null, 1, ['class' => 'checkbox_field', 'id' => 'option_7']) }}
                {{ Form::label('option_7', 'Option 7', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_8', null, 0, ['class' => 'checkbox_field', 'id' => 'option_8']) }}
                {{ Form::label('option_8', 'Option 8', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_9', null, 0, ['class' => 'checkbox_field', 'id' => 'option_9', 'disabled']) }}
                {{ Form::label('option_9', 'Option 9', ['class' => 'checkbox-label']) }}
            </div>
            <div class="col-md-6 px-xs-0 pr-md-0 mb-md-30 bb-md-light-lavender3">
                <div class="form-group custom-checkbox bb-light-lavender3 pb-sm-10 mb-30">
                    {{ Form::checkbox('option_10', null, 1, ['class' => 'checkbox_field', 'id' => 'option_10']) }}
                    {{ Form::label('option_10', 'Option 10', ['class' => 'checkbox-label']) }}
                    {{ Form::checkbox('option_11', null, 0, ['class' => 'checkbox_field', 'id' => 'option_11']) }}
                    {{ Form::label('option_11', 'Option 11', ['class' => 'checkbox-label']) }}
                    {{ Form::checkbox('option_12', null, 0, ['class' => 'checkbox_field', 'id' => 'option_12']) }}
                    {{ Form::label('option_12', 'Option 12', ['class' => 'checkbox-label']) }}
                </div>
                <div class="form-group custom-checkbox bb-sm-light-lavender3 pb-sm-10 mb-sm-30">
                    {{ Form::checkbox('option_13', null, 1, ['class' => 'checkbox_field', 'id' => 'option_13']) }}
                    {{ Form::label('option_13', 'Option 13', ['class' => 'checkbox-label']) }}
                    {{ Form::checkbox('option_14', null, 0, ['class' => 'checkbox_field', 'id' => 'option_14']) }}
                    {{ Form::label('option_14', 'Option 14', ['class' => 'checkbox-label']) }}
                    {{ Form::checkbox('option_15', null, 0, ['class' => 'checkbox_field', 'id' => 'option_15']) }}
                    {{ Form::label('option_15', 'Option 15', ['class' => 'checkbox-label']) }}
                    {{ Form::checkbox('option_16', null, 0, ['class' => 'checkbox_field', 'id' => 'option_16']) }}
                    {{ Form::label('option_16', 'Option 16', ['class' => 'checkbox-label']) }}
                </div>
            </div>
            <div class="col-md-6 px-xs-0 pl-md-0">
                <div class="custom-radio">
                    {{ Form::radio('radios', null, 1, ['class' => 'radio_field', 'id' => 'option_17']) }}
                    {{ Form::label('option_17', 'Option 17', ['class' => 'radio-label']) }}
                    {{ Form::radio('radios', null, 1, ['class' => 'radio_field', 'id' => 'option_18']) }}
                    {{ Form::label('option_18', 'Option 18', ['class' => 'radio-label']) }}
                    {{ Form::radio('radios', null, 1, ['class' => 'radio_field', 'id' => 'option_19']) }}
                    {{ Form::label('option_19', 'Option 19', ['class' => 'radio-label']) }}
                </div>
                <div class="custom-slider mb-30">
                    <span>Linz, 0 - 50 km</span>
                    <input id="km" class="slider" type="text"/><br/>
                </div>
                <div class="custom-slider mb-sm-30">
                    <span>Körpergröße, 155 - 185 cm</span>
                    <input id="cm" class="slider" type="text"/><br/>
                </div>
            </div>
            <div class="col-md-6 px-xs-0 pr-md-0">
                <div class="custom-slider mb-30">
                    <span>Alter, 15 - 25 Jahre</span>
                    <input id="jahre" class="slider" type="text"/><br/>
                </div>
                <div class="custom-slider">
                    <span>Kleidergröße, 32 - 38 EU</span>
                    <input id="eu" class="slider" type="text"/><br/>
                </div>
            </div>
        </div>

        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs',[1 => 'All models', 2 => 'My favorite'],null) }}
            <ul class="tabs d-none d-md-block">
                <li><a href="#" class="active" data-id="1">All models</a></li>
                <li><a href="#" data-id="2">My favorites</a></li>
            </ul>
        </div>

        <div class="row tab_content mb-40" data-id="1">
            @for($i=1;$i<=8;$i++)
                <div class="col-md-6 col-xl-3 mb-20">
                    <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                        <img srcset="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }},
                                 {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                        <a href="#" class="btn btn-white members invited position-absolute to-right to-top-20 mini"></a>
                    </div>
                    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                            <span class="d-block">id number</span>
                            <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                            <span class="d-block">kategoria</span>
                        </div>
                        <span class="title">Username</span>
                        <span>City-town, County, Country</span>
                        <div class="divider"></div>
                        <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem,
                            velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                        <span class="info posted mb-30">posted 1 day ago</span>
                        <div class="d-flex justify-content-end">
                            <a href="#" class="btn btn-success more mr-20 mini"></a>
                            <a href="#" class="btn btn-white favorite mini"></a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        <div class="row tab_content mb-40" data-id="2">
            @for($i=1;$i<=8;$i++)
                <div class="col-md-6 col-xl-3 mb-20">
                    <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                        <img srcset="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }},
                                 {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic@3x.png') }} 3x"
                             src="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }}" alt="{{ trans('metaTags.Go-Models') }}"/>
                        <a href="#" class="btn btn-white members rejected position-absolute to-right to-top-20 mini"></a>
                    </div>
                    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                            <span class="d-block">id number</span>
                            <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                            <span class="d-block">kategoria</span>
                        </div>
                        <span class="title">Username</span>
                        <span>City-town, County, Country</span>
                        <div class="divider"></div>
                        <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem,
                            velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                        <span class="info posted mb-30">posted 1 day ago</span>
                        <div class="d-flex justify-content-end">
                            <a href="#" class="btn btn-success more mr-20 mini"></a>
                            <a href="#" class="btn btn-white favorite mini"></a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
    @include('children.bottom-bar')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('.filter-area').hide();
            $('.searchbar').hide();
            $('.tab_content[data-id="2"]').hide();
        });

        $('body').on('click', '.tabs li a', function (e) {
            $('.tabs li a').removeClass('active');
            $(this).addClass('active');
            $('.tab_content').hide();
            $('.tab_content[data-id="' + $(this).data("id") + '"]').show();
            e.preventDefault();
        });


        $('body').on('click', 'a.filters', function () {
            $(this).toggleClass('active');
            $('.filter-area').stop().slideToggle();
        });

        $('body').on('click', 'a.search', function () {
            $(this).toggleClass('active');
            $("#search_input").focus();
            $('.searchbar').stop().slideToggle();
        });
$('.search').click(function(e) {
         e.preventDefault();
         setTimeout(function() { $("#searchtext").focus();$('input[name="search"]').focus();$('input[name="search[text]"]').focus(); }, 0000);
     });

        $("#km").slider({
            id: "slider12c",
            min: 0,
            max: 100,
            range: true,
            value: [0, 50]
        });

        $("#cm").slider({
            id: "slider12c",
            min: 130,
            max: 220,
            range: true,
            value: [155, 185]
        });

        $("#jahre").slider({
            id: "slider12c",
            min: 0,
            max: 70,
            range: true,
            value: [15, 25]
        });

        $("#eu").slider({
            id: "slider12c",
            min: 30,
            max: 50,
            range: true,
            value: [32, 38]
        });
    </script>
@endpush