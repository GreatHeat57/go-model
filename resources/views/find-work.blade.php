@extends('layouts.app-model')

@section('content')
    <div class="container px-0 pt-40 pb-60">
        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="f-h2 prata">Find work</h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="position-absolute-md md-to-right-0 md-to-top-0">
                <a href="#" class="btn btn-white filters mr-20 mini-all"></a>
                <a href="#" class="btn btn-white search mini-all"></a>
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
            <div class="row col-sm-12 col-lg-6 form-group custom-checkbox bb-md-down-light-lavender3 pb-30 mb-md-down-30 px-0 mx-0">
                {{ Form::checkbox('option_1', null, 1, ['class' => 'checkbox_field', 'id' => 'option_1']) }}
                {{ Form::label('option_1', 'Option 1', ['class' => 'checkbox-label col-md-6']) }}
                {{ Form::checkbox('option_2', null, 0, ['class' => 'checkbox_field', 'id' => 'option_2']) }}
                {{ Form::label('option_2', 'Option 2', ['class' => 'checkbox-label col-md-6']) }}
                {{ Form::checkbox('option_3', null, 0, ['class' => 'checkbox_field', 'id' => 'option_3']) }}
                {{ Form::label('option_3', 'Option 3', ['class' => 'checkbox-label col-md-6 mb-lg-0']) }}
                {{ Form::checkbox('option_4', null, 0, ['class' => 'checkbox_field', 'id' => 'option_4']) }}
                {{ Form::label('option_4', 'Option 4', ['class' => 'checkbox-label col-md-6 mb-lg-0']) }}
            </div>
            <div class="custom-slider col-lg-6">
                <div class="w-md-330">
                    <span>Linz, 0 - 50 km</span>
                    <input id="km" class="slider" type="text"/><br/>
                </div>
            </div>
        </div>

        <div class="custom-tabs mb-20 mb-xl-30">
            {{ Form::select('tabs',[1 => 'Work search', 2 => 'My favorite'],null) }}
            <ul class="tabs d-none d-md-block">
                <li><a href="#" class="active" data-id="1">Work search</a></li>
                <li><a href="#" data-id="2">My favorites</a></li>
            </ul>
        </div>

        <div class="row tab_content mb-40" data-id="1">
            @for($i=1;$i<=8;$i++)
                <div class="col-md-6 col-xl-3 mb-20">
                    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30 position-relative">
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                            <span class="d-block">id number</span>
                            <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                            <span class="d-block">kategoria</span>
                        </div>
                        <a href="{{ route('job-profile') }}"><span class="title">Jobname lorep ipsum dolor et sit amet ante id molestie</span></a>
                        <span>Jobat, Jobart</span>
                        <div class="divider"></div>
                        <p class="mb-30">150 Description, ante id molestie placerat, nisi turpis ultriceslorem,
                            velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                        <span class="info city mb-10">Oberpullendorf, Bugenland, Austria</span>
                        <span class="info appointment mb-10">18.08.2018, 10:00</span>
                        <span class="info partner mb-30">Hugo Boss</span>
                        <span class="info posted">posted 1 day ago</span>
                        <a href="#" class="btn btn-white favorite mini-all position-absolute to-right to-bottom-20"></a>
                    </div>
                </div>
            @endfor
        </div>
        <div class="row tab_content mb-40" data-id="2">
            @for($i=1;$i<=8;$i++)
                <div class="col-md-6 col-xl-3 mb-20">
                    <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30 position-relative">
                        <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                            <span class="d-block">id number</span>
                            <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                            <span class="d-block">kategoria</span>
                        </div>
                        <a href="{{ route('job-profile') }}"><span class="title">Jobname lorep ipsum dolor et sit amet ante id molestie</span></a>
                        <span>Jobat, Jobart</span>
                        <div class="divider"></div>
                        <p class="mb-30">150 Description, ante id molestie placerat, nisi turpis ultriceslorem,
                            velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                        <span class="info city mb-10">Oberpullendorf, Bugenland, Austria</span>
                        <span class="info appointment mb-10">18.08.2018, 10:00</span>
                        <span class="info partner mb-30">Hugo Boss</span>
                        <span class="info posted">posted 1 day ago</span>
                        <a href="#" class="btn btn-white favorite active mini-all position-absolute to-right to-bottom-20"></a>
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
         setTimeout(function() { $('input[name="search"]').focus();
            $('input[name="search[text]"]').focus(); }, 0000);
     });


        $("#km").slider({
            id: "slider12c",
            min: 0,
            max: 100,
            range: true,
            value: [0, 50]
        });
    </script>
@endpush