<div class="text-center pt-30 pb-10 px-30">
    <div class="row payment-plugin" id="paypalPayment" style="display: none;">
        <div class="col-xs-12 col-md-12 box-center center pt-40">
            
            <img class="img-responsive box-center center" src="{{ url('images/paypal/payment.png') }}" title="{{ trans('paypal::messages.Payment with Paypal') }}" style="margin-bottom: 20px;">
            <input type="hidden" name="accept_method" value="paypal">
            
            @if(isset($user) && isset($user->profile))
                <input type="hidden" name="email" id="email" value="{{ ($user->email)? $user->email : '' }}">

                <input type="hidden" name="firstName" id="firstName" value="{{ isset($user->profile->first_name) ? $user->profile->first_name : '' }}">

                <input type="hidden" name="lastName" id="lastName" value="{{ isset($user->profile->last_name) ? $user->profile->last_name : '' }}">

                <input type="hidden" name="userId" id="userId" value="{{ isset($user->profile->go_code) ? $user->profile->go_code : '' }}">

            @endif

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
            
            // $('#payment_method').on('change', function () {
            $('input[type=radio][name=payment_method]').on('click', function () {

                // paymentMethod = $(this).find('option:selected').data('name');
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
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
            $('#submitPostForm').on('click', function (e)
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
                $('#paypalPayment').show();
            } else {
                $('#paypalPayment').hide();
            }
        }
    </script>
@endsection
