<div class="col-sm-12 offset-md-0 payment-method-form payment-form-credit offline-payment" id="offlinePayment">
    <div class="payment-method-form-outer">
        <span class="btn-close"><i class="fa fa-times" aria-hidden="true"></i></span>
        <div class="payment-method-form-inner">
            <div class="row">
                <div class="field col-md-8 offset-md-2">
                    <div class="mobile-description">
                        <div class="text-center">
                            <img class="img-responsive box-center center" src="{{ url('images/payments/payment_offlinepayment@1x.png') }}" title="{{ trans('offlinepayment::messages.Offline Payment') }}" style="margin-bottom: 20px;">
                        </div>
                        <div class="paymentLabel">
                            <p style="margin-top: 7px;">
                                <strong>
                                    {{ t('Payable Amount') }} :
                                    <span class="price-currency amount-currency currency-in-left" style="display: none;"></span>
                                    <span class="payable-amount">0</span>
                                    <span class="price-currency amount-currency currency-in-right" style="display: none;"></span>
                                    <br>
                                    <span class="tax-calculation"></span>
                                </strong>
                            </p>
                        </div>
                    </div>
                    <div id="offlinePaymentDescription" class="paybale-amount">
                        <h3><strong>{{ trans('offlinepayment::messages.payment_method_email_notify') }}</strong></h3>
                        <p><strong>{{ trans('offlinepayment::messages.Reason for payment') }}: </strong>
                                <?php /* {{ trans('offlinepayment::messages.Application') }} */ ?>
                                @if(isset($user['profile']) && isset($user['profile']->go_code)) {{ $user['profile']->go_code }}@endif
                        </p>
                        <p>
                            <strong>{{ trans('offlinepayment::messages.Amount') }}: </strong>
                            <span class="amount-currency currency-in-left" style="display: none;"></span>
                            <span class="payable-amount">0</span>
                            <span class="amount-currency currency-in-right" style="display: none;"></span>
                        </p>
                        <hr>            
                        {{ trans('offlinepayment::messages.payment_method_description_new') }}
                    </div>
                    <div class="">
                    <button id="submitPostForm" type="button" class="offlinepayment">{{ trans('offlinepayment::messages.Finish') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .payment-errors { color: red; }
</style>

@section('page-script')
    @parent
    <script>
       jQuery.noConflict()(function($){

            var selectedPackage = $('input[name=package]:checked').val();
			var packageName = $('input[name=package]:checked').data('name');
            var packagePrice = getPackagePrice(selectedPackage);
            // var paymentMethod = $('#payment_method').find('option:selected').data('name');
            var paymentMethod = $("input:radio[name=payment_method]:checked").data('name');

            /* Check Payment Method */
            checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice);

            //$('#payment_method').on('change', function () {
            $('input:radio[name=payment_method]').on('change', function(e) {
                paymentMethod = $(this).data('name');
                checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice);
            });

            $('.payment-method[data-method=offlinepayment]').click(function(e) {
                $(this).find('input[type=radio]').prop('checked', true);
                paymentMethod = $(this).find('input[type=radio]').data('name');
                checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice);
            });

            $('.package-selection').on('click', function () {
                selectedPackage = $(this).val();
				packageName = $(this).data('name');
                packagePrice = getPackagePrice(selectedPackage);
                // paymentMethod = $('#payment_method').find('option:selected').data('name');
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
                checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice);
            });

            /* Send Payment Request */
            $('#submitPostForm.offlinepayment').on('click', function (e)
            {
                e.preventDefault();

                // paymentMethod = $('#payment_method').find('option:selected').data('name');
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');

                if (paymentMethod != 'offlinepayment' || packagePrice <= 0) {
                    return false;
                }

                $('#postForm').submit();

                /* Prevent form from submitting */
                return false;
            });
        });

        function checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice)
        {
            if (paymentMethod == 'offlinepayment' && packagePrice > 0) {
                $('.stripecard, .stripe-payment, .paypal-payment, .offline-payment').hide();
            	$('#offlinePaymentDescription').find('.package-name').html(packageName);
                $('#offlinePayment').show();
                disableYScroll();
            } else {
                $('#offlinePayment').hide();
                enableYScroll();
            }
        }
    </script>
@endsection
