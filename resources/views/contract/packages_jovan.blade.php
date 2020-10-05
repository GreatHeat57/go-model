{{--
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
--}}
@extends('layouts.app')

@section('content')

<div class="cover" style="height: initial;">
    <img src="{{ url(config('app.cloud_url') . '/images/covers/contract_payment.png') }}" alt="contract">
    <div class="inner">
        <div class="text">
            <div class="holder">
                <h2>{{ t('Your Contract') }}</h2>
            </div>
        </div>
    </div>
</div>
{{ Html::style(config('app.cloud_url').'/css/bladeCss/contractPackage-blade.css') }}
   
<div class="container page-content pt-20" id="contract-profile">
    @include('contract.inc.notification')
</div>
    
@include('contract.inc.wizard')
<link href="{{ url(config('app.cloud_url').'/assets/css/wizard.css') }}" rel="stylesheet">
<script type="application/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="application/javascript" src="{{ url(config('app.cloud_url').'/assets/js/jquery.payment.min.js') }}"></script>
@if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
    <script src="{{ url(config('app.cloud_url') . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}" type="application/javascript"></script>
@endif
<div class="container page-content pt-20 pb-150" id="contract-profile">
    <div class="row">
        <div class="bg-white box-shadow full-width p-2">
            <div class="col-md-12 col-xs-12 col-sm-12 float-left">
                <div class="inner-box category-content">
                    <div class="row mb-20">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12" style="float:left;padding-top:40px;padding-left:20px;">
                                <h1>Choose your payment method</h1>
                                <p style="text-align:justify;font-size:24px;" class="text-center">
                                    {{ t('The premium package help companies to promote their job ads by giving more visibility to their ads to attract more candidates and hire them faster') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php /*
                        <!-- <div class="col-md-12" style="float:right;text-align:center;padding:20px;"> --> */ ?>
                        <div class="" style="width:900px; margin:0 auto;">
                                <fieldset>
                                    @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
                                            <div class="table-responsive">
                                                <table id="packagesTable" class="table table-hover checkboxtable" style="margin-bottom: 0;" width="100%">
                                                    <thead>
                                                        <tr style="box-sizing:inherit;">
                                                            <th>{{ t('Package Name') }}</th>
                                                            <th>{{ t('Price') }}</th>
                                                            <th>{{ t('Tax percentage') }}</th>
                                                            <th>{{ t('Duration') }}</th>
                                                            <th>{{ t('Total') }}</th>
                                                        </tr>
                                                    </thead>
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
                                                            $seleted_package_checked = 0;
                    
                                                            if (isset($currentPaymentPackage) and !empty($currentPaymentPackage)) {
                                                            	$currentPackageId = $currentPaymentPackage->tid;
                                                            	$currentPackagePrice = $currentPaymentPackage->price;
                                                            }else{
                                                                if(isset($seleted_package_id) && !empty($seleted_package_id)){
                                                                    if($package->id == $seleted_package_id){
                                                                        $seleted_package_checked = 1;
                                                                    }
                                                                }
                                                            }
                                                            // Prevent Package's Downgrading
                                                            if ($currentPackagePrice > $package->price) {
                                                            	$packageStatus = ' disabled';
                                                            	$badge = ' <span class="label label-danger">' . t('Not available') . '</span>';
                                                            } elseif ($currentPackagePrice == $package->price) {
                                                            	$badge = '';
                                                                $seleted_package_checked = 1;
                                                            } else {
                                                            	/* // $badge = ' <span class="label label-success">' . t('Upgrade') . '</span>'; */
                                                            }
                                                            if ($currentPackageId == $package->id) {
                                                            	$badge = ' <span class="label label-default">' . t('Current') . '</span>';
                                                            	if ($currentPaymentActive == 0) {
                                                            		$badge .= ' <span class="label label-warning">' . t('Payment pending') . '</span>';
                                                            	}
                                                            }
                                                        ?>
                                                        <tr>
                                                        <td data-label="{{ t('Package')}}">
                                                                <div class="radio custom-radio" style="display:none;">
                                                                    <input class="package-selection radio_field" type="radio" name="package"
                                                                        id="package_{{ $package->id }}"
                                                                        value="{{ $package->id }}"
                                                                        data-name="{{ $package->name }}"
                                                                        data-price="{{ $package->price }}"
                                                                        data-tax="{{ $package->tax ? $package->tax : '0.00' }}"
                                                                        data-currencysymbol="{{ $package->currency->symbol }}"
                                                                        data-currencycode="{{ $package->currency->code }}"
                                                                        data-currencyinleft="{{ $package->currency->in_left }}"
                                                                        required
                                                                        {{ (($seleted_package_checked == 1) ? ' checked' : '') }} {{ $packageStatus }}>
                                                                    <label class="radio-label" for="package_{{ $package->id }}" title="{{$package->description}}" style="background-position-y: top;">
                                                                        <strong>{!! $package->name . $badge !!} </strong>
                                                                    </label>
                                                                </div>
                                                                <p title="{{$package->description}}" >{!! $package->name . $badge !!}</p>
                                                            </td>
                                                            <td data-label="{{ t('Price') }}">
                                                                <p id="price-{{ $package->id }}">
                                                                    @if ($package->currency->in_left == 1)
                                                                        <span class="price-currency">{{ $package->currency->symbol }}</span>
                                                                    @endif
                                                                    <span class="price-int">{{ $package->price }}</span>
                                                                    <input type="hidden" name="tax" class="tax-int" id="tax-int" value="{{ $package->tax }}">
                                                                    <input type="hidden" id="{{ $package->id }}-currency" value="{{ $package->currency_code }}">
                                                                    
                                                                    @if ($package->currency->in_left == 0)
                                                                        <span class="price-currency">{{ $package->currency->symbol }}</span>
                                                                    @endif
                                                                </p>
                                                            </td>
                                                            <td data-label="{{ t('Tax percentage') }}">
                                                                <p id="tax-{{ $package->id }}">
                                                                    <span class="tax-int">{{ $package->tax ? $package->tax : '0.00' }}</span>
                                                                </p>
                                                            </td>
                                                            <td data-label="{{ t('Duration') }}">
                                                                <p id="duration-{{ $package->id }}">
                                                                    <span class="duration-int">{{ $package->duration }} {{ t($package->duration_period) }}</span>
                                                                </p>
                                                            </td>
                                                            <td data-label="{{ t('Total') }}" class="paymentTotal">
                                                                <p id="total-{{ $package->id }}">
                                                                    <?php $total_amount = round( $package->price + (($package->price * $package->tax)/ 100), 2); ?>
                                                                    @if ($package->currency->in_left == 1)
                                                                        <span class="price-currency">{{ $package->currency->symbol }}</span>
                                                                    @endif
                                                                    <span class="duration-int">{{ number_format(round($total_amount), 2) }}</span>
                                                                    @if ($package->currency->in_left == 0)
                                                                        <span class="price-currency">{{ $package->currency->symbol }}</span>
                                                                    @endif
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="5" class="paymentLabel">
                                                            <p style="margin-top: 7px;">
                                                                <strong>
                                    								{{ t('Payable Amount') }} :
                                    								<span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
                                    								<span class="payable-amount">0</span>
                                    								<span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
                                                                    <span id="tax-calculation"></span>
                                                                </strong>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="payment-method-title">
                                                <p>Payment method:</p>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                    <div class="payment-method" data-method="credit">
                                                        <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_credit.png') }}"/>
                                                        <p>{{ 'CREDIT CARD' }}</p>
                                                        <div class="radio custom-radio">
                                                            <input class="radio_field" type="radio" id="payment_credit" name="payment_method" value="credit">
                                                            <label for="payment_credit" class="radio-label">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                    <div class="payment-method" data-method="ideal">
                                                        <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_ideal.png') }}"/>
                                                        <p>{{ 'iDEAL' }}</p>
                                                        <div class="radio custom-radio">
                                                            <input class="radio_field" type="radio" id="payment_ideal" name="payment_method" value="ideal">
                                                            <label for="payment_ideal" class="radio-label">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                    <div class="payment-method" data-method="eps">
                                                        <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_eps.png') }}"/>
                                                        <p>{{ 'EPS' }}</p>
                                                        <div class="radio custom-radio">
                                                            <input class="radio_field" type="radio" id="payment_eps" name="payment_method" value="eps">
                                                            <label for="payment_eps" class="radio-label">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                    <div class="payment-method" data-method="giropay">
                                                        <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_giropay.png') }}"/>
                                                        <p>{{ 'GIROPAY' }}</p>
                                                        <div class="radio custom-radio">
                                                            <input class="radio_field" type="radio" id="payment_giropay" name="payment_method" value="giropay">
                                                            <label for="payment_giropay" class="radio-label">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                    <div class="payment-method" data-method="sofort">
                                                        <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_sofort.png') }}"/>
                                                        <p>{{ 'SOFORT' }}</p>
                                                        <div class="radio custom-radio">
                                                            <input class="radio_field" type="radio" id="payment_sofort" name="payment_method" value="sofort">
                                                            <label for="payment_sofort" class="radio-label">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                    <div class="payment-method" data-method="applepay">
                                                        <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_applepay.png') }}"/>
                                                        <p>{{ 'APPLE PAY' }}</p>
                                                        <div class="radio custom-radio">
                                                            <input class="radio_field" type="radio" id="payment_applepay" name="payment_method" value="applepay">
                                                            <label for="payment_applepay" class="radio-label">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                    <div class="payment-method" data-method="paypal">
                                                        <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_paypal.png') }}"/>
                                                        <p>{{ 'PAYPAL' }}</p>
                                                        <div class="radio custom-radio">
                                                            <input class="radio_field" type="radio" id="payment_paypal" name="payment_method" value="paypal">
                                                            <label for="payment_paypal" class="radio-label">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                    <div class="payment-method" data-method="bank">
                                                        <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_bank.png') }}"/>
                                                        <p>{{ 'BANK TRANSFER' }}</p>
                                                        <div class="radio custom-radio">
                                                            <input class="radio_field" type="radio" id="payment_bank" name="payment_method" value="bank">
                                                            <label for="payment_bank" class="radio-label">&nbsp;</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="payment-form-wrapper">
                                                <div class="col-md-8 offset-md-2 col-sm-12 offset-sm-0 payment-method-form payment-form-credit" id="payment-form-credit">
                                                    <div class="payment-method-form-outer">
                                                        <span class="btn-close">CLOSE &times;</span>
                                                        <div class="payment-method-form-inner">
                                                            <div class="row">
                                                                <div class="field">
                                                                    <label for="credit-cardholder" class="required">Cardholder</label>
                                                                    <input id="credit-cardholder" class="input" type="text" placeholder="" required autocomplete="name">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="field">
                                                                    <label for="credit-element" class="required">Card</label>
                                                                    <div id="credit-element" class="input">
                                                                        <!-- Elements will create input elements here -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- We'll put the error messages in this element -->
                                                            <div id="credit-errors" role="alert"></div>
                                                            <button id="credit-submit">Pay</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 offset-md-2 col-sm-12 offset-md-0 payment-method-form payment-form-credit" id="payment-form-ideal">
                                                    <div class="payment-method-form-outer">
                                                        <span class="btn-close">CLOSE &times;</span>
                                                        <div class="payment-method-form-inner">
                                                            <form id="form-ideal-payment">
                                                                <div class="row">
                                                                    <div class="field">
                                                                        <label for="ideal-name" class="required">Name</label>
                                                                        <input id="ideal-name" class="input" type="text" placeholder="" required autocomplete="name">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="field">
                                                                        <label for="ideal-element" class="required">iDeal Bank</label>
                                                                        <div id="ideal-element" class="input">
                                                                            <!-- Elements will create input elements here -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button id="ideal-submit">Pay</button>
                                                                <!-- We'll put the error messages in this element -->
                                                                <div id="ideal-errors" role="alert"></div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 offset-md-2 col-sm-12 offset-md-0 payment-method-form payment-form-credit" id="payment-form-eps">
                                                    <div class="payment-method-form-outer">
                                                        <span class="btn-close">CLOSE &times;</span>
                                                        <div class="payment-method-form-inner">
                                                            <button id="payment-eps-submit">EPS Pay</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 offset-md-2 col-sm-12 offset-md-0 payment-method-form payment-form-credit" id="payment-form-giropay">
                                                    <div class="payment-method-form-outer">
                                                        <span class="btn-close">CLOSE &times;</span>
                                                        <div class="payment-method-form-inner">
                                                            <button id="payment-giropay-submit">GIROPAY Pay</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 offset-md-2 col-sm-12 offset-md-0 payment-method-form payment-form-credit" id="payment-form-sofort">
                                                    <div class="payment-method-form-outer">
                                                        <span class="btn-close">CLOSE &times;</span>
                                                        <div class="payment-method-form-inner">
                                                            <button id="payment-sofort-submit">SOFORT Pay</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 offset-md-2 col-sm-12 offset-md-0 payment-method-form payment-form-credit" id="payment-form-applepay">
                                                    <div class="payment-method-form-outer">
                                                        <span class="btn-close">CLOSE &times;</span>
                                                        <div class="payment-method-form-inner">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8 offset-md-2 col-sm-12 offset-md-0 payment-method-form payment-form-credit" id="payment-form-paypal">
                                                    <div class="payment-method-form-outer">
                                                        <span class="btn-close">CLOSE &times;</span>
                                                        <div class="payment-method-form-inner">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 payment-method-form" id="payment-form-bank">
                                                    <div class="payment-method-form-outer">
                                                        <span class="btn-close">CLOSE &times;</span>
                                                        <div class="payment-method-form-inner">
                                                            <div class="col-md-6 btn">
                                                                <button id="payment-card-submit" class="green next submitPostForm">Bank Transfer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="div-alert"></div>
                                                <div class="mobile-section"></div>
                                            </div>
                                    @endif

                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="code" value="{{ $code }}">
                                    <input type="hidden" name="subid" value="{{ $subid }}">

                                </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- /.page-content -->
    </div>
</div>
@endsection
@section('after_styles')
@endsection
@section('page-script')
<!-- <script src="https://js.stripe.com/v3/"></script> -->
<script src="https://www.paypal.com/sdk/js?client-id=AVeTMogkVTha25ctu262CZJDm8dLbTWIyTFfaGUirzbdd46IOgmtrnR14GAkWQ0Qh3GEg8zwm5lzASA0"></script>
<script type="text/javascript">
    var vat_label = '<?php echo t('VAT included'); ?>';
    var packages = '<?php echo $packages->count(); ?>';
    var paymentMethods = '<?php echo $paymentMethods->count(); ?>';
    var currentPackagePrice = '<?php echo $currentPackagePrice; ?>';
    var currentPaymentActive = '<?php echo $currentPaymentActive; ?>';
    var username = '<?php echo $user->username; ?>';
    var funnelPageName = 'contract_payment';
    var stripePubKey = '{{ config("app.stripe_key") }}'
    var createPaymentIntentUrl = '{{ route("contract-create-payment-intent") }}';
</script>
{{-- {{ Html::script(config('app.cloud_url').'/js/bladeJs/contractPackages-blade.js') }} --}}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/contractPackages_jovan-blade.js') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/funnelApiAjax.js') }}
@endsection
