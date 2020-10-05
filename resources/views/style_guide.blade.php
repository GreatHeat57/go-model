@extends('layouts.app-model')

@section('content')
    <div class="container">
        <div class="row bg-white box-shadow position-relative justify-content-between pt-40 pr-20 pb-20 pl-30">
            <span class="flag to-right to-top-0 ongoing"></span>
            <div class="col-md-6 px-0 pr-md-2 bordered">
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                    <span class="d-block">id number</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">kategoria</span>
                </div>
                <span class="title">Jobname lorem ipsum dolor et sit amet ante id molestie</span>
                <span>Jobart, Jobart</span>
                <div class="divider"></div>
                <p class="mb-20">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
            </div>
            <div class="col-md-6 px-0 pl-md-2 pt-58 pb-64 position-relative">
                <span class="info city">City-Town, County, Country</span>
                <span class="info appointment">Date, Appointment</span>
                <span class="info partner">Partner</span>
                <span class="status ongoing">Status</span>
                <div class="d-flex align-self-end justify-content-end corner-btn"><a href="#" class="btn btn-white message position-relative align-self-end mini"><span class="msg-num">45</span></a></div>
            </div>
        </div>

        <div class="my-sm-3"></div>

        <div class="row bg-white box-shadow position-relative pt-40 pr-20 pb-20 pl-30">
            <div class="col-sm-12 p-0 position-relative">
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                    <span class="d-block">id number</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">kategoria</span>
                </div>
                <span class="title">Jobname lorem ipsum dolor et sit amet ante id molestie</span>
                <span>Jobart, Jobart</span>
                <div class="divider"></div>
                <p class="mb-20">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula
                    eroset t accumsan quam feugiat y vulputatetus.</p>
                <span class="info city">City-Town, County, Country</span>
                <span class="info appointment">Date, Appointment</span>
                <span class="info partner">Partner</span>
                <span class="info posted">posted 1 day ago</span>
                <div class="d-flex corner-btn justify-content-end"><a href="#" class="btn btn-white favorite active align-self-end mini"></a>
                </div>
            </div>
        </div>

        <div class="my-sm-3"></div>

        <div class="row bg-white box-shadow position-relative pt-40 pr-20 pb-20 pl-30">
            <span class="flag to-right to-top-0 applied"></span>
            <div class="col-md-6 px-0 pr-md-2 bordered">
                <div class="modelcard-top text-uppercase d-flex align-items-center mb-30">
                    <span class="d-block">id number</span>
                    <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1"></span>
                    <span class="d-block">kategoria</span>
                </div>
                <span class="title">Jobname lorem ipsum dolor et sit amet ante id molestie</span>
                <span>Jobart, Jobart</span>
                <div class="divider"></div>
                <p class="mb-20">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                <span class="info posted">posted</span>
            </div>
            <div class="col-md-6 px-0 pl-md-2 pt-58">
                <span class="info city">City-Town, County, Country</span>
                <span class="info appointment">Date, Appointment</span>
                <span class="status applied">Status</span>
            </div>
            <div class="col-sm-12 bordered2 px-0 pt-20 mt-20 d-flex justify-content-end">
                <a class="btn btn-white members accepted mr-20 position-relative mini"><span
                            class="msg-num">45</span></a>
                <a class="btn btn-white members invited mr-20 position-relative mini"><span
                            class="msg-num">45</span></a>
                <a class="btn btn-white members applied mr-20 position-relative mini"><span
                            class="msg-num">45</span></a>
                <a class="btn btn-white message mr-20 position-relative mini"><span class="msg-num">45</span></a>
                <a class="btn btn-success more mini"></a>
            </div>
        </div>

        <div class="my-sm-3"></div>

        <div class="row">
            <div class="col-md-6">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="/images/img-logo.png" alt="Go Models" class="logo"/>
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
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini"></a>
                        <a href="#" class="btn btn-white favorite mini"></a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <img srcset="{{ URL::to('images/icons/ico-nopic.png') }},
                                 {{ URL::to('images/icons/ico-nopic@2x.png') }} 2x,
                                 {{ URL::to('images/icons/ico-nopic@3x.png') }} 3x"
                         src="/images/img-logo.png" alt="Go Models" class="logo"/>
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
                    <p class="mb-70">150 Description, ante id molestie placerat, nisi turpis ultriceslorem, velcongueligula eroset inmilorem. Praesent accumsan quam feugiat y vulputatetus.</p>
                    <span class="info posted mb-30">posted 1 day ago</span>
                    <div class="d-flex justify-content-end">
                        <a href="#" class="btn btn-success more mr-20 mini"></a>
                        <a href="#" class="btn btn-white favorite mini"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="my-sm-3"></div>

        <div class="row bg-white box-shadow py-2 justify-content-center">
            <div class="col-sm-12 col-md-10 px-0 d-flex">
                {{ Form::text('type_a_message', null, ['class' => 'mr-10 message', 'placeholder' => 'type a message...']) }}
                <a href="#" class="btn btn-success post mini"></a>
            </div>
        </div>

        <div class="my-sm-3"></div>

        <div class="row bg-white box-shadow pt-40 pr-20 pb-20 pl-30">
            <div class="col-sm-12 px-0">
                <span class="title">Form elements</span>
                <div class="divider"></div>
                <div class="input-group">
                    {{ Form::text('lastname', null, ['class' => 'animlabel']) }}
                    {{ Form::label('lastname', 'Lastname') }}
                </div>
                <div class="input-group">
                    {{ Form::text('firstname', null, ['class' => 'animlabel']) }}
                    {{ Form::label('firstname', 'Firstname') }}
                </div>
                <div class="input-group">
                    {{ Form::password('password', ['class' => 'animlabel']) }}
                    {{ Form::label('password', 'Password') }}
                </div>

                <div class="error-message">Wrong username!</div>
                <div class="input-group">
                    {{ Form::text('invalid', null, ['class' => 'animlabel invalid']) }}
                    {{ Form::label('invalid', 'Invalid') }}
                </div>
                <div class="form-group">
                    @php
                        $options = [
                            1 => 'Option 1',
                            2 => 'Option 2',
                            3 => 'Option 3',
                            4 => 'Option 4',
                            5 => 'Option 5',
                            6 => 'Option 6',
                            7 => 'Option 7',
                            8 => 'Option 8',
                        ];
                    @endphp
                    {{ Form::label('data_select' , 'Select data', ['class' => 'control-label required select-label position-relative']) }}
                    {{ Form::select('data_select', [0 => 'Choose']+$options, null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="col-md-6 form-group custom-checkbox">
                {{ Form::checkbox('option_1', null, 1, ['class' => 'checkbox_field', 'id' => 'option_1']) }}
                {{ Form::label('option_1', 'Option 1', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_2', null, 0, ['class' => 'checkbox_field', 'id' => 'option_2']) }}
                {{ Form::label('option_2', 'Option 2', ['class' => 'checkbox-label']) }}
                {{ Form::checkbox('option_3', null, 0, ['class' => 'checkbox_field', 'id' => 'option_3']) }}
                {{ Form::label('option_3', 'Option 3', ['class' => 'checkbox-label']) }}
            </div>
            <div class="col-md-6 form-group custom-radio">
                {{ Form::radio('radio', null, 1, ['class' => 'radio_field', 'id' => 'radio_1']) }}
                {{ Form::label('radio_1', 'Radio 1', ['class' => 'radio-label']) }}
                {{ Form::radio('radio', null, 0, ['class' => 'radio_field', 'id' => 'radio_2']) }}
                {{ Form::label('radio_2', 'Radio 2', ['class' => 'radio-label']) }}
                {{ Form::radio('radio', null, 0, ['class' => 'radio_field', 'id' => 'radio_3']) }}
                {{ Form::label('radio_3', 'Radio 3', ['class' => 'radio-label']) }}
            </div>
        </div>

        <div class="row py-3">
            <div class="col-3">
                <a class="btn btn-primary trash">Delete</a>
                <a class="btn btn-primary zoom">Zoom</a>
            </div>
            <div class="col-3">
                <a class="btn btn-default edit_grey">Edit</a>
                <a class="btn btn-default more_messages">More messages</a>
                <a class="btn btn-default insight">Insight</a>
            </div>
            <div class="col-3">
                <a class="btn btn-success add_new">Add new</a>
                <a class="btn btn-success reset">Reset</a>
                <a class="btn btn-success upload">Upload</a>
                <a class="btn btn-success post">Post</a>
                <a class="btn btn-success edit">Edit</a>
                <a class="btn btn-success more">More</a>
            </div>
            <div class="col-3">
                <a class="btn btn-white add_locale">Add Locale</a>
                <a class="btn btn-white draft">Draft</a>
                <a class="btn btn-white upload_white">Upload</a>
                <a class="btn btn-white post_white">Post</a>
                <a class="btn btn-white trash_white">Delete</a>
                <a class="btn btn-white message position-relative"><span class="msg-num">45</span> Message</a>
                <a class="btn btn-white search">Search</a>
                <a class="btn btn-white insight">Insight</a>
                <a class="btn btn-white edit_grey">Edit</a>
                <a class="btn btn-white sorting">Sorting</a>
                <a class="btn btn-white arrow_left">Arrow left</a>
                <a class="btn btn-white arrow_right">Arrow right</a>
                <a class="btn btn-white invite">Invite</a>
                <a class="btn btn-white delete">Delete</a>
                <a class="btn btn-white favorite mini">Favorite</a>
                <a class="btn btn-white favorite mini active">Favorite</a>
                <a class="btn btn-white filters">Filters</a>
                <a class="btn btn-white filters active">Filters</a>
            </div>
        </div>
    </div>
@endsection