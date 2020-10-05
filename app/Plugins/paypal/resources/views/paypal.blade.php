<div class="col-sm-12 offset-md-0 payment-method-form payment-form-credit paypal-payment" id="paypalPayment">
    <div class="payment-method-form-outer">
        <span class="btn-close"><i class="fa fa-times" aria-hidden="true"></i></span>
        <div class="payment-method-form-inner">
            <div class="row">
                <div class="field col-md-8 offset-md-2">
                    <div class="mobile-description">
                        <?php /*
                        <div class="table-responsive mb-20">
                          <table style="width:100%" class="payment-mobile-table">
                            <tbody>
                              <tr class="payment-mobile-tr">
                                  <td class="coupon-discount-td"></td>
                                  <td class="paymentMethod-discount-td"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                        */?>
                        <div class="text-center">
                            <img class="img-responsive box-center center" src="{{ url('images/payments/payment_paypal@1x.png') }}" title="{{ trans('paypal::messages.Payment with Paypal') }}" style="margin-bottom: 20px;">
                        </div>
                        <?php /*
                       <div class="divider-line"></div>
                                <span class="discount-line">
                                    <div class="text-center">
                                       <span id="discount-lable-paypal" style="font-size: 16px;"></span>
                                    </div>
                                    <div class="divider-line"></div>
                                </span> 
                                */ ?>
                                <div class="text-center coupon-img-div-mobile" style="display: none;">
                                    <img src="{{ url('/images/icons/coupon-icon.png') }}" alt="{{ t('discount') }}">
                                </div>
                                <div class="paymentLabel">
                                    <strong><p>{{ t('Payable Amount') }}:</p></strong>
                            <p style="margin-top: 7px;">
                                <strong>
                                    <span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
                                    <span class="payable-amount">0</span>
                                    <span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
                                    <span class="tax-calculation"></span>
                                </strong>
                            </p>
                        </div>
                        <p class="text-center">{{ t('You will be redirected to :payment', ['payment' => 'Paypal']) }}</p>
                        <div class="divider-line"></div>
                    </div>
                    <input type="hidden" name="accept_method" value="paypal">
                    @if(isset($user) && isset($user->profile))
                        <input type="hidden" name="email" id="email" value="{{ ($user->email)? $user->email : '' }}">
                        <input type="hidden" name="firstName" id="firstName" value="{{ isset($user->profile->first_name) ? $user->profile->first_name : '' }}">
                        <input type="hidden" name="lastName" id="lastName" value="{{ isset($user->profile->last_name) ? $user->profile->last_name : '' }}">
                        <input type="hidden" name="userId" id="userId" value="{{ isset($user->profile->go_code) ? $user->profile->go_code : '' }}">
                    @endif
                    <div class="">
                        <button id="submitPostForm" type="button" class="paypal" >{{ trans('paypal::messages.Pay') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('page-script')
    @parent
    <script>
       jQuery.noConflict()(function($){

            var selectedPackage = $('input[name=package]:checked').val();
            var packagePrice = getPackagePrice(selectedPackage);
            // var paymentMethod = $('#payment_method').find('option:selected').data('name');
            var paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
    
            /* Check Payment Method */
            checkPaymentMethodForPaypal(paymentMethod, packagePrice);
            
            $('input[type=radio][name=payment_method]').on('change', function(e) {
                paymentMethod = $(this).data('name');
                checkPaymentMethodForPaypal(paymentMethod, packagePrice);
            });

            $('.payment-method[data-method=paypal]').click(function(e) {
                $(this).find('input[type=radio]').prop('checked', true);
                paymentMethod = $(this).find('input[type=radio]').data('name');
                checkPaymentMethodForPaypal(paymentMethod, packagePrice);
            });

            $('.package-selection').on('click', function () {
                selectedPackage = $(this).val();
                packagePrice = getPackagePrice(selectedPackage);
                // paymentMethod = $('#payment_method').find('option:selected').data('name');
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
                checkPaymentMethodForPaypal(paymentMethod, packagePrice);
            });
    
            /* Send Payment Request */
            $('#submitPostForm.paypal').on('click', function (e)
            {
                e.preventDefault();
        
                // paymentMethod = $('#payment_method').find('option:selected').data('name');
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
                
                if (paymentMethod != 'paypal' || packagePrice <= 0) {
                    return false;
                }
    
                $('#postForm').submit();
        
                /* Prevent form from submitting */
                return false;
            });
        });

        function checkPaymentMethodForPaypal(paymentMethod, packagePrice)
        {
            if (paymentMethod == 'paypal' && packagePrice > 0) {
                $('.stripecard, .stripe-payment, .paypal-payment, .offline-payment').hide();
                $('#paypalPayment').show();
                disableYScroll();
            } else {
                $('#paypalPayment').hide();
                enableYScroll();
            }
        }
    </script>
@endsection
