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
        <source media="(min-width: 768px)" srcset="{{ url(config('app.cloud_url') . '/images/covers/contract_payment.jpg') }}">
        <source media="(max-width: 768px)" srcset="{{ url(config('app.cloud_url') . '/images/covers/contract_payment_mobile.jpg') }}">
        <img src="{{ url(config('app.cloud_url') . '/images/covers/contract_payment_mobile.jpg') }}" alt="contract">
      </picture>

    <div class="inner">
        <div class="text">
            <div class="holder">
                <h2>{{ t('Your Contract') }}</h2>
            </div>
        </div>
    </div>
</div>
{{ Html::style(config('app.cloud_url').'/css/formValidator.css') }}
{{ Html::style(config('app.cloud_url').'/css/bladeCss/contractPackage-blade.css') }}
{{ Html::style(config('app.cloud_url').'/assets/css/font-awesome.min.css') }}
   
<div class="container page-content pt-20" id="contract-profile">
    @include('contract.inc.notification')
</div>

<?php /* @include('contract.inc.wizard') */ ?>

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
                                <h1>{{ t('The premium package help companies to promote their job ads by giving more visibility to their ads to attract more candidates and hire them faster') }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php /*
                        <!-- <div class="col-md-12" style="float:right;text-align:center;padding:20px;"> --> */ ?>
                        <div class="" style="max-width:900px; margin:0 auto;">

                            <input type="hidden" name="go_code" id="go_code" value="{{ (isset($user->profile->go_code) && !empty($user->profile->go_code))? $user->profile->go_code : '' }}">
                            <input type="hidden" name="user_id" value="{{ (isset($user->id) && !empty($user->id))? $user->id : '' }}" id="userId">

                            <form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}">
                                {!! csrf_field() !!}
                                <fieldset>
                                    <?php 
                                        $packagesSymbol = ''; 
                                        $packagesSymbolLeft = 0;    
                                    ?>
                                    @if (isset($packages) and isset($paymentMethods) and $packages->count() > 0 and $paymentMethods->count() > 0)
                                            <?php /*
                                            <!-- <div class="well" style="padding-bottom: 0;"> -->
                                            
                                            <h3><i class="icon-certificate icon-color-1"></i></h3>
                                            <p>
                                                {{ t('The premium package help companies to promote their job ads by giving more visibility to their ads to attract more candidates and hire them faster') }}
                                            </p>
                                            
                                            <!-- <div class="form-group <?php // echo (isset($errors) and $errors->has('package')) ? 'has-error' : ''; ?>" style="margin-bottom: 0;"> -->
                                            */ 
                                            ?>
                                            <div class="table-responsive">
                                                <table id="packagesTable" class="table checkboxtable" style="margin-bottom: 0;" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">{{ t('Package Name') }}</th>
                                                            <th scope="col">{{ t('Duration') }}</th>
                                                            <th scope="col">{{ t('Price') }}</th>
                                                            <th scope="col">{{ t('Tax percentage') }}</th>
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
                                                            $packagesSymbol = $package->currency->symbol;
                                                            $packagesSymbolLeft = $package->currency->in_left;

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
                                                            <td class="title-td">
                                                                <div class="radio custom-radio" style="display: none;">
                                                                    <input class="package-selection radio_field" type="radio" name="package"
                                                                        id="package_{{ $package->id }}"
                                                                        value="{{ $package->id }}"
                                                                        data-name="{{ $package->name }}"
                                                                        data-price="{{ $package->price }}"
                                                                        data-tax="{{ $package->tax ? $package->tax : '0.00' }}"
                                                                        data-currencysymbol="{{ $package->currency->symbol }}"
                                                                        data-currencyinleft="{{ $package->currency->in_left }}"
                                                                        data-currencyCode="{{ $package->currency->code }}"
                                                                        required
                                                                        {{ (($seleted_package_checked == 1) ? ' checked' : '') }} {{ $packageStatus }}>
                                                                    <label class="radio-label" for="package_{{ $package->id }}" title="{{$package->description}}" style="background-position-y: top;">
                                                                        <strong>{!! $package->name . $badge !!} </strong>
                                                                    </label>
                                                                </div>
                                                                <p title="{{$package->description}}" >{!! $package->name . $badge !!}</p>
                                                            </td>
                                                            <td data-label="{{ t('Duration') }}">
                                                                <p id="duration-{{ $package->id }}">
                                                                    <span class="duration-int">{{ $package->duration }} {{ t($package->duration_period) }}</span>
                                                                </p>
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
                                                                    <span class="tax-int package-tax">{{ $package->tax ? $package->tax : '0.00' }}</span>
                                                                </p>
                                                            </td>
                                                            
                                                            <td data-label="{{ t('Total') }}">
                                                                <p id="total-{{ $package->id }}">
                                                                    <?php $total_amount = round( $package->price + (($package->price * $package->tax)/ 100), 2); ?>
                                                                    @if ($package->currency->in_left == 1)
                                                                        <span class="price-currency">{{ $package->currency->symbol }}</span>
                                                                    @endif
                                                                    <span class="duration-int package-total-price">{{ number_format(round($total_amount), 2) }}</span>
                                                                    @if ($package->currency->in_left == 0)
                                                                        <span class="price-currency">{{ $package->currency->symbol }}</span>
                                                                    @endif
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <?php $totalReminderFees = 0; ?>
                                                    <?php $sumReminderTax = 0; ?>
                                                    <?php $additional_charges = array(); $i = 0; ?>
                                                    @if(!empty($reminderFeesArr))
                                                        @foreach ($reminderFeesArr as $fees)
                                                            <tr>
                                                                <td>
                                                                    <p>
                                                                        <span>{{$fees->product}}</span>
                                                                    </p>
                                                                </td>
                                                                <td data-label="{{ t('Duration') }}">
                                                                    <p>
                                                                        <span>-</span>
                                                                    </p>
                                                                </td>
                                                                <td data-label="{{ t('Price') }}">
                                                                    <p>
                                                                        <span>{{$fees->net}}</span>
                                                                    </p>
                                                                </td>
                                                                <td data-label="{{ t('Tax percentage') }}">
                                                                    <p>
                                                                        <span>{{$fees->tax}}</span>
                                                                    </p>
                                                                </td>
                                                                
                                                                <td data-label="{{ t('Total') }}">
                                                                    <p>
                                                                        @if ($package->currency->in_left == 1)
                                                                            <span class="price-currency">{{ $package->currency->symbol }}</span>
                                                                        @endif
                                                                        <span>{{$fees->amount}}</span>
                                                                        @if ($package->currency->in_left == 0)
                                                                            <span>{{ $package->currency->symbol }}</span>
                                                                        @endif
                                                                    </p>
                                                                </td>
                                                            </tr>
                                                            <?php 
                                                                $totalReminderFees+= $fees->net; 
                                                                $sumReminderTax+= $fees->tax;
                                                                // additional charges array
                                                                $additional_charges[$i]['product'] = $fees->product;
                                                                $additional_charges[$i]['price'] = $fees->net;
                                                                $additional_charges[$i]['tax'] = $fees->tax;
                                                                $additional_charges[$i]['total_amount'] = $fees->amount;
                                                                $i++;
                                                            ?>
                                                        @endforeach
                                                    @endif
                                                    <!-- Start coupon code -->
                                                    <tr class="discount-row" style="display: none;">
                                                        <td class="title-td">
                                                            <p>
                                                                <span class="discount-title">Online Payment Benefit</span>
                                                                <span class="mobile-show price-currency discount-amount">-</span>
                                                            </p>
                                                        </td>
                                                        <td class="mobile-hide" data-label="{{ t('Duration') }}">
                                                            <p>
                                                                <span>-</span>
                                                            </p>
                                                        </td>
                                                        <td class="mobile-hide" data-label="{{ t('Price') }}">
                                                            <p>
                                                                <span class="discount-price">-</span>
                                                            </p>
                                                        </td>
                                                        <td class="mobile-hide" data-label="{{ t('Tax percentage') }}">
                                                            <p>
                                                                <span class="discount-tex">-</span>
                                                            </p>
                                                        </td>
                                                        <td class="mobile-hide" data-label="{{ t('Total') }}">
                                                            <p>
                                                                <span class="price-currency discount-amount">-</span>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <!-- End coupon code -->
                                                    <!-- Start Payment coupon code -->
                                                    <tr class="payment-discount-row" style="display: none;">
                                                        <td class="title-td">
                                                            <p>
                                                                <span class="payment-discount-title">-</span>
                                                                <span class="mobile-show price-currency payment-discount-amount">-</span>
                                                            </p>
                                                        </td>
                                                        <td class="mobile-hide" data-label="{{ t('Duration') }}">
                                                            <p>
                                                                <span>-</span>
                                                            </p>
                                                        </td>
                                                        <td class="mobile-hide" data-label="{{ t('Price') }}">
                                                            <p>
                                                                <span class="payment-discount-price">-</span>
                                                            </p>
                                                        </td>
                                                        <td class="mobile-hide" data-label="{{ t('Tax percentage') }}">
                                                            <p>
                                                                <span class="payment-discount-tex">-</span>
                                                            </p>
                                                        </td>
                                                        <td class="mobile-hide" data-label="{{ t('Total') }}">
                                                            <p>
                                                                <span class="price-currency payment-discount-amount">-</span>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <!-- End payment coupon code -->

                                                    <input type="hidden" id="couponDiscout" name="coupon_discount_array" value="">
                                                    <input type="hidden" id="paymentMethodDiscount" name="payment_method_discount_array" value="">

                                                    <!-- <input type="hidden" name="discountAmount" value="0">
                                                    <input type="hidden" name="coupon_tax" value="0">
                                                    <input type="hidden" name="crm_coupon_id" value="0">
                                                    <input type="hidden" name="crm_coupon_id_coupon" value="0">
                                                    <input type="hidden" name="crm_coupon" value="">
                                                    <input type="hidden" name="crm_discount" value="0">
                                                    <input type="hidden" name="crm_discount_type" value="">
                                                    <input type="hidden" name="crm_coupon_name" value="">
                                                    <input type="hidden" id='is_coupon_applied' name="is_coupon_applied" value="0"> -->

<tr class="apply-coupon-tr">
    <td colspan="5" class="apply-coupon-td">
        <table class="coupon-table">
            <tbody>
                <tr class="coupon-table-tr">
                    <td style="" class="coupon-table-td">
                        <div class="coupondiv">
                            <div class="input-group coupon-input-div">
                                <img class="coupon-img" src="{{ url(config('app.cloud_url') . '/images/icons/coupon-icon.png') }}"/>

                                <input class="coupon_code_input" id="coupon_code" placeholder="{{ t('coupon_title') }}" autocomplete="coupon-add" name="coupon_code" type="text">
                                <div class="form-input-error-msg" id="coupon_error"></div>
                            </div>
                        </div>
                        <div class="btn" id="apply-coupon-div">
                            <button type="submit" id="validate_coupon" class="d-inline-block btn btn-success register mb-10">{{ t('Apply Code') }}</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>

                                                    <?php /*
                                                    <tr class="apply-coupon-tr">
                                                        <td colspan="3" class="apply-coupon-td" style="">
                                                            <div class="input-group coupon-input-div" style="">
                                                                <input class="coupon_code_input" id="coupon_code" placeholder="{{ t('coupon_title') }}" autocomplete="coupon-add" name="coupon_code" type="text" class="coupon_code_input"> 
                                                            </div>

                                                            <div class="form-input-error-msg" id="coupon_error"></div>
                                                        </td>
                                                        <td colspan="2" class="coupon-button apply-coupon-td">
                                                            <div class="btn" id="apply-coupon-div">
                                                                <button type="submit" id="validate_coupon" class="d-inline-block btn btn-success register mb-10">{{ t('Apply Code') }}</button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    */ ?>
                                                    <tr class="payable-amount-tr">
                                                        <td colspan="5" class="paymentLabel">
                                                            <p style="margin-top: 7px;">
                                                                <strong>
                                    								{{ t('Amount') }} :
                                    								<span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
                                    								<span class="payable-amount">0</span>
                                    								<span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
                                                                    <span class="tax-calculation"></span>
                                                                </strong>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <input type="hidden" class="totalReminderFees" name="totalReminderFees" value="<?php echo $totalReminderFees; ?>">
                                            <input type="hidden" class="reminderTax" name="reminderTax" value="<?php echo $sumReminderTax; ?>">
                                            <input type="hidden" class="additional_charges" name="additional_charges" value='<?php echo json_encode($additional_charges); ?>'>
                                            <div class="payment-method-title">
                                                <p class="title-p">{{ t('Payment Method') }}:</p>
                                                
                                                <?php /* <p class="text-center">{{ t('payment_method_sub_description') }}:</p> */ ?>
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
                                                                <div class="payment-method" data-method="card">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_stripe.png') }}"/>
                                                                    <p>{{ 'CREDIT CARD' }}</p>
                                                                    <?php
                                                                        $show_discount_text = '&nbsp;';
                                                                        $discount_label = "";
                                                                        
                                                                        if(isset($couponPaymentListArr['card'])){
                                                                            if(isset($couponPaymentListArr['card']->discount_text)){
                                                                                $show_discount_text = $couponPaymentListArr['card']->discount_text;
                                                                            }else{
                                                                                if($packagesSymbolLeft == 1){
                                                                                 $show_discount_text = $packagesSymbol.' '.$couponPaymentListArr['card']->discount.' '.t('discount');
                                                                                }else{
                                                                                    $show_discount_text = $couponPaymentListArr['card']->discount.' '.$packagesSymbol.' '.t('discount');
                                                                                }
                                                                            }

                                                                            $discount_label = $show_discount_text;
                                                                        }
                                                                        //echo $show_discount_text;
                                                                    ?>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field payment_method_input" type="radio" id="payment_card" name="payment_method" value="{{ $paymentMethod->id }}" data-name="card" data-label="{{ $discount_label }}" >
                                                                        <label for="payment_card" class="radio-label"></label>
                                                                    </div>
                                                                    <div class="card-body {{ (isset($couponPaymentListArr['card']))? '' : 'no-discount' }}">
                                                                        <p class="card-text"> {{-- (isset($couponPaymentListArr['card']))? $couponPaymentListArr['card']->discount_text : '&nbsp;' --}}
                                                                            <?php  echo $show_discount_text; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="ideal">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_ideal.png') }}"/>
                                                                    <p>{{ 'iDEAL' }}</p>
                                                                    <?php
                                                                        $show_discount_text = '&nbsp;';
                                                                        $discount_label = "";
                                                                        
                                                                        if(isset($couponPaymentListArr['ideal'])){
                                                                            if(isset($couponPaymentListArr['ideal']->discount_text)){
                                                                                $show_discount_text = $couponPaymentListArr['ideal']->discount_text;
                                                                            }else{
                                                                                if($packagesSymbolLeft == 1){
                                                                                 $show_discount_text = $packagesSymbol.' '.$couponPaymentListArr['ideal']->discount.' '.t('discount');
                                                                                }else{
                                                                                    $show_discount_text = $couponPaymentListArr['ideal']->discount.' '.$packagesSymbol.' '.t('discount');
                                                                                }
                                                                            }

                                                                            $discount_label = $show_discount_text;
                                                                        }
                                                                        //echo $show_discount_text;
                                                                    ?>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field payment_method_input" type="radio" id="payment_ideal" name="payment_method" value="{{ $paymentMethod->id }}" data-name="ideal" data-label="{{ $discount_label }}">
                                                                        <label for="payment_ideal" class="radio-label"></label>
                                                                    </div>
                                                                    <div class="card-body {{ (isset($couponPaymentListArr['ideal']))? '' : 'no-discount' }}">
                                                                        <p class="card-text"> {{-- (isset($couponPaymentListArr['ideal']))? $couponPaymentListArr['ideal']->discount_text : '&nbsp;' --}}
                                                                            <?php echo $show_discount_text; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="eps">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_eps.png') }}"/>
                                                                    <p>{{ 'EPS' }}</p>
                                                                    <?php
                                                                        $show_discount_text = '&nbsp;';
                                                                        $discount_label = "";
                                                                        
                                                                        if(isset($couponPaymentListArr['eps'])){
                                                                            if(isset($couponPaymentListArr['eps']->discount_text)){
                                                                                $show_discount_text = $couponPaymentListArr['eps']->discount_text;
                                                                            }else{
                                                                                if($packagesSymbolLeft == 1){
                                                                                 $show_discount_text = $packagesSymbol.' '.$couponPaymentListArr['eps']->discount.' '.t('discount');
                                                                                }else{
                                                                                    $show_discount_text = $couponPaymentListArr['eps']->discount.' '.$packagesSymbol.' '.t('discount');
                                                                                }
                                                                            }

                                                                            $discount_label = $show_discount_text;
                                                                        }
                                                                        //echo $show_discount_text;
                                                                    ?>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field payment_method_input" type="radio" id="payment_eps" name="payment_method" value="{{ $paymentMethod->id }}" data-name="eps" data-label="{{ $discount_label }}">
                                                                        <label for="payment_eps" class="radio-label"></label>
                                                                    </div>
                                                                    <div class="card-body {{ (isset($couponPaymentListArr['eps']))? '' : 'no-discount' }}">
                                                                        <p class="card-text"> {{-- (isset($couponPaymentListArr['eps']))? $couponPaymentListArr['eps']->discount_text : '&nbsp;' --}}
                                                                            <?php echo $show_discount_text; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="giropay">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_giropay.png') }}"/>
                                                                    <p>{{ 'GIROPAY' }}</p>
                                                                    <?php
                                                                        $show_discount_text = '&nbsp;';
                                                                        $discount_label = "";
                                                                        
                                                                        if(isset($couponPaymentListArr['giropay'])){
                                                                            if(isset($couponPaymentListArr['giropay']->discount_text)){
                                                                                $show_discount_text = $couponPaymentListArr['giropay']->discount_text;
                                                                            }else{
                                                                                if($packagesSymbolLeft == 1){
                                                                                 $show_discount_text = $packagesSymbol.' '.$couponPaymentListArr['giropay']->discount.' '.t('discount');
                                                                                }else{
                                                                                    $show_discount_text = $couponPaymentListArr['giropay']->discount.' '.$packagesSymbol.' '.t('discount');
                                                                                }
                                                                            }

                                                                            $discount_label = $show_discount_text;
                                                                        }
                                                                        //echo $show_discount_text;
                                                                    ?>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field payment_method_input" type="radio" id="payment_giropay" name="payment_method" value="{{ $paymentMethod->id }}" data-name="giropay" data-label="{{ $discount_label }}">
                                                                        <label for="payment_giropay" class="radio-label"></label>
                                                                    </div>
                                                                    <div class="card-body {{ (isset($couponPaymentListArr['giropay']))? '' : 'no-discount' }}">
                                                                        <p class="card-text"> {{-- (isset($couponPaymentListArr['giropay']))? $couponPaymentListArr['giropay']->discount_text : '&nbsp;' --}}
                                                                            <?php echo $show_discount_text; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="sofort" data-label="{{ $discount_label }}">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_sofort.png') }}"/>
                                                                    <p>{{ 'SOFORT' }}</p>
                                                                    <?php
                                                                        $show_discount_text = '&nbsp;';
                                                                        $discount_label = "";
                                                                        
                                                                        if(isset($couponPaymentListArr['sofort'])){
                                                                            if(isset($couponPaymentListArr['sofort']->discount_text)){
                                                                                $show_discount_text = $couponPaymentListArr['sofort']->discount_text;
                                                                            }else{
                                                                                if($packagesSymbolLeft == 1){
                                                                                 $show_discount_text = $packagesSymbol.' '.$couponPaymentListArr['sofort']->discount.' '.t('discount');
                                                                                }else{
                                                                                    $show_discount_text = $couponPaymentListArr['sofort']->discount.' '.$packagesSymbol.' '.t('discount');
                                                                                }
                                                                            }

                                                                            $discount_label = $show_discount_text;
                                                                        }
                                                                       // echo $show_discount_text;
                                                                    ?>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field payment_method_input" type="radio" id="payment_sofort" name="payment_method" value="{{ $paymentMethod->id }}" data-name="sofort">
                                                                        <label for="payment_sofort" class="radio-label"></label>
                                                                    </div>
                                                                    <div class="card-body {{ (isset($couponPaymentListArr['sofort']))? '' : 'no-discount' }}">
                                                                        <p class="card-text"> {{-- (isset($couponPaymentListArr['sofort']))? $couponPaymentListArr['sofort']->discount_text : '&nbsp;' --}}
                                                                            <?php echo $show_discount_text; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="applepay">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_applepay.png') }}"/>
                                                                    <p>{{ 'APPLE PAY' }}</p>
                                                                    <?php
                                                                        $show_discount_text = '&nbsp;';
                                                                        $discount_label = "";
                                                                        
                                                                        if(isset($couponPaymentListArr['applepay'])){
                                                                            if(isset($couponPaymentListArr['applepay']->discount_text)){
                                                                                $show_discount_text = $couponPaymentListArr['applepay']->discount_text;
                                                                            }else{
                                                                                if($packagesSymbolLeft == 1){
                                                                                 $show_discount_text = $packagesSymbol.' '.$couponPaymentListArr['applepay']->discount.' '.t('discount');
                                                                                }else{
                                                                                    $show_discount_text = $couponPaymentListArr['applepay']->discount.' '.$packagesSymbol.' '.t('discount');
                                                                                }
                                                                            }

                                                                            $discount_label = $show_discount_text;
                                                                        }
                                                                        //echo $show_discount_text;
                                                                    ?>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field payment_method_input" type="radio" id="payment_applepay" name="payment_method" value="{{ $paymentMethod->id }}" data-name="applepay" data-label="{{ $discount_label }}">
                                                                        <label for="" class="radio-label"></label>
                                                                    </div>
                                                                    <div class="card-body {{ (isset($couponPaymentListArr['applepay']))? '' : 'no-discount' }}">
                                                                        <p class="card-text"> {{-- (isset($couponPaymentListArr['applepay']))? $couponPaymentListArr['applepay']->discount_text : '&nbsp;' --}}
                                                                            <?php echo $show_discount_text; ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                <div class="payment-method" data-method="sepa">
                                                                    <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_sepa.png') }}"/>
                                                                    <p>{{ 'SEPA Direct' }}</p>
                                                                    <?php
                                                                        $show_discount_text = '&nbsp;';
                                                                        $discount_label = "";
                                                                        
                                                                        if(isset($couponPaymentListArr['sepa'])){
                                                                            if(isset($couponPaymentListArr['sepa']->discount_text)){
                                                                                $show_discount_text = $couponPaymentListArr['sepa']->discount_text;
                                                                            }else{
                                                                                if($packagesSymbolLeft == 1){
                                                                                 $show_discount_text = $packagesSymbol.' '.$couponPaymentListArr['sepa']->discount.' '.t('discount').'.';
                                                                                }else{
                                                                                    $show_discount_text = $couponPaymentListArr['sepa']->discount.' '.$packagesSymbol.' '.t('discount').'.';
                                                                                }
                                                                            }

                                                                            $discount_label = $show_discount_text;
                                                                        }
                                                                       // echo $show_discount_text;
                                                                    ?>
                                                                    <div class="radio custom-radio">
                                                                        <input class="radio_field" type="radio" id="payment_sepa" name="payment_method" value="{{ $paymentMethod->id }}" data-name="sepa" data-label="{{ $discount_label }}">
                                                                        <label for="" class="radio-label"></label>
                                                                    </div>
                                                                    <div class="card-body {{ (isset($couponPaymentListArr['sepa']))? '' : 'no-discount' }}">
                                                                        <p class="card-text"> {{-- (isset($couponPaymentListArr['directdebit']))? $couponPaymentListArr['directdebit']->discount_text : '&nbsp;' --}}

                                                                            <?php echo $show_discount_text; ?>
                                                                        </p>
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

                                                            @if(($paymentMethod->name != 'offlinepayment') || $paymentMethod->name == 'offlinepayment' && $is_hide_offline_payment == false)
                                                                <div class="col-md-3 col-sm-6 payment-method-wrapper">
                                                                    <div class="payment-method" data-method="{{ $paymentMethod->name }}" id="{{ $paymentMethod->name }}_div">
                                                                        <img src="{{ url(config('app.cloud_url') . '/images/payments/payment_' . $paymentMethod->name . '.png') }}"/>
                                                                        <p>{{ $iconTitle }}</p>
                                                                        <?php
                                                                            $show_discount_text = '&nbsp;';
                                                                            $discount_label = "";

                                                                            if(isset($couponPaymentListArr[$paymentMethod->name])){
                                                                                if(isset($couponPaymentListArr[$paymentMethod->name]->discount_text)){
                                                                                    $show_discount_text = $couponPaymentListArr[$paymentMethod->name]->discount_text;
                                                                                }else{
                                                                                    if($packagesSymbolLeft == 1){
                                                                                     $show_discount_text = $packagesSymbol.' '.$couponPaymentListArr[$paymentMethod->name]->discount.' '.t('discount');
                                                                                    }else{
                                                                                        $show_discount_text = $couponPaymentListArr[$paymentMethod->name]->discount.' '.$packagesSymbol.' '.t('discount');
                                                                                    }
                                                                                }

                                                                                $discount_label = $show_discount_text;
                                                                            }
                                                                           // echo $show_discount_text;
                                                                        ?>
                                                                        <div class="radio custom-radio">
                                                                            <input class="radio_field payment_method_input" type="radio" name="payment_method" id="payment_method_{{ $paymentMethod->id }}" 
                                                                                value="{{ $paymentMethod->id }}" 
                                                                                data-name="{{ $paymentMethod->name }}" 
                                                                                {{ $checked }}>
                                                                            <label class="radio-label" for="payment_method_{{ $paymentMethod->id }}"></label>
                                                                        </div>
                                                                        <div class="card-body {{ (isset($couponPaymentListArr[$paymentMethod->name]))? '' : 'no-discount' }}">
                                                                            <p class="card-text"> {{-- (isset($couponPaymentListArr[$paymentMethod->name]))? $couponPaymentListArr[$paymentMethod->name]->discount_text : '&nbsp;' --}}
                                                                                <?php echo $show_discount_text; ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
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

                                        <div id="div-alert"></div>
                                        <div class="mobile-section"></div>

                                    @endif

                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="code" value="{{ $code }}">
                                    <input type="hidden" name="subid" value="{{ $subid }}">
                                    <input type="hidden" name="post_id" value="{{ $post_id }}">
                                    <input type="hidden" name="is_renew" value="{{ $is_renew }}">
                                    <input type="hidden" name="payment_sub_method" id="payment_sub_method">
                                    <!-- <input type="hidden" id="transaction_amount" name="transaction_amount" value="0"> -->

                                    <div class="btn mb-30" style="display:none;">
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
        <!-- jovan cookie consent code -->
        @include('common.cookie-consent')
    </div>
</div>
@endsection
@section('after_styles')
@endsection
@section('page-script')
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    var vat_label = '<?php echo t('VAT included'); ?>';
    var packages = '<?php echo $packages->count(); ?>';
    var paymentMethods = '<?php echo $paymentMethods->count(); ?>';
    var currentPackagePrice = '<?php echo $currentPackagePrice; ?>';
    var currentPaymentActive = '<?php echo $currentPaymentActive; ?>';
    var username = '<?php echo $user->username; ?>';
    var funnelPageName = 'contract_payment';
    var stripePubKey = '{{ config("app.stripe_key") }}';
    var locale = '<?php echo config('app.locale'); ?>';
    var couponPaymentListArr = '<?php echo json_encode($couponPaymentListArr); ?>';
    var someErrorOccurredMessage = '<?php echo t('some error occurred'); ?>';
    var discountLabel = '<?php echo t('discount'); ?>';
    var paymentProcessMessage = '<?php echo t('payment process warning'); ?>';

</script>
{{ Html::script(config('app.cloud_url').'/js/bladeJs/contractPackages-blade.js') }}
{{ Html::script(config('app.cloud_url').'/assets/inputmask/dist/inputmask.min.js') }}
{{ Html::script(config('app.cloud_url').'/assets/inputmask/dist/bindings/inputmask.binding.js') }}
{{ Html::script(config('app.cloud_url').'/js/bladeJs/funnelApiAjax.js') }}
@endsection

