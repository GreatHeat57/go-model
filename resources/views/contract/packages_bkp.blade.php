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

<div class="cover contract-payment-cover" style="height: initial;">

    <picture>
        <source media="(min-width: 768px)" srcset="{{ url(config('app.cloud_url') . '/images/covers/contract_payment.png') }}">
        <source media="(max-width: 768px)" srcset="{{ url(config('app.cloud_url') . '/images/covers/contract_payment_mobile.png') }}">
        <img src="{{ url(config('app.cloud_url') . '/images/covers/contract_payment_mobile.png') }}" alt="contract">
      </picture>

    <div class="inner">
        <div class="text">
            <div class="holder">
                <h2>{{ t('Your Model Contract') }}</h2>
            </div>
        </div>
    </div>

</div>
{{ Html::style(config('app.cloud_url').'/css/bladeCss/contractPackage-blade.css') }}
{{ Html::style(config('app.cloud_url').'/assets/css/font-awesome.min.css') }}
   
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
                                <h3><i class="icon-certificate icon-color-1"></i></h3>
                                <p style="text-align:justify;" class="text-center">
                                    {{ t('The premium package help companies to promote their job ads by giving more visibility to their ads to attract more candidates and hire them faster') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php /*
                        <!-- <div class="col-md-12" style="float:right;text-align:center;padding:20px;"> --> */ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}">
                                {!! csrf_field() !!}
                                <fieldset>
                                    @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
                                            <?php /*
                                            <!-- <div class="well" style="padding-bottom: 0;"> -->
                                            
                                            <h3><i class="icon-certificate icon-color-1"></i></h3>
                                            <p>
                                                {{ t('The premium package help companies to promote their job ads by giving more visibility to their ads to attract more candidates and hire them faster') }}
                                            </p>
                                            
                                            <!-- <div class="form-group <?php // echo (isset($errors) and $errors->has('package')) ? 'has-error' : ''; ?>" style="margin-bottom: 0;"> -->
                                            */ ?>
                                            <div class="table-responsive">
                                                <table id="packagesTable" class="table checkboxtable" style="margin-bottom: 0;" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">{{ t('Package Name') }}</th>
                                                            <th scope="col">{{ t('Price') }}</th>
                                                            <th scope="col">{{ t('Tax percentage') }}</th>
                                                            <th scope="col">{{ t('Duration') }}</th>
                                                            <th scope="col">{{ t('Total') }}</th>
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
                                                            <td>
                                                                <?php /*
                                                                    <!-- <div class="radio custom-radio">
                                                                        <input class="package-selection radio_field" type="radio" name="package"
                                                                           id="package-{{ $package->id }}"
                                                                           value="{{ $package->id }}" 
                                                                           data-name="{{ $package->name }}"
                                                                           data-price="{{ $package->price }}"
                                                                           data-tax="{{ $package->tax ? $package->tax : '0.00' }}"
                                                                           data-currencysymbol="{{ $package->currency->symbol }}"
                                                                           data-currencyinleft="{{ $package->currency->in_left }}"
                                                                           <?php //echo $seleted_package_checked; ?> >
                                                                        
                                                                        <label class="radio-label">
                                                                        <strong>{!! $package->name . $badge !!} </strong> 
                                                                        </label>
                                                                    </div> -->
                                                                */ ?>
                                                                <div class="radio custom-radio">
                                                                    <input class="package-selection radio_field" type="radio" name="package"
                                                                        id="package_{{ $package->id }}"
                                                                        value="{{ $package->id }}"
                                                                        data-name="{{ $package->name }}"
                                                                        data-price="{{ $package->price }}"
                                                                        data-tax="{{ $package->tax ? $package->tax : '0.00' }}"
                                                                        data-currencysymbol="{{ $package->currency->symbol }}"
                                                                        data-currencyinleft="{{ $package->currency->in_left }}"
                                                                        required
                                                                        {{ (($seleted_package_checked == 1) ? ' checked' : '') }} {{ $packageStatus }}>
                                                                    <label class="radio-label" for="package_{{ $package->id }}" title="{{$package->description}}" style="background-position-y: top;">
                                                                        <strong>{!! $package->name . $badge !!} </strong>
                                                                    </label>
                                                                </div>

                                                                <?php
                                                                    /*
                                                                    <!-- <div class="features" id="feature-{{ $package->id }}" style="display: none;"> -->
                                                                    // $doc = new DOMDocument();
                                                                    // if ($package->features) {
                                                                    // 	$doc->loadHTML($package->features);
                                                                    // 	echo $doc->saveHTML();
                                                                    // }
                                                                    <!-- </div> -->
                                                                    */
                                                                ?>
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
                                                            <td data-label="{{ t('Total') }}">
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
                                                        <td colspan="3">
                                                            <div class="form-group <?php echo (isset($errors) and $errors->has('payment_method')) ? 'has-error' : ''; ?>"
                                                                 style="margin-bottom: 0;">
                                                                <?php 
                                                                    /* 
                                                                    <div class="col-md-8">
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
                                                                    */
                                                                ?>
                                                                <div class="radio custom-radio radio-payment radio-align payment-radio">
                                                                    @foreach ($paymentMethods as $paymentMethod)
                                                                        @if (view()->exists('payment::' . $paymentMethod->name))

                                                                            <?php 
                                                                                if(old('payment_method')==$paymentMethod->id){
                                                                                    $checked = 'checked';
                                                                                }elseif($paymentMethod->ordering == 1) {
                                                                                    $checked = 'checked';
                                                                                }else{
                                                                                    $checked = '';
                                                                                }
                                                                            ?>
                                                    
                                                                            <input class="radio_field" type="radio" name="payment_method"
                                                                                id="payment_method_{{ $paymentMethod->id }}"
                                                                                value="{{ $paymentMethod->id }}"
                                                                                data-name="{{ $paymentMethod->name }}"
                                                                                {{ $checked }}>
                                                                            <label class="radio-label" for="payment_method_{{ $paymentMethod->id }}">
                                                                                
                                                                                @if ($paymentMethod->name == 'offlinepayment')
                                                                                    <strong>{{ trans('offlinepayment::messages.Offline Payment') }}</strong>
                                                                                @elseif($paymentMethod->name == 'stripe')
                                                                                     <strong>{{ trans('stripe::messages.stripe_label') }}</strong>
                                                                                @else
                                                                                    <strong>{{ $paymentMethod->display_name }}</strong>
                                                                                @endif
                                                                            </label>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td colspan="2" class="paymentLabel">
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
                                                <p>{{ t('Payment Method') }}:</p>
                                            </div>

                                            <div class="form-group <?php echo (isset($errors) and $errors->has('payment_method')) ? 'has-error' : ''; ?>"
                                                style="margin-bottom: 0;">
                                                <div class="row">
                                                    @foreach ($paymentMethods as $paymentMethod)
                                                        @if (view()->exists('payment::' . $paymentMethod->name))

                                                            <?php 
                                                                if(old('payment_method')==$paymentMethod->id){
                                                                    $checked = 'checked';
                                                                }elseif($paymentMethod->ordering == 1) {
                                                                    $checked = 'checked';
                                                                }else{
                                                                    $checked = '';
                                                                }
                                                            ?>

                                                            @if ($paymentMethod->name == 'stripecard')
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="ideal">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_ideal.png') }}"/>
                                                                    <p>{{ 'iDEAL' }}</p>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field" type="radio" id="payment_ideal" name="payment_method" value="{{ $paymentMethod->id }}" data-name="ideal">
                                                                        <label for="payment_ideal" class="radio-label"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="eps">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_eps.png') }}"/>
                                                                    <p>{{ 'EPS' }}</p>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field" type="radio" id="payment_eps" name="payment_method" value="{{ $paymentMethod->id }}" data-name="eps">
                                                                        <label for="payment_eps" class="radio-label"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="giropay">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_giropay.png') }}"/>
                                                                    <p>{{ 'GIROPAY' }}</p>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field" type="radio" id="payment_giropay" name="payment_method" value="{{ $paymentMethod->id }}" data-name="giropay">
                                                                        <label for="payment_giropay" class="radio-label"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="sofort">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_sofort.png') }}"/>
                                                                    <p>{{ 'SOFORT' }}</p>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field" type="radio" id="payment_sofort" name="payment_method" value="{{ $paymentMethod->id }}" data-name="sofort">
                                                                        <label for="payment_sofort" class="radio-label"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="applepay">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_applepay.png') }}"/>
                                                                    <p>{{ 'APPLE PAY' }}</p>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field" type="radio" id="payment_applepay" name="payment_method" value="{{ $paymentMethod->id }}" data-name="applepay">
                                                                        <label for="" class="radio-label"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @else
                                                            <?php 
                                                            $iconTitle = "";
                                                            switch ($paymentMethod->name) {
                                                                case 'stripe':
                                                                    $iconTitle = "CREDIT CARD";
                                                                    break;
                                                                case 'paypal':
                                                                    $iconTitle = "PAYPAL";
                                                                    break;
                                                                case 'offlinepayment':
                                                                    $iconTitle = "BANK TRANSFER";
                                                                    break;
                                                            }
                                                            ?>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="{{ $paymentMethod->name }}">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_' . $paymentMethod->name . '.png') }}"/>
                                                                    <p>{{ $iconTitle }}</p>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field" type="radio" name="payment_method" id="payment_method_{{ $paymentMethod->id }}" 
                                                                            value="{{ $paymentMethod->id }}" 
                                                                            data-name="{{ $paymentMethod->name }}" 
                                                                            {{ $checked }}>
                                                                        <label class="radio-label" for="payment_method_{{ $paymentMethod->id }}"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                               </div>
                                            </div>

                                        @if (isset($paymentMethods) and $paymentMethods->count() > 0)
                                            <!-- Payment Plugins -->
                                            <?php $hasCcBox = 0;?>
                                            @foreach($paymentMethods as $paymentMethod)
                                                @if (view()->exists('payment::' . $paymentMethod->name))
                                                    @include('payment::' . $paymentMethod->name, [$paymentMethod->name . 'PaymentMethod' => $paymentMethod])
                                                @endif
                                                <?php 
                                                    if ($paymentMethod->has_ccbox == 1 && $hasCcBox == 0) {
                                                        $hasCcBox = 1;
                                                    }
                                                ?>
                                            @endforeach
                                        @endif
                                    @endif

                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="code" value="{{ $code }}">
                                    <input type="hidden" name="subid" value="{{ $subid }}">

                                    <!-- Button  -->
                                    <?php /*
                                    <div class="form-group">
                                        <div class="col-md-12 mt20" style="text-align: center;">
                                            <button id="submitPostForm" class="btn btn-success btn-lg submitPostForm" style="cursor: pointer;"> {{ t('Pay') }} </button>
                                        </div>
                                    </div>
                                    */ ?>

                                    <div class="btn mb-30">
                                        <button id="submitPostForm" class="green next submitPostForm" >{{ t('Pay') }}</button>
                                    </div>

                                    <div style="margin-bottom: 30px;"></div>
                                </fieldset>
                            </form>
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
<script type="text/javascript">
    var vat_label = '<?php echo t('VAT included'); ?>';
    var packages = '<?php echo $packages->count(); ?>';
    var paymentMethods = '<?php echo $paymentMethods->count(); ?>';
    var currentPackagePrice = '<?php echo $currentPackagePrice; ?>';
    var currentPaymentActive = '<?php echo $currentPaymentActive; ?>';
    var username = '<?php echo $user->username; ?>';
    var funnelPageName = 'contract_payment';
</script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/contractPackages-blade.js') }}
{{ Html::script(config('app.cloud_url').'/assets/inputmask/dist/inputmask.min.js') }}
{{ Html::script(config('app.cloud_url').'/assets/inputmask/dist/bindings/inputmask.binding.js') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/funnelApiAjax.js') }}
@endsection
