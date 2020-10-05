@extends( Auth::User()->user_type_id == '2'  ?  'layouts.logged_in.app-partner' : 'layouts.logged_in.app-model' )
@section('content')
	@include('common.spacer')
   <!--  <div class="main-container"> -->
        <div class="container px-0 pt-40 pb-30">
            <h1 class="text-center prata">{{ t('Pricing') }}</h1>
                <div class="divider mx-auto"></div>
                <div class="custom-tabs mb-20 mb-xl-30">
                    @include('post.inc.wizard_new')
                </div>
                <div class="position-relative">
                    <h3 class="text-center pager">{{ t('Premium Ad') }}</h3>
                    <p class="text-center mb-30 w-lg-596 mx-lg-auto">
                        {{ t('The premium package help companies to promote their job ads by giving more visibility to their ads to attract more candidates and hire them faster') }}
                    </p>
                </div>
           
                @include('post.inc.notification')
                    <form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}">
                        {!! csrf_field() !!}
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                            @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
                                
                                     <div class="owl-carousel mb-60">
                                            <?php
												// Get Current Payment data
												$currentPaymentMethodId = 0;
												$currentPaymentActive = 1;
												if (isset($currentPayment) and !empty($currentPayment)) {
													$currentPaymentMethodId = $currentPayment->payment_method_id;
													if ($currentPayment->active == 0) {
														$currentPaymentActive = 0;
													}
												}
											?>
                                            @foreach ($packages as $package)
                                                <?php
                                                $currentPackageId = 0;
                                                $currentPackagePrice = 0;
                                                $packageStatus = '';
                                                $badge = '';
                                                if (isset($currentPaymentPackage) and !empty($currentPaymentPackage)) {
                                                    $currentPackageId = $currentPaymentPackage->tid;
                                                    $currentPackagePrice = $currentPaymentPackage->price;
                                                }
                                                // Prevent Package's Downgrading
                                                if ($currentPackagePrice > $package->price) {
                                                    $packageStatus = ' disabled';
                                                    $badge = t('Not available');
                                                } elseif ($currentPackagePrice == $package->price) {
                                                    $badge = '';
                                                } else {
                                                    $badge = t('Upgrade');
                                                }
                                                if ($currentPackageId == $package->tid) {
                                                    $badge = t('Current');
													if ($currentPaymentActive == 0) {
														$badge .= t('Payment pending');
													}
                                                }
                                                ?>
                                                    <div class="plan subscribed">
                                                        <div class="box-shadow bg-white text-center pt-40 pb-30 px-30 position-relative">
                                                            <a href="#" title="{{ t('Package Features') }}" data-featherlight="{{ url('posts/package/info/'.$package->id) }}" data-featherlight-type="ajax" data-featherlight-persist="true" class="position-absolute to-top-0 to-right-0 btn btn-primary zoom mini-all"></a>
                                                            <div class="mb-40 pb-40 bb-light-lavender3">
                                                                <h3 class="prata f-h2">{!! $package->name!!}</h3>
                                                                <div class="divider mx-auto"></div>
                                                                <div class="d-flex justify-content-center mb-20"><span class="bold f-h2">{{ $package->price }} &euro;</span><span> / {{ $package->duration }} {{ t('days') }}</span></div>
                                                                
                                                                <span id="tax-{{ $package->tid }}">
                                                                    <strong> {{ t('Tax') }} : </strong> {{ $package->tax ? $package->tax : '0.00' }}
                                                                </span>

                                                                <span class="bold pl-30 mb-20" style="display: none;" id="price-{{ $package->tid }}">
                                                                    <span class="price-int">{{ $package->price }}</span>
                                                                    <input type="hidden" id="{{ $package->tid }}-currency" value="{{ $package->currency_code }}">
                                                                    <span id="tax-{{ $package->tid }}">{{ $package->tax ? $package->tax : '0.00' }}
                                                                    </span>
                                                                </span>
                                                                <span class="bold pl-30 mb-20" style="display: none;" id="duration-{{ $package->tid }}">{{ $package->duration }} {{ t('days') }}</span>

                                                            </div>

                                                            <div class="text-center">
                                                                <div class="text-center custom-radio">
                                                                   <input class="radio_field package-selection" type="radio" name="package"
                                                                               id="package-{{ $package->tid }}"
                                                                               value="{{ $package->tid }}"
                                                                               data-name="{{ $package->name }}"
                                                                               data-currencysymbol="{{ $package->currency->symbol }}"
                                                                               data-currencyinleft="{{ $package->currency->in_left }}"
                                                                                {{ (old('package', $currentPackageId)==$package->tid) ? ' checked' : (($package->price==0) ? ' checked' : '') }} {{ $packageStatus }}>
                                                                         <label for="package-{{ $package->tid }}" title="{!! $package->description !!}" class="d-inline-block radio-label col-sm-6">{{ t('Package Name') }} {!! ($badge !== '')? '( '.$badge.' )' : '' !!}</label>
                                                                 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        <div class="box-shadow bg-white pt-40 pb-60 pb-xl-90 w-xl-1220 mx-xl-auto" id="packagesTable">
                                            <div class="w-lg-750 w-xl-970 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6 form-group mr-10">
                                                        <select class="form-control selecter" name="payment_method" id="payment_method">
                                                            @foreach ($paymentMethods as $paymentMethod)
                                                                @if (view()->exists('payment::' . $paymentMethod->name))
                                                                    <option value="{{ $paymentMethod->id }}" data-name="{{ $paymentMethod->name }}" {{ (old('payment_method')==$paymentMethod->id) ? 'selected="selected"' : '' }}>
                                                                        @if ($paymentMethod->name == 'offlinepayment')
                                                                            {{ trans('offlinepayment::messages.Offline Payment') }}
                                                                        @else
                                                                            {{ $paymentMethod->display_name }}
                                                                        @endif
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 form-group paybale-amount">
                                                        <p class="w-md-558 mx-auto bold">{{ t('Payable Amount') }} :
                                                            <span class="payable-amount col-md-4 position-relative">0</span>
                                                            <span class="price-currency amount-currency currency-in-right col-md-4 position-relative"></span>
                                                         </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div  class="col-md-12 form-group mb-20">
                                                @if (isset($paymentMethods) and $paymentMethods->count() > 0)
                                                    <!-- Payment Plugins -->
                                                    <?php $hasCcBox = 0; ?>

                                                    @foreach($paymentMethods as $paymentMethod)
                                                        @if (view()->exists('payment::' . $paymentMethod->name))
                                                            @include('payment::' . $paymentMethod->name, [$paymentMethod->name . 'PaymentMethod' => $paymentMethod])
                                                        @endif
                                                        <?php if ($paymentMethod->has_ccbox == 1 && $hasCcBox == 0) $hasCcBox = 1; ?>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                           
                            
                           @include('childs.payemnt-button')
                        
                    </form>
                <!-- /.page-content -->
           
        </div>
   <!--  </div> -->
@endsection
@section('after_styles')
<style>
    .paybale-amount span {
        display: inline !important;
    }
</style>
@endsection

@section('after_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
    @if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
        <script src="{{ url(config('app.cloud_url') .'/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}" type="text/javascript"></script>
    @endif

    <script>
        @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
			
			var currentPackagePrice = {{ $currentPackagePrice }};
			var currentPaymentActive = {{ $currentPaymentActive }};
			$(document).ready(function ()
			{
				/* Show price & Payment Methods */
				var selectedPackage = $('input[name=package]:checked').val();
				var packagePrice = getPackagePrice(selectedPackage);
				var packageCurrencySymbol = $('input[name=package]:checked').data('currencysymbol');
				var packageCurrencyInLeft = $('input[name=package]:checked').data('currencyinleft');
				var paymentMethod = $('#payment_method').find('option:selected').data('name');
				showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
				showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod);
		
				/* Select a Package */
				$('.package-selection').click(function () {
					selectedPackage = $(this).val();
					packagePrice = getPackagePrice(selectedPackage);
					packageCurrencySymbol = $(this).data('currencysymbol');
					packageCurrencyInLeft = $(this).data('currencyinleft');
					showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
					showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod);
				});
				
				/* Select a Payment Method */
				$('#payment_method').on('change', function () {
					paymentMethod = $(this).find('option:selected').data('name');
					showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod);
				});
				
				/* Form Default Submission */
				$('#submitPostForm').on('click', function (e) {
					e.preventDefault();
					
					if (packagePrice <= 0) {
						$('#postForm').submit();
					}
					
					return false;
				});
			});
		
        @endif

		/* Show or Hide the Payment Submit Button */
		/* NOTE: Prevent Package's Downgrading */
		/* Hide the 'Skip' button if Package price > 0 */
		function showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod)
		{
			if (packagePrice > 0) {
				$('#submitPostForm').show();
				$('#skipBtn').hide();
		
				if (currentPackagePrice > packagePrice) {
					$('#submitPostForm').hide();
				}
				if (currentPackagePrice == packagePrice) {
					if (paymentMethod == 'offlinepayment' && currentPaymentActive != 1) {
						$('#submitPostForm').hide();
						$('#skipBtn').show();
					}
				}
			} else {
				$('#skipBtn').show();
			}
		}

       
    </script>
    <script>
         function showAmount(t, e, i) {
            $(".payable-amount").html(t), $(".amount-currency").html(e), 1 == i ? ($(".amount-currency.currency-in-left").show(), $(".amount-currency.currency-in-right").hide()) : ($(".amount-currency.currency-in-left").hide(), $(".amount-currency.currency-in-right").show()), t <= 0 ? $("#packagesTable").hide() : $("#packagesTable").show()
        }

        function getPackagePrice(t) {
            var e = $("#price-" + t + " .price-int").html();
            return e = parseFloat(e)
        }
    </script>
@endsection
@push('scripts')
    <script>
        $('.owl-carousel').owlCarousel({
            dots: false,
            margin: 20,
            autoHeight: true,
            responsive: {
                0: {
                    items: 1
                },
                979:{
                    items: 2
                }
            }
        })
    </script>
@endpush
