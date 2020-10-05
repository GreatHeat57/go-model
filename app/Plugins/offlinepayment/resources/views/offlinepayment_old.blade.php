<?php /*
<div class="pt-10 pb-30 px-30">
    <div class="row payment-plugin" id="offlinePayment" style="display: none;">
        <div class="col-xs-12 col-md-12 box-center center pt-40">
    		<div class="text-center ">
                <img class="img-responsive box-center center" src="{{ url('images/offlinepayment/payment.png') }}" title="{{ trans('offlinepayment::messages.Offline Payment') }}" style="margin-bottom: 20px;">
            </div>

            <div id="offlinePaymentDescription" class="paybale-amount">
    			<h3><strong>{{ trans('offlinepayment::messages.Follow the information below to make the payment') }}:</strong></h3>
    			<p><strong>{{ trans('offlinepayment::messages.Reason for payment') }}: </strong>
    					{{ trans('offlinepayment::messages.Application') }} @if(isset($user['profile']) && isset($user['profile']->go_code)) - {{ $user['profile']->go_code }}@endif
                        <!--  - <span class="package-name"></span> -->
    			</p>
    			<p>
    					<strong>{{ trans('offlinepayment::messages.Amount') }}: </strong>
    					<span class="amount-currency currency-in-left" style="display: none;"></span>
    					<span class="payable-amount">0</span>
    					<span class="amount-currency currency-in-right" style="display: none;"></span>
    			</p>
    			<hr>
            	{!! (isset($offlinepaymentPaymentMethod)) ? $offlinepaymentPaymentMethod->description : '' !!}
            </div>

        </div>
    </div>
</div>

*/ ?>
<div class="col-md-12 col-xs-12 col-sm-12 float-left pb-30">
    <div class="row payment-plugin" id="offlinePayment" style="display: none;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 box-center center pt-40">
            <div class="text-center img-div">
                <img class="img-responsive box-center center" src="{{ url('images/offlinepayment/payment.png') }}" title="{{ trans('offlinepayment::messages.Offline Payment') }}" style="margin-bottom: 20px;">
            </div>

            <div id="offlinePaymentDescription" class="paybale-amount">
                <h3><strong>{{ trans('offlinepayment::messages.Follow the information below to make the payment') }}:</strong></h3>
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
                {{-- !! (isset($offlinepaymentPaymentMethod)) ? $offlinepaymentPaymentMethod->description : '' !! --}}

                {{ trans('offlinepayment::messages.payment_method_description') }}
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
            var paymentMethod = $("input[name='payment_method']:checked").attr('data-name');

            /* Check Payment Method */
            checkPaymentMethodForOfflinePayment(paymentMethod, packageName, packagePrice);

            //$('#payment_method').on('change', function () {
            $('input[type=radio][name=payment_method]').on('click', function () {
                // paymentMethod = $(this).find('option:selected').data('name');
                paymentMethod = $(this).attr('data-name');
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
            $('#submitPostForm').on('click', function (e)
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
            	$('#offlinePaymentDescription').find('.package-name').html(packageName);
                $('#offlinePayment').show();
            } else {
                $('#offlinePayment').hide();
            }
        }
    </script>
@endsection
