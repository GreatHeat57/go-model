@if(isset($is_ajax_request) && $is_ajax_request == true)
    <div class="white-popup-block" id="mfp-sign-up">

        
        @can('free_country_user', auth()->user())
            <h2 class="smaller">{{ t('Service Unavailable') }}</h2>
        @endcan

      
        @if(\Auth::check())
                        
            @can('free_country_user', auth()->user())
                <div class="bg-white">
                    <p class="text-center prata">{{ t('service not available in your country') }}</p>
                </div>
            @endcan
     

        @endif

        
    </div>
@else
    <div class="modal fade " id="free-model" tabindex="-1" role="dialog" style="top: 10% !important; z-index: 99999 !important;">
        <div class="modal-dialog modal-lg full-width-modal" role="document">
            <div class="modal-content">
                
                <div class="modal-header" style="border-bottom:none !important;">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">{{ t('Close') }}</span>
                    </button>
                </div>
                <div class="container pt-20  px-0">

                    
                    @can('free_country_user', auth()->user())
                        <h2 class="text-center prata">{{ t('Service Unavailable')  }}</h2>
                    @endcan

                                      
                    <div class="position-relative">
                        <div class="divider mx-auto"></div>
                    </div>

                    <div class="bg-white">
                        <div class="px-38">
                            <div class="alert alert-danger print-error-msg" style="display:none"></div>
                        </div>
                    </div>

                    @if(\Auth::check())
                        
                        @can('free_country_user', auth()->user())
                            <div class="bg-white">
                                <p class="text-center prata">{{ t('service not available in your country') }}</p>
                            </div>
                        @endcan
                        
                    @endif
                       
                </div>
            </div>
        </div>
    </div>
@endif
