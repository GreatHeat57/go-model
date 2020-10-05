@extends('layouts.logged_in.app-partner')

@section('content')
    <div class="container pt-40 pb-60 px-0 companies-container">

        <div class="text-center mb-30 position-relative">
            <div>
                <h1 class="text-center prata">{{ ucWords(t('My companies')) }}</h1>
                <div class="divider mx-auto"></div>
            </div>
            <div class="text-center mb-30">
                <a  href="{{ lurl(trans('routes.account-companies-create')) }}" class="btn btn-default add_locale mini-mobile ml-10">{{ t('Create a new company') }}</a>
                <a href="#" class="btn btn-white search mini-under-desktop float-right">{{ t('Search') }}</a>
            </div>
        </div>

        <div class="row searchbar bg-white box-shadow py-30 px-20 px-md-30 px-lg-38 mb-40 mx-0">
            <div class="w-md-440 mx-auto">
                
                <form method="POST" action="{{ lurl(trans('routes.account-companies-search')) }}" accept-charset="UTF-8" id="search-form">
                    {{ csrf_field() }}
                    <div class="input-bar">
                        <div class="input-bar-item width100">
                            <div class="form-group">
                                {{ Form::text('search', null, ['id' => 'searchtext', 'class' => 'width100', 'placeholder' => t('Search Companies'),'autofocus'=>'autofocus', 'required'=> 'required']) }}
                            </div>
                        </div>
                        <div class="input-bar-item">
                            <input type="button" class="btn btn-white search no-bg" value="" id="company-search-submit">
                        </div>
                    </div>
                </form>
                <?php /*
                {{ Form::open(array('url' => lurl(trans('routes.account-companies-search')), 'method' => 'post')) }}
                {{ Form::text('search', null, ['class' => 'search', 'placeholder' => t('Search Companies')]) }}
                {{ Form::submit('Keresés') }}
                {{ Form::close() }}
                <?php */ ?>
            </div>
        </div>
        @include('childs.notification-message')

        <div class="position-relative mx-xl-auto mb-30">
            @if(!empty( $companies ) && count($companies) > 0 ) 
            
                <form name="listForm" method="POST" action="{{ lurl(trans('routes.account-companies-delete')) }}">
                    {!! csrf_field() !!}
                    <div class="row listForm-deleteAll-container mb-30">
                        <div class="col-md-6 col-6 form-group custom-checkbox middle-checkbox">
                            <input class="checkbox_field" id="checkAll" name="entries" type="checkbox">
                            <label for="checkAll" id="selected-all" class="checkbox-label "> {{ t('Select') }}: {{ t('All') }} </label>
                        </div>
                        <div class="col-md-6 col-6 form-group custom-checkbox text-right">
                            <button type="submit"  class="btn btn-white trash_white mini-mobile delete-btn">{{ t('Delete') }}</button>
                        </div>
                    </div>
            @endif
        </div>

        @if(!empty( $companies ) && count($companies) > 0 )
        <div class="row">
            @foreach($companies as $k => $company)
            <div class="col-md-6 col-xl-3 mb-30">
                <div class="img-holder d-flex align-items-center justify-content-center position-relative">
                    <?php $d_attr = ['countryCode' => config('country.icode'), 'id' => $company->id]; ?>
                    <a href="{{ lurl(trans('routes.v-account-companies-delete', $d_attr), $d_attr) }}" class="position-absolute to-bottom-0 to-right-0 btn btn-primary trash mini-all delete-btn" title="{{ t('Delete Company') }}"></a>

                    @if($company->logo !== "" && file_exists(public_path('uploads').'/'.$company->logo))
                         <img fg="d" src="{{ \Storage::url($company->logo) }}" class="logoImage from-img full-width" alt="{{ trans('metaTags.Go-Models') }}">
                    @else
                        <!-- <img srcset="http://gomodels.megavoov.com/images/icons/ico-nopic.png,
                             http://gomodels.megavoov.com/images/icons/ico-nopic@2x.png 2x,
                             http://gomodels.megavoov.com/images/icons/ico-nopic@3x.png 3x" src="http://gomodels.megavoov.com/images/icons/ico-nopic.png" alt="Go Models"> -->
                        <img srcset="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }},
                                             {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic@2x.png') }} 2x,
                                             {{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic@3x.png') }} 3x"
                                     src="{{ URL::to(config('app.cloud_url').'/images/icons/ico-nopic.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="from-img nopic full-width"/>
                    @endif

                </div>
                <div class="box-shadow bg-white pt-40 pr-20 pb-20 pl-30">
                    <?php $attr = ['countryCode' => config('country.icode'), 'id' => $company->id]; ?>
                    <a href="{{ lurl(trans('routes.v-account-companies-edit', $attr), $attr) }}" title="{{ str_limit($company->name) }}">
                        <span class="title">{{ str_limit($company->name, config('constant.title_limit')) }}</span>
                    </a>

                    <span>
                        <?php $attr = ['countryCode' => config('country.icode'), 'id' => $company->id]; ?>

                        @if($company->posts()->count() > 0 )
                            <?php /* <a href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}" class="">{{ $company->posts()->count() }} ( {{ t('Ads') }} )</a> */ ?>
                            {{ $company->posts()->count() }} ( {{ t('Ads') }} )
                        @else
                        {{ $company->posts()->count() }} ( {{ t('Ads') }} )
                        @endif
                    </span>

                    <div class="divider"></div>
                    <p class="mb-70" style="text-align: justify;"><?php echo str_limit(strip_tags($company->description, config('constant.description_limit'))); ?></p>
                    <?php /*
                    <div class="col-md-12 d-flex justify-content-end">
                        <span class="col-md-6 pt-20 pb-10 form-group custom-checkbox">
                            <input class="checkbox_field" id="studio_{{$k}}" name="entries[]" type="checkbox" value="{{ $company->id }}">
                            <label for="studio_{{$k}}" class="checkbox-label" title="{{ t('Delete') }}">{{ t('Delete') }}</label>
                        </span>
                        <div class="col-md-6" style="text-align: right;">
                            <a href="{{ lurl('account/companies/' . $company->id . '/edit') }}" title="{{ t('Edit') }}" class="btn btn-white mr-20 edit_grey position-relative align-self-end mini-all"></a>
                        </div>
                    </div> */?>

                   
                    <div class="d-flex justify-content-between">
                        <?php $attr = ['countryCode' => config('country.icode'), 'id' => $company->id]; ?>
                        <a href="{{ lurl(trans('routes.v-account-companies-edit', $attr), $attr) }}" class="btn btn-success edit mini-all" title="{{ t('Edit Company Details') }}"></a>


                       <!--  <a href="{{-- lurl('account/companies/' . $company->id . '/edit') --}}" class="btn btn-success edit mini-all"></a> -->
                        <span class="middle-checkbox">
                            <div class="col-md-6 form-group custom-checkbox">
                                <input class="checkbox_field" id="studio_{{$k}}" name="entries[]" type="checkbox" value="{{ $company->id }}">
                                <label for="studio_{{$k}}" class="checkbox-label">{{ t('Select') }}</label>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <div class="bg-white box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                    <h5 class="prata">{{ t('No records found') }}</h5>
            </div>
        @endif
        <?php /*
        @if(!empty( $companies ) && count($companies) > 0 ) 
            <div id="append-album">
            @foreach($companies as $k => $company) 
                    <div class="row mx-0 mx-xl-auto bg-white box-shadow position-relative justify-content-between pt-40 pr-20 pb-20 pl-30 mb-20 w-xl-1220" >
                        <div class="col-md-6 pr-md-2 bordered" >
                            <!-- <div class="modelcard-top text-uppercase f-12 d-flex align-items-center mb-30">
                                <span class="d-block" wfd-id="92">id number</span>
                                <span class="bullet rounded-circle bg-lavender d-block mx-2 mb-1""></span>
                                <span class="d-block" wfd-id="90">kategoria</span>
                            </div> -->
                            
                           <a href="{{ lurl('account/companies/' . $company->id . '/edit') }}" title="{{ str_limit($company->name) }}"><span class="title">{{ str_limit($company->name, 40) }}</span></a>

                            <span>
                                <?php $attr = ['countryCode' => config('country.icode'), 'id' => $company->id]; ?>
                                <a href="{{ lurl(trans('routes.v-search-company', $attr), $attr) }}" class="">{{ $company->posts()->count() }} ( {{ t('Ads') }} )</a>
                            </span>

                            <div class="divider" ></div>
                            <p class="mb-20">{{ str_limit($company->description, 100) }}</p>

                            <span class="pt-20 pb-10 form-group custom-checkbox">
                                <input class="checkbox_field" id="studio_{{$k}}" name="entries[]" type="checkbox" value="{{ $company->id }}">
                                <label for="studio_{{$k}}" class="checkbox-label" title="{{ t('Delete') }}">{{ t('Delete') }}</label>
                            </span>

                        </div>

                        <div class="col-md-6 pl-md-4 pt-58 pb-64 position-relative" >
                            <div class="d-flex justify-content-center align-items-center mb-sm-30 border bg-lavender msg-img-holder">
                                @if($company->logo !== "")
                                    <img class="logoImage" src="{{ resize(\App\Models\Company::getLogo($company->logo), 'medium') }}" class="from-img full-width" alt="user">&nbsp;
                                @else
                                    <img class="logoImage from-img full-width" src="{{ url('images/user.jpg') }}" alt="user">
                                @endif
                            </div>

                            <div class="d-flex align-self-end justify-content-end corner-btn" ><a href="{{ lurl('account/companies/' . $company->id . '/edit') }}" title="{{ t('Edit') }}" class="btn btn-white edit_grey position-relative align-self-end mini-all"></a></div>
                        </div>
                    </div>
              
            @endforeach
            </div>    
       
        @else
            <div class="bg-white box-shadow position-relative w-xl-1220 mx-xl-auto pt-40 pr-20 pb-20 pl-30 mb-30">
                    <h5 class="prata">{{ t('No records found') }}</h5>
            </div>
        @endif

        <?php */ ?>
        </form>
        
        @if(!empty( $companies ) && count($companies) > 0 )
            <div class="text-cente pt-40 mb-30 position-relative">
                @include('customPagination')
            </div>
        @endif

    </div>

@include('childs.bottom-bar')
@endsection

@section('after_scripts')
    <script>

        $(document).ready( function(){

            $('#company-search-submit').click( function(e){
                e.preventDefault();
                $("#search-form").submit();
            });

            $('#checkAll').click( function(){
                checkAll(this);
            });

            $('a.delete-btn, button.delete-btn').click(function(e)
            {
                
                
                e.preventDefault(); /* prevents the submit or reload */
                var confirmation = confirm("{{ t('Are you sure you want to perform this action?') }}");
                
                if (confirmation) {
                    if( $(this).is('a') ){
                        var url = $(this).attr('href');
                        if (url !== 'undefined') {
                            window.location.href = url;
                        }
                    } else {
                        var is_checked = false;
                        var chkinput = document.getElementsByTagName('input');
                        for (var i = 0; i < chkinput.length; i++) {
                            if (chkinput[i].type == 'checkbox') {
                                if($('#'+chkinput[i].id).prop("checked") == true){
                                   is_checked = true;
                                }
                            }
                        }

                        if(is_checked == false){
                           alert('{{ t("Please select an item from the list") }}');
                           return false; 
                        }
                        
                        $('form[name=listForm]').submit();
                    }
                    
                }
                
                return false;
            });

        });

        function checkAll(bx) {
            var chkinput = document.getElementsByTagName('input');
            for (var i = 0; i < chkinput.length; i++) {
                if (chkinput[i].type == 'checkbox') {
                    chkinput[i].checked = bx.checked;
                }
            }
        }
    </script>
@endsection