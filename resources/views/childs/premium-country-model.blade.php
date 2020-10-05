
@if(isset($is_ajax_request) && $is_ajax_request == true)
<div class="white-popup-block">
    
    @if(\Auth::check())

    @can('free_country_user', auth()->user())
    <h2 class="smaller">{{ t('Service Unavailable') }}</h2>
    @endcan

    @can('premium_country_free_user', auth()->user())
    <h2 class="smaller">{{ t('Go-premium and get the jobs') }}</h2>
    @endcan

    
    
    @can('free_country_user', auth()->user())
    <div class="bg-white">
        <p class="text-center prata">{{ t('service not available in your country') }}</p>
    </div>
    @endcan

    @can('premium_country_free_user', auth()->user())
    <div class="block margin-r-l no-pt">
        <div class="row no-pd text-center param-block">
            <p>{{ t('premium_benefit_para') }}</p>
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
                    <div class="desc_text icons-th">{{ t('Get new contacts') }}</div>
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
                <div class="justify-content-center align-items-center container-pop px-0 mt-40 btn">
                    <a href="{{  App\Helpers\CommonHelper::generateContractLink() }}" class="btn btn-success star">{{ t('Switch to premium') }}</a>
                </div>
            </div>
        @endif

        <div class="content-img margin-r-l ui-sortable header-h1">
            <div class="d-flex justify-content-center align-items-center container-pop px-0 pt-20">
                <a href="#" class="btn btn-white arrow_left">{{ t('Back') }}</a>
            </div>
        </div>
    </div>
    @endcan

    @endif
</div>
@else
<div class="modal fade " id="freejobs" tabindex="-1" role="dialog" style="top: 10% !important; z-index: 99999 !important;">
    <div class="modal-dialog full-width-modal" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom:none !important;">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">{{ t('Close') }}</span>
                </button>
            </div>

            @if(\Auth::check())
            
            <div class="container-pop pt-20  px-0">
                @can('free_country_user', auth()->user())
                <h2 class="text-center prata">{{ t('Service Unavailable') }}</h2>
                @endcan

                @can('premium_country_free_user', auth()->user())
                <h2 class="text-center prata lg-title">{{ t('Go-premium and get the jobs') }}</h2>
                @endcan

                
                <div class="position-relative">
                    <div class="divider mx-auto"></div>
                </div>

                <div class="bg-white">
                    <div class="px-38">
                        <div class="alert alert-danger print-error-msg" style="display:none"></div>
                    </div>
                </div>

                
                
                @can('free_country_user', auth()->user())
                <div class="bg-white">
                    <p class="text-center prata pad-30">{{ t('service not available in your country') }}</p>
                </div>
                @endcan

                @can('premium_country_free_user', auth()->user())
                <div class="block margin-r-l no-pt">
                    <div class="row no-pd text-center param-block">
                       <p>{{ t('premium_benefit_para') }}</p>
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

            @endcan

        </div>
        @endif
    </div>
</div>
</div>
@endif