<div class="pt-40 pb-xl-90 w-xl-1220 mx-xl-auto">
    <div class="row payment-plugin" id="stripePayment" style="display: none;">
        <div class="col-xs-12 col-md-12 box-center center pt-40">
            <div class="text-center">
                <img class="img-responsive box-center center" src="{{ url('images/stripe/payment.png') }}" title="{{ trans('stripe::messages.Payment with Stripe') }}" style="margin-bottom: 20px;">
            </div>
            <div class="text-center">
                <h4>{{ trans('stripe::messages.accept_payments') }}</h4>
            <div>
                <?php /*
                <!-- <div class="col-xs-6 col-md-6">
                    <select class="form-control selecter" name="accept_method" id="accept_method">
                        <option value="cards">Cards</option>
                        <option value="eps">EPS</option>
                        <option value="giropay">Giropay</option>
                        <option value="sofort">SOFORT</option>
                    </select>
                </div> -->
                */ ?>
                <input type="hidden" name="accept_method" id="accept_method" value="cards">

                @if(isset($user) && isset($user->profile))
                    <input type="hidden" name="email" id="email" value="{{ ($user->email)? $user->email : '' }}">

                    <input type="hidden" name="firstName" id="firstName" value="{{ isset($user->profile->first_name) ? $user->profile->first_name : '' }}">

                    <input type="hidden" name="lastName" id="lastName" value="{{ isset($user->profile->last_name) ? $user->profile->last_name : '' }}">

                    <input type="hidden" name="userId" id="userId" value="{{ isset($user->profile->go_code) ? $user->profile->go_code : '' }}">

                @endif
            </div>
            <?php /*
                <div>
                    <!-- <div class="col-xs-6 col-md-6">
                        <select class="form-control selecter" name="accept_method" id="accept_method">
                            <option value="cards">Cards</option>
                            <option value="eps">EPS</option>
                            <option value="giropay">Giropay</option>
                            <option value="sofort">SOFORT</option>
                        </select>
                    </div> -->
                </div>
            */ ?>
            <input type="hidden" name="accept_method" id="accept_method" value="cards">

            <!-- CREDIT CARD FORM STARTS HERE -->
            <div class="panel panel-default credit-card-box mt-20" id="card_form" >
                <div class="panel-heading" style="height: 60px;">
                    <div class="row w-md-440 px-38 px-lg-0">
                        <h3 class="panel-title bold col-xs-6 col-md-6 offset-md-3 text-center" style="padding-top: 8px;">
                            {{ trans('stripe::messages.Payment Details') }}
                            <div class="divider mx-auto"></div>
                        </h3>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row pt-20">
                        <div class="col-xs-6 col-md-6 offset-md-3">
                            <div class="form-group">
                                <label for="stripeCardNumber" class="float-left">{{ trans('stripe::messages.Card Number') }}</label>
                                <div class="input-group">
                                    <input
                                            type="tel"
                                            class="form-control"
                                            name="stripeCardNumber"
                                            placeholder="{{ trans('stripe::messages.Valid Card Number') }}"
                                            autocomplete="cc-number"
                                            maxlength="19"
                                            required
                                    />
                                    <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                    <div class="col-xs-6 col-md-6 offset-md-3">
                        <div class="form-group" style="">
                            <label for="stripeCardExpiry" class="float-left">{!! trans('stripe::messages.Expiration Date') !!}</label>
                            <input
                                    type="tel"
                                    class="form-control"
                                    name="stripeCardExpiry"
                                    placeholder="{{ trans('stripe::messages.MM / YY') }}"
                                    autocomplete="cc-exp"
                                    required
                            />
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6 offset-md-3">
                        <div class="form-group">
                            <label for="stripeCardCVC" class="float-left">{{ trans('stripe::messages.CVC Code') }}</label>
                            <input
                                    type="tel"
                                    class="form-control"
                                    name="stripeCardCVC"
                                    placeholder="{{ trans('stripe::messages.CVC') }}"
                                    autocomplete="cc-csc"
                                    required
                            />
                        </div>
                    </div>

                    </div>
                    
                    <div id="stripePaymentErrors" style="display:none;">
                        <div class="col-xs-12">
                            <p class="payment-errors"></p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- CREDIT CARD FORM ENDS HERE -->
        </div>
    </div>
</div>

@section('page-script')
    @parent
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script>

        var validationMessages = new Array();

        validationMessages['card_declined'] = "{{ trans('stripe::messages.card_declined') }}";
        validationMessages['expired_card'] = "{{ trans('stripe::messages.expired_card') }}";
        validationMessages['incorrect_cvc'] = "{{ trans('stripe::messages.incorrect_cvc') }}";
        validationMessages['incorrect_number'] = "{{ trans('stripe::messages.incorrect_number') }}";
        validationMessages['invalid_card_type'] = "{{ trans('stripe::messages.invalid_card_type') }}";
        validationMessages['invalid_cvc'] = "{{ trans('stripe::messages.invalid_cvc') }}";
        validationMessages['invalid_expiry_month'] = "{{ trans('stripe::messages.invalid_expiry_month') }}";
        validationMessages['invalid_expiry_year'] = "{{ trans('stripe::messages.invalid_expiry_year') }}";
        validationMessages['invalid_number'] = "{{ trans('stripe::messages.invalid_number') }}";
        validationMessages['processing_error'] = "{{ trans('stripe::messages.processing_error') }}";

        var packagePrice = 0;
        var selectedPackage = 0;
        var packageCurrency = '';

        jQuery.noConflict()(function($){

            selectedPackage = $('input[name=package]:checked').val();
            packagePrice = getPackagePrice(selectedPackage);
            packageCurrency = getPackageCurrency(selectedPackage);
            // var paymentMethod = $('#payment_method').find('option:selected').data('name');
            var paymentMethod = $("input[name='payment_method']:checked").attr('data-name');

            /* Check Payment Method */
            checkPaymentMethodForStripe(paymentMethod, packagePrice);

            // $('#payment_method').on('change', function () {
            $('input[type=radio][name=payment_method]').on('click', function () {
                // paymentMethod = $(this).find('option:selected').data('name');
                paymentMethod = $(this).attr('data-name');

                checkPaymentMethodForStripe(paymentMethod, packagePrice);
            });
            $('.package-selection').on('click', function () {
                selectedPackage = $(this).val();
                packagePrice = getPackagePrice(selectedPackage);
                packageCurrency = getPackageCurrency(selectedPackage);
                // paymentMethod = $('#payment_method').find('option:selected').data('name');
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
                checkPaymentMethodForStripe(paymentMethod, packagePrice);
            });


            /* Fancy restrictive input formatting via jQuery.payment library */
            $('input[name=stripeCardNumber]').payment('formatCardNumber');
            $('input[name=stripeCardCVC]').payment('formatCardCVC');
            $('input[name=stripeCardExpiry').payment('formatCardExpiry');


            /* Send Payment Request */
            $('#submitPostForm').on('click', function (e)
            {
                e.preventDefault();
                console.log('stripe page');
                // paymentMethod = $('#payment_method').find('option:selected').data('name');
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');

                if (paymentMethod != 'stripe' || packagePrice <= 0) {
                    return false;
                }

                var type = $('#accept_method').val();
                if (type == 'cards') {
                    if (!ccFormValidationForStripe()) {
                        return false;
                    }

                    /* Call the token request function */
                    payWithStripe();
                } else {
                    payWithSofort();
                }

                /* Prevent form from submitting */
                return false;
            });

            $('#accept_method').on('change', function (e)
            {
                var type = $(this).val();
                if (type == 'cards') {
                    $('#card_form').show();
                } else {
                    $('#card_form').hide();
                }
            });

            var urlParams = new URLSearchParams(window.location.search);

            var source = urlParams.get('source');
            var packageId = urlParams.get('packageId');
            var accept_method = urlParams.get('accept_method');
            if (source) {
                $('#payment_method').val(2);
                $('#accept_method').val(accept_method);
                $('#package-' + packageId).prop('checked',true);
                var $form = $('#postForm');

                /* Visual feedback */
                $form.find('#submitPostForm').html('{{ trans('stripe::messages.Validating') }} <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);

                $form.append($('<input type="hidden" name="stripeToken" />').val(source));
                $form.submit();
            }
            // console.log(url);
        });


        /* Check the Payment Method */
        function checkPaymentMethodForStripe(paymentMethod, packagePrice)
        {
            var $form = $('#postForm');

            $form.find('#submitPostForm').html('{{ t('Pay') }}').prop('disabled', false);

            /* Hide errors on the form */
            $form.find('#stripePaymentErrors').hide();
            $form.find('#stripePaymentErrors').find('.payment-errors').text('');

            if (paymentMethod == 'stripe' && packagePrice > 0) {
                $('#stripePayment').show();
            } else {
                $('#stripePayment').hide();
            }
        }

        /* Pay with the Payment Method */
        function payWithStripe()
        {
            var $form = $('#postForm');

            /* Visual feedback */
            $form.find('#submitPostForm').html('{{ trans('stripe::messages.Validating') }} <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);

            var PublishableKey = '{!! config('app.stripe_key') !!}'; /* Replace with your API publishable key */
            Stripe.setPublishableKey(PublishableKey);

            /* Create token */
            var expiry = cardExpiryVal($form.find('[name=stripeCardExpiry]').val());
            var ccData = {
                number: $form.find('[name=stripeCardNumber]').val().replace(/\s/g,''),
                cvc: $form.find('[name=stripeCardCVC]').val(),
                exp_month: expiry.month,
                exp_year: expiry.year,

            };

             function cardExpiryVal(t) {
                var e, n, r, a;
                return t = t.replace(/\s/g, ""), a = t.split("/", 2), e = a[0], r = a[1], 2 === (null != r ? r.length : void 0) && /^\d+$/.test(r) && (n = (new Date).getFullYear(), n = n.toString().slice(0, 2), r = n + r), e = parseInt(e, 10), r = parseInt(r, 10), {
                    month: e,
                    year: r
                }
            }

            //validate form fields
            if(ccData.number == ""){
                $form.find('#stripePaymentErrors').find('.payment-errors').text("{{ trans('stripe::messages.Please specify a valid credit card number') }}");
                $form.find('#stripePaymentErrors').show();
                $form.find('#submitPostForm').html('{{ t('Pay') }}').prop('disabled', false);
                return false;
            }


            if( isNaN(ccData.exp_month) || isNaN(ccData.exp_year) ){
                $form.find('#stripePaymentErrors').find('.payment-errors').text("{{ trans('stripe::messages.Invalid expiration date') }}");
                $form.find('#stripePaymentErrors').show();
                $form.find('#submitPostForm').html('{{ t('Pay') }}').prop('disabled', false);
                return false;
            }

            if(ccData.cvc == ""){
                $form.find('#stripePaymentErrors').find('.payment-errors').text("{{ trans('stripe::messages.Invalid CVC') }}");
                $form.find('#stripePaymentErrors').show();
                $form.find('#submitPostForm').html('{{ t('Pay') }}').prop('disabled', false);
                return false;
            }

            Stripe.card.createToken(ccData, function stripeResponseHandler(status, response)
            {
                
                if (response.error)
                {
                    var ErrCode = response.error.code;
                    var ErrMesssage = "";

                    if(validationMessages[ErrCode]){
                        ErrMesssage = validationMessages[ErrCode];
                    }else{
                        ErrMesssage = response.error.message;
                    }

                    /* Visual feedback */
                    $form.find('#submitPostForm').html('{{ trans('stripe::messages.Try again') }}').prop('disabled', false);

                    /* Show errors on the form */
                    $form.find('#stripePaymentErrors').find('.payment-errors').text(ErrMesssage);
                    $form.find('#stripePaymentErrors').show();
                }
                else
                {
                    
                    /* Visual feedback */
                    $form.find('#submitPostForm').html('{{ trans('stripe::messages.Processing') }} <i class="fa fa-spinner fa-pulse"></i>');

                    /* Hide Stripe errors on the form */
                    $form.find('#stripePaymentErrors').hide();
                    $form.find('#stripePaymentErrors').find('.payment-errors').text('');

                    /* Response contains id and card, which contains additional card details */
                    
                    var stripeToken = response.id;

                    /* Insert the token into the form so it gets submitted to the server */
                    $form.append($('<input type="hidden" name="stripeToken" />').val(stripeToken));

                    /* and submit */
                    $form.submit();
                    $(".loading-process").show();
                    $('#submitPostForm').prop('disabled', true);
                }
            });
           
            
        }

        function payWithSofort()
        {

            var $form = $('#postForm');

            /* Visual feedback */
            $form.find('#submitPostForm').html('{{ trans('stripe::messages.Validating') }} <i class="fa fa-spinner fa-pulse"></i>').prop('disabled', true);

            var PublishableKey = '{!! config('payment.stripe.key') !!}'; /* Replace with your API publishable key */
            Stripe.setPublishableKey(PublishableKey);
            var type = $('#accept_method').val();

            var urlParams = new URLSearchParams(window.location.search);
            var code = urlParams.get('code');
            if (code) {
                var url = window.location.href + '&packageId=' + selectedPackage + '&accept_method=' + type;
            } else {
                var url = window.location.href + '?packageId=' + selectedPackage + '&accept_method=' + type;
            }

            if (type == 'sofort') {
                var sourceData = {
                    type: type,
                    amount: packagePrice * 100,
                    currency: 'eur',
                    sofort: {
                        country: 'DE',
                    },
                    redirect: {
                        return_url: url,
                    },
                };
            } else {
                var sourceData = {
                    type: type,
                    amount: packagePrice * 100,
                    currency: 'eur',
                    owner: {
                        name: '@if(isset($post)){{  $post->email }}@endif',
                    },
                    redirect: {
                        return_url: url,
                    },
                };
            }

            Stripe.source.create(sourceData, function stripeResponseHandler(status, response){
                if (response.error)
                {
                    /* Visual feedback */
                }
                else
                {
                    console.log(response);
                    window.location = response.redirect.url;

                }
            });
        }

        function ccFormValidationForStripe()
        {
            var $form = $('#postForm');

            /* Form validation using Stripe client-side validation helpers */
            jQuery.validator.addMethod('stripeCardNumber', function(value, element) {
                return this.optional(element) || Stripe.card.validateCardNumber(value);
            }, "{{ trans('stripe::messages.Please specify a valid credit card number') }}");

            jQuery.validator.addMethod('stripeCardExpiry', function(value, element) {
                /* Parsing month/year uses jQuery.payment library */
                value = $.payment.cardExpiryVal(value);
                return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
            }, "{{ trans('stripe::messages.Invalid expiration date') }}");

            jQuery.validator.addMethod('stripeCardCVC', function(value, element) {
                return this.optional(element) || Stripe.card.validateCVC(value);
            }, "{{ trans('stripe::messages.Invalid CVC') }}");

            var validator = $form.validate({
                rules: {
                    stripeCardNumber: {
                        required: true,
                        stripeCardNumber: true
                    },
                    stripeCardExpiry: {
                        required: true,
                        stripeCardExpiry: true
                    },
                    stripeCardCVC: {
                        required: true,
                        stripeCardCVC: true
                    }
                },
                highlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorPlacement: function(error, element) {
                    $(element).closest('.form-group').append(error);
                }
            });

            paymentFormReady = function() {
                if ($form.find('[name=stripeCardNumber]').closest('.form-group').hasClass('has-success') &&
                    $form.find('[name=stripeCardExpiry]').closest('.form-group').hasClass('has-success') &&
                    $form.find('[name=stripeCardCVC]').val().length > 1) {
                    return true;
                } else {
                    return false;
                }
            };

            $form.find('#submitPostForm').prop('disabled', true);
            var readyInterval = setInterval(function() {
                if (paymentFormReady()) {
                    $form.find('#submitPostForm').prop('disabled', false);
                    clearInterval(readyInterval);
                }
            }, 250);

            /* Abort if invalid form data */
            if (!validator.form()) {
                return false;
            } else {
                return true;
            }
        }

        function getPackageCurrency(selectedPackage)
        {
            if (selectedPackage) {
                var currency = $('#' + selectedPackage + '-currency').val();
               if(currency !== undefined && currency != null){
                currency = currency.toLowerCase();
                return currency;
               }

            }
        }

    </script>
@endsection
