@if(isset($is_ajax_request) && $is_ajax_request == true)
    
    <div class="white-popup-block mfp-width pb-no">
        
        @if(\Auth::check())

            @can('premium_country_free_user', auth()->user())
                <h2 class="smaller">{{ t('Your benefits with Premium account') }}</h2>
            @endcan


            @can('premium_country_free_user', auth()->user())
                <div class="block margin-r-l">
                    <div class="image-and-text-rows no-pd top-0">
                        <div class="row no-pd">
                            <div class="imgcontentwrapper oddsectionwrap">
                                <div class="oddevencontentwrap">
                                    <ul>
                                        <li>{{ t('premium_benefit_li_1') }}</li>
                                        <li>{{ t('premium_benefit_li_2') }}</li>
                                        <li>{{ t('premium_benefit_li_3') }}</li>
                                    </ul>
                                </div>
                                <div class="oddevenimgwrap">
                                    <img src="{{ url(config('app.cloud_url') . '/images/jobs.jpg') }}" alt="jobs">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block block-pink">
                    <div class="content-img margin-r-l ui-sortable header-h1">
                        <h2 class="text-center prata lg-title">{{ t('New jobs and contest each month') }}</h2>
                        <!-- <div class="position-relative">
                            <div class="divider mx-auto"></div>
                        </div> -->
                        <div class="four_column tags"> 
                            <div class="column_item">
                                <div class="img_circle">
                                    <img src="{{ url(config('app.cloud_url') . '/images/icons/money-icon.png') }}" class="img_icon">
                                </div>  
                               <div class="desc_text icons-th"> {{ t('Earn Money') }} </div>
                            </div>
                            <div class="column_item">
                                <div class="img_circle">
                                    <img src="{{ url(config('app.cloud_url') . '/images/icons/promote-icon.png') }}" class="img_icon">
                                </div>  
                                <div class="desc_text icons-th"> {{ t('Promote yourself') }} </div>
                            </div>
                            <div class="column_item">
                                <div class="img_circle">
                                    <img src="{{ url(config('app.cloud_url') . '/images/icons/profile-icon.png') }}" class="img_icon">
                                </div>  
                                <div class="desc_text icons-th"> {{ t('Improve your profile') }} </div>
                            </div>
                            <div class="column_item">
                                <div class="img_circle">
                                    <img src="{{ url(config('app.cloud_url') . '/images/icons/contacts-icon.png') }}" class="img_icon">
                                </div>  
                                <div class="desc_text icons-th">{{ t('Get new contacts') }}</div>
                            </div>
                        </div>
                        <div class="justify-content-center align-items-center container-pop px-0 pt-20 mt-10 btn">
                            <a href="{{  App\Helpers\CommonHelper::generateContractLink() }}" class="btn btn-success star">{{ t('Switch to premium') }}</a>
                        </div>
                    </div>
                </div>

                <div class="block margin-r-l">
                    <div class="row no-pd text-center param-block">
                        <h2 class="text-center prata lg-title">{{ t('Free vs Premium') }}</h2>
                        <!-- <div class="position-relative">
                            <div class="divider mx-auto"></div>
                        </div> -->
                        <p class="text-center">{{ t('free_vs_premium_para') }}</p>
                        <div class="chart-table">
                            <table width="100%">
                                <thead>
                                    <tr>
                                        <th class="disable-th item-name">{{ t('Service') }}</th>
                                        <th class="disable-th">{{ t('Free user account') }}</th>
                                        <th class="enable-th stra-icon back-img">{{ t('Premium account') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_1') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_2') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_3') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                     <tr>
                                        <td class="item-name">{{ t('compare_table_label_4') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                     <tr>
                                        <td class="item-name">{{ t('compare_table_label_5') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_6') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_7') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td> 
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_8') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td> 
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_9') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td> 
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                     <tr>
                                        <td class="item-name">{{ t('compare_table_label_10') }}</td>
                                        <td class="diable-item green-title">{{ t('Yes') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_11') }}</td>
                                        <td class="diable-item green-title">{{ t('Yes') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="content-img margin-r-l ui-sortable header-h1">
                                <div class="justify-content-center align-items-center container-pop px-0 mt-10 btn">
                                    <a href="{{  App\Helpers\CommonHelper::generateContractLink() }}" class="btn btn-success star">{{ t('Switch to premium') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block block-pink latest-job-sections">
                    <div class="have-a-job job-list-white">
                       <h2 class="text-center prata lg-title">{{ t('Your personalized jobs list') }}</h2>
                       <div class="text-center">
                           <p class="job-list-para">{{ t('Your personalized jobs list paragraph') }}</p>
                        </div>
                        <div class="content-img margin-r-l ui-sortable header-h1">
                            <div class="justify-content-center align-items-center container-pop px-0 pt-20 mt-10 btn">
                                <a href="{{ lurl(trans('routes.search', ['countryCode' => config('country.icode')]), ['countryCode' => config('country.icode')]) }}" class="btn btn-white arrow_left ">{{ t('Check Jobs list') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="block">

                    @if(isset($joblist) && !empty($joblist))
                        <div class="content-img margin-r-l ui-sortable header-h1">
                            <div class="justify-content-center align-items-center container-pop px-0 mt-40 btn">
                                <a href="{{  App\Helpers\CommonHelper::generateContractLink() }}" class="btn btn-success star">{{ t('Switch to premium') }}</a>
                            </div>
                        </div>
                    @endif

                    <div class="content-img margin-r-l ui-sortable header-h1">
                        <div class="justify-content-center align-items-center container-pop px-0 btn">
                            <a href="#" class="btn btn-white arrow_left pre-back">{{ t('Back') }}</a>
                        </div>
                    </div>
                </div>
            @endcan

        @endif
    </div>

@else
    <div class="modal fade " id="go-premium" role="dialog"  tabindex="-1" style="top: 10% !important; z-index: 99999 !important;">
        <div class="modal-dialog  full-width-modal" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom:none !important;">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">{{ t('Close') }}</span>
                    </button>
                </div>
                <div class="container-pop pt-20  px-0">
                    <h2 class="text-center prata lg-title">{{ t('Your benefits with Premium account') }}</h2>

                    <div class="position-relative">
                       <div class="divider mx-auto"></div>
                    </div>

                    <div class="bg-white">
                        <div class="px-38">
                            <div class="alert alert-danger print-error-msg" style="display:none"></div>
                        </div>
                    </div>

                    <div class="block margin-r-l">
                        <div class="image-and-text-rows no-pd top-0">
                            <div class="row no-pd">
                                <div class="imgcontentwrapper oddsectionwrap">
                                    <div class="oddevencontentwrap">
                                        <ul>
                                            <li>{{ t('premium_benefit_li_1') }}</li>
                                            <li>{{ t('premium_benefit_li_2') }}</li>
                                            <li>{{ t('premium_benefit_li_3') }}</li>
                                        </ul>
                                    </div>
                                    <div class="oddevenimgwrap">
                                        <img src="{{ url(config('app.cloud_url') . '/images/jobs.jpg') }}" alt="jobs">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block block-pink">
                        <div class="content-img margin-r-l ui-sortable header-h1">
                            <h2 class="text-center prata lg-title">{{ t('New jobs and contest each month') }}</h2>
                            <div class="position-relative">
                                <div class="divider mx-auto"></div>
                            </div>
                            <div class="four_column tags"> 
                                <div class="column_item">
                                    <div class="img_circle">
                                        <img src="{{ url(config('app.cloud_url') . '/images/icons/money-icon.png') }}" class="img_icon">
                                    </div>  
                                    <div class="desc_text icons-th"> {{ t('Earn Money') }} </div>
                                </div>
                                <div class="column_item">
                                    <div class="img_circle">
                                        <img src="{{ url(config('app.cloud_url') . '/images/icons/promote-icon.png') }}" class="img_icon">
                                    </div>  
                                    <div class="desc_text icons-th"> {{ t('Promote yourself') }} </div>
                                </div>
                                <div class="column_item">
                                    <div class="img_circle">
                                        <img src="{{ url(config('app.cloud_url') . '/images/icons/profile-icon.png') }}" class="img_icon">
                                    </div>  
                                    <div class="desc_text icons-th"> {{ t('Improve your profile') }} </div>
                                </div>
                                <div class="column_item">
                                    <div class="img_circle">
                                        <img src="{{ url(config('app.cloud_url') . '/images/icons/contacts-icon.png') }}" class="img_icon">
                                    </div>  
                                    <div class="desc_text icons-th"> {{ t('Get new contacts') }} </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center container-pop px-0 pt-20">
                                <a href="{{  App\Helpers\CommonHelper::generateContractLink() }}" class="btn btn-success star">{{ t('Switch to premium') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="block margin-r-l">
                        <div class="row no-pd text-center param-block">
                            <h2 class="text-center prata lg-title">{{ t('Free vs Premium') }}</h2>
                            <div class="position-relative">
                                <div class="divider mx-auto"></div>
                            </div>
                            <p>{{ t('free_vs_premium_para') }}</p>
                            <div class="chart-table">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <th class="disable-th item-name">{{ t('Service') }}</th>
                                            <th class="disable-th">{{ t('Free user account') }}</th>
                                            <th class="enable-th stra-icon back-img">{{ t('Premium account') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_1') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_2') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_3') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                     <tr>
                                        <td class="item-name">{{ t('compare_table_label_4') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                     <tr>
                                        <td class="item-name">{{ t('compare_table_label_5') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_6') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_7') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td> 
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_8') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td> 
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_9') }}</td>
                                        <td class="diable-item gray-title">{{ t('No') }}</td> 
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                     <tr>
                                        <td class="item-name">{{ t('compare_table_label_10') }}</td>
                                        <td class="diable-item green-title">{{ t('Yes') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="item-name">{{ t('compare_table_label_11') }}</td>
                                        <td class="diable-item green-title">{{ t('Yes') }}</td>
                                        <td class="enable-item green-title">{{ t('Yes') }}</td>
                                    </tr>
                                </tbody>
                                </table>
                                <div class="content-img margin-r-l ui-sortable header-h1">
                                    <div class="d-flex justify-content-center align-items-center container-pop px-0">
                                        <a href="{{  App\Helpers\CommonHelper::generateContractLink() }}" class="btn btn-success star">{{ t('Switch to premium') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php /*
                    @if(isset($joblist) && !empty($joblist))
                    <div class="block block-pink latest-job-sections">
                        <div class="content-img margin-r-l ui-sortable header-h1">
                            <h2 class="text-center prata lg-title">{{ t('popup_latest_jobs') }}</h2>
                            
                            <div class="position-relative">
                                <div class="divider mx-auto"></div>
                            </div>
                            
                            @foreach($joblist as $post)
                                <div class="have-a-job mob-have margin-l-r-no margin-padding-t-b-no">
                                    <div class="row">
                                        <div class="col-md-10 col-sm-12 title-col-left">
                                            <h3 class="have-job-title"><a href="{{ $post['link'] }}">{{ $post['title'] }}</a></h3>
                                        </div>
                                        <div class="col-md-2 col-sm-12 img-col-right">
                                            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" class="two-col-image">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                           

                           <div class="content-img margin-r-l ui-sortable header-h1">
                                <div class="justify-content-center align-items-center container-pop px-0 mt-10 btn d-flex">
                                    <a href="{{ lurl(trans('routes.search', ['countryCode' => config('country.icode')]), ['countryCode' => config('country.icode')]) }}" class="btn btn-white no-bg"></a>
                                </div>
                            </div>
                            

                        </div>
                    </div>
                    @endif
                    */ ?>

                    <div class="block block-pink latest-job-sections">
                        <div class="have-a-job job-list-white">
                            <h2 class="text-center prata lg-title">{{ t('Your personalized jobs list') }}</h2>
                            
                            <div class="position-relative">
                                <div class="divider mx-auto"></div>
                            </div>
                           <div class="text-center">
                               <p class="job-list-para">{{ t('Your personalized jobs list paragraph') }}</p>
                            </div>
                            <div class="content-img margin-r-l ui-sortable header-h1">
                                <div class="justify-content-center align-items-center container-pop px-0 mt-10 d-flex">
                                    <a href="{{ lurl(trans('routes.search', ['countryCode' => config('country.icode')]), ['countryCode' => config('country.icode')]) }}" class="btn btn-white arrow_left ">{{ t('Check Jobs list') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="block">
                        
                        @if(isset($joblist) && !empty($joblist))
                            <div class="content-img margin-r-l ui-sortable header-h1">
                                <div class="justify-content-center align-items-center container-pop px-0 btn d-flex">
                                    <a href="{{  App\Helpers\CommonHelper::generateContractLink() }}" class="btn btn-success star">{{ t('Switch to premium') }}</a>
                                </div>
                            </div>
                        @endif

                        <div class="content-img margin-r-l ui-sortable header-h1">
                            <div class="d-flex justify-content-center align-items-center container-pop px-0">
                                <a href="#" class="btn btn-white arrow_left pre-back">{{ t('Back') }}</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif

@if(isset($is_ajax_request) && $is_ajax_request == true)
    <style type="text/css">
        .mfp-width { max-width: 1024px !important;  }
        .white-popup-block { padding-left: 0px !important; padding-right: 0px !important; }
        .have-job-title { text-align: center !important; }
        .btn.star { background-repeat: no-repeat !important;  }

        .btn.btn-success{
            background-color: #06c67b;
            border: 1px solid #06c67b !important;
            color: #fff;
        }
        .btn.star {
            height: 54px;
            line-height: 56px;
            padding: 0 35px 0 57px;
            background-position: 30px center;
            background-repeat: no-repeat;
            background-size: 17px;
            text-indent: 0;
            letter-spacing: 0.9px;
            background-image: url(/images/icons/ico-btn-refresh.png);
            background-image: -webkit-image-set(url(/images/icons/ico-btn-refresh.png) 1x, url(/images/icons/ico-btn-refresh@2x.png) 2x, url(/images/icons/ico-btn-refresh@3x.png) 3x);
            background-image: image-set(url(/images/icons/ico-btn-refresh.png) 1x, url(/images/icons/ico-btn-refresh@2x.png) 2x, url(/images/icons/ico-btn-refresh@3x.png) 3x);
        }

        .btn.star-bk {
            height: 54px;
            line-height: 56px;
            padding: 0 35px 0 57px;
            background-position: 30px center;
            background-repeat: no-repeat;
            background-size: 17px;
            text-indent: 0;
            letter-spacing: 0.9px;
            background-image: url(/images/icons/ico-btn-star-bk.png);
            background-image: -webkit-image-set(url(/images/icons/ico-btn-star-bk.png) 1x, url(/images/icons/ico-btn-star-bk@2x.png) 2x, url(/images/icons/ico-btn-star-bk@3x.png) 3x);
            background-image: image-set(url(/images/icons/ico-btn-star-bk.png) 1x, url(/images/icons/ico-btn-star-bk@2x.png) 2x, url(/images/icons/ico-btn-star-bk@3x.png) 3x);
        }


        .btn.arrow_left {
            height: 54px;
            line-height: 56px;
            padding: 0 35px 0 57px;
            background-position: 30px center;
            background-repeat: no-repeat;
            background-size: 17px;
            text-indent: 0;
            letter-spacing: 0.9px;
            background-image: url(/images/icons/ico-arrow-left.png);
            background-image: -webkit-image-set(url(/images/icons/ico-arrow-left.png) 1x, url(/images/icons/ico-arrow-left@2x.png) 2x, url(/images/icons/ico-arrow-left@3x.png) 3x);
            background-image: image-set(url(/images/icons/ico-arrow-left.png) 1x, url(/images/icons/ico-arrow-left@2x.png) 2x, url(/images/icons/ico-arrow-left@3x.png) 3x);
        }

        .btn.plain {
            height: 54px;
            line-height: 56px;
            padding: 0 35px 0 57px;
            background-position: 30px center;
            background-repeat: no-repeat;
            background-size: 17px;
            text-indent: 0;
            letter-spacing: 0.9px;
        }
        .mt-10 { margin-top: 10px; }
        .mt-20 { margin-top: 20px; }
        .pb-no { padding-bottom: 0px !important; }

        .two-col-image{ max-width: 145px !important; height: 140px !important; }

        @media (max-width: 768px){
            .chart-table table, th {  font-size: 14px !important; line-height: 16px; }
            .back-img { background-image: none !important; }
            /*.latest-job-sections { display: none; }*/
            .go-header { display: none !important; }
        }
        
    </style>
@endif

{{ Html::style(config('app.cloud_url').'/css/premium-popup.css') }}