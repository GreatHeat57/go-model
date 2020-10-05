
    <div class="col-sm-12 offset-md-0 payment-method-form payment-form-credit stripecard" id="payment-form-card">
        <div class="payment-method-form-outer">
            <span class="btn-close"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div class="payment-method-form-inner">
                <div id="form-ideal-payment">
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
                                */ ?>
                                <div class="text-center">
                                    <img class="img-responsive box-center center" src="{{ url('images/payments/payment_stripe@1x.png') }}" title="{{ trans('paypal::messages.Payment with Paypal') }}" style="margin-bottom: 20px;">
                                </div>
                                <?php /*
                                <div class="divider-line" ></div>
                                <span class="discount-line">
                                    <div class="text-center">
                                       <span id="discount-lable-card" style="font-size: 16px;"></span>
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
                                <p class="text-center">Enter your payment info:</p>
                                <div class="divider-line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field col-md-8 offset-md-2">
                            <label for="card-element" class="required">Credit Card Information</label>
                            <div id="card-element" class="input">
                                <!-- Elements will create input elements here -->
                            </div>
                            <div class="card-errors payment-errors" id="card-errors" role="alert"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field col-md-8 offset-md-2">
                            <button id="payment-card-submit" class="btn-stripecard" type="button">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-sm-12 offset-md-0 payment-method-form payment-form-credit stripecard" id="payment-form-ideal">
        <div class="payment-method-form-outer">
            <span class="btn-close"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div class="payment-method-form-inner">
                <div id="form-ideal-payment">
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
                                */ ?>
                                <div class="text-center">
                                    <img class="img-responsive box-center center" src="{{ url('images/payments/payment_ideal@1x.png') }}" title="{{ trans('paypal::messages.Payment with Paypal') }}" style="margin-bottom: 20px;">
                                </div>
                                <?php /*
                                <div class="divider-line"></div>
                                <span class="discount-line">
                                    <div class="text-center">
                                       <span id="discount-lable-ideal" style="font-size: 16px;"></span>
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
                                <p class="text-center">{{ t('Enter your payment info') }}</p>
                                <div class="divider-line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field col-md-8 offset-md-2">
                            <label for="ideal-name" class="required">Name</label>
                            <input id="ideal-name" class="input" type="text" placeholder="" required autocomplete="name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="field col-md-8 offset-md-2">
                            <label for="ideal-element" class="required">iDeal Bank</label>
                            <div id="ideal-element" class="input">
                                <!-- Elements will create input elements here -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field col-md-8 offset-md-2">
                            <button id="payment-ideal-submit" class="btn-stripecard" type="button">Pay</button>
                            <!-- We'll put the error messages in this element -->
                            <div id="ideal-errors" role="alert" class="payment-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 offset-md-0 payment-method-form payment-form-credit stripecard" id="payment-form-eps">
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
                            */ ?>
                            <div class="text-center">
                                <img class="img-responsive box-center center" src="{{ url('images/payments/payment_eps@1x.png') }}" title="{{ trans('paypal::messages.Payment with Paypal') }}" style="margin-bottom: 20px;">
                            </div>
                                <?php /*
                                <div class="divider-line"></div>
                                <span class="discount-line">
                                    <div class="text-center">
                                       <span id="discount-lable-eps" style="font-size: 16px;"></span>
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
                            <p class="text-center">{{ t('You will be redirected to :payment', ['payment' => 'EPS']) }}</p>
                            <div class="divider-line"></div>
                        </div>
                        <div>
                            <button id="payment-eps-submit" class="btn-stripecard" type="button">Pay</button>
                            <!-- We'll put the error messages in this element -->
                            <div id="eps-errors" role="alert" class="payment-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 offset-md-0 payment-method-form payment-form-credit stripecard" id="payment-form-giropay">
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
                                      <td class="payment-mobile-tr"></td>
                                      <td class="paymentMethod-discount-td"></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                            */ ?>
                            <div class="text-center">
                                <img class="img-responsive box-center center" src="{{ url('images/payments/payment_giropay@1x.png') }}" title="{{ trans('paypal::messages.Payment with Paypal') }}" style="margin-bottom: 20px;">
                            </div>
                            <?php /*
                            <div class="divider-line"></div>
                            <span class="discount-line">
                                <div class="text-center">
                                   <span id="discount-lable-giropay" style="font-size: 16px;"></span>
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
                            <p class="text-center">{{ t('You will be redirected to :payment', ['payment' => 'Giropay']) }}</p>
                            <div class="divider-line"></div>
                        </div>
                        <div>
                            <button id="payment-giropay-submit" class="btn-stripecard" type="button">Pay</button>
                            <!-- We'll put the error messages in this element -->
                            <div id="giropay-errors" role="alert" class="payment-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 offset-md-0 payment-method-form payment-form-credit stripecard" id="payment-form-sofort">
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
                            */ ?>
                            <div class="text-center">
                                <img class="img-responsive box-center center" src="{{ url('images/payments/payment_sofort@1x.png') }}" title="{{ trans('paypal::messages.Payment with Paypal') }}" style="margin-bottom: 20px;">
                            </div>
                            <?php /*
                            <div class="divider-line" ></div>
                            <span class="discount-line">
                                <div class="text-center" >
                                   <span id="discount-lable-sofort" style="font-size: 16px;"></span>
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
                            <p class="text-center">{{ t('You will be redirected to :payment', ['payment' => 'SOFORT']) }}</p>
                            <div class="divider-line"></div>
                        </div>
                        <div>
                            <button id="payment-sofort-submit" class="btn-stripecard" type="button">Pay</button>
                            <div id="sofort-errors" role="alert" class="payment-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 offset-md-0 payment-method-form payment-form-credit stripecard" id="payment-form-applepay">
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
                            */ ?>
                            <div class="text-center">
                                <img class="img-responsive box-center center" src="{{ url('images/payments/payment_applepay@1x.png') }}" title="{{ trans('paypal::messages.Payment with Paypal') }}" style="margin-bottom: 20px;">
                            </div>
                            <?php /*
                            <div class="divider-line" ></div>
                                <span class="discount-line">
                                    <div class="text-center">
                                       <span id="discount-lable-applepay" style="font-size: 16px;"></span>
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
                            <p class="text-center">{{ t('You will be redirected to :payment', ['payment' => 'Apple Pay']) }}</p>
                            <div class="divider-line"></div>
                        </div>
                        <div id="payment-request-button">
                            <button id="payment-applepay-submit" class="btn-stripecard" type="button">Pay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 offset-md-0 payment-method-form payment-form-credit stripecard" id="payment-form-sepa">
        <div class="payment-method-form-outer">
            <span class="btn-close"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div class="payment-method-form-inner">
                <div id="form-ideal-payment">
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
                                */ ?>
                                <div class="text-center">
                                    <img class="img-responsive box-center center" src="{{ url('images/payments/payment_sepa.png') }}" title="{{ trans('paypal::messages.Payment with Paypal') }}" style="margin-bottom: 20px;">
                                </div>
                                <?php /*
                                <div class="divider-line" ></div>
                                <span class="discount-line">
                                    <div class="text-center" >
                                       <span id="discount-lable-sepa" style="font-size: 16px;"></span>
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
                                <p class="text-center">Enter your payment info:</p>
                                <div class="divider-line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="field col-md-8 offset-md-2">
                            <label for="sepa-name">Name</label>
                            <input id="sepa-name" class="input" type="text" name="sepa-name" placeholder="Jenny Rosen" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="field col-md-8 offset-md-2">
                            <label for="sepa-email" class="required">Email</label>
                            <input id="sepa-email" name="sepa-email" class="input" type="text" placeholder="" required autocomplete="email">
                        </div>
                    </div>

                    <div class="row">
                        <div class="field col-md-8 offset-md-2">
                            <label for="sepa-iban-element" class="required">IBAN</label>
                            <div id="sepa-iban-element">
                                <!-- A Stripe Element will be inserted here. -->
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="field col-md-8 offset-md-2">
                            <button id="payment-sepa-submit" class="btn-stripecard" type="button">Pay</button>
                            <!-- We'll put the error messages in this element -->
                            <div id="sepa-errors" role="alert" class="payment-errors"></div>
                            <!-- Display mandate acceptance text. -->
                            <div id="mandate-acceptance">
                                <aside class="important">
                                    <p>By providing your IBAN and confirming this payment, you are authorizing <i>Go-models International Limited</i> and Stripe, our payment service provider, to send instructions to your bank to debit your account in accordance with those instructions. You are entitled to a refund from your bank under the terms and conditions of your agreement with your bank. A refund must be claimed within eight weeks starting from the date on which your account was debited.</p>
                                </aside>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@section('page-script')
    @parent
    <!-- <script type="text/javascript" src="https://js.stripe.com/v3/"></script> -->
    <script>

        var stripecardValidationMessages = new Array();

        stripecardValidationMessages['require_ideal_name'] = "{{ trans('stripecard::messages.require_ideal_name') }}";
        stripecardValidationMessages['require_ideal_bank'] = "{{ trans('stripecard::messages.require_ideal_bank') }}";

        var packagePrice = 0;
        var selectedPackage = 0;
        var packageCurrency = '';

        // Start - Mount Ideal bank list to bank select option 
        var stripe = Stripe(stripePubKey);
        var idealElements = stripe.elements();
        var idealElementsOptions = {
            style:{
                base: {
                    fontSize: '16px',
                    color: '#32325d',
                    padding: '10px 12px',
                }
            }
        };
        var idealBank = idealElements.create("idealBank", idealElementsOptions);
        idealBank.mount("#ideal-element");
        var selectedIdealBank = null;
        idealBank.on('change', function(event) {
            if (event.empty) {
                selectedIdealBank = null;
            }
            if (event.complete) {
                selectedIdealBank = event.value;
            }
        });
        // End - Mount Ideal bank list to bank select option 

        // Start - Mount Credit Card element to collect Card Details

        var cardElements = stripe.elements();
        var isCardElementLoaded = false;
        var cardClientSecret = null;
        var cardPaymentReturnUrl = null; //result.url.paymentReturnUrl;
        var cardPaymentCancelUrl = null; //result.url.paymentCancelUrl;
        var cardStyles =  {
            base: {
                color: "#32325d",
            }
        };

        var cardSubmitButton = document.getElementById('payment-card-submit');

        var cardElement = cardElements.create("card", { style: cardStyles });
        cardElement.mount("#card-element");

        cardElement.addEventListener('change', ({error}) => {
            const displayError = document.getElementById('card-errors');
            if (error) {
                displayError.textContent = error.message;
                cardSubmitButton.disabled = true;
            } else {
                cardSubmitButton.disabled = false;
                displayError.textContent = '';
            }
        });

        cardSubmitButton.disabled = true;

        // End - Mount Credit Card element to collect Card Details

        // Start - Mount SEPA Direct Debit element to collect SEPA details

        var sepaElements = stripe.elements();
        var isSepaElementLoaded = false;
        var sepaClientSecret = null;
        var sepaPaymentReturnUrl = null; //result.url.paymentReturnUrl;
        var sepaPaymentCancelUrl = null; //result.url.paymentCancelUrl;
        var sepaPaymentSuccessUrl = null // Finish page url
        var sepacardSubmitButton = document.getElementById('payment-sepa-submit');

        var sepaStyle = {
            base: {
                color: '#32325d',
                fontSize: '16px',
                '::placeholder': {
                color: '#aab7c4'
                },
                ':-webkit-autofill': {
                color: '#32325d',
                },
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a',
                ':-webkit-autofill': {
                color: '#fa755a',
                },
            },
        };

        var sepaOptions = {
            style: sepaStyle,
            supportedCountries: ['SEPA'],
            // Elements can use a placeholder as an example IBAN that reflects
            // the IBAN format of your customer's country. If you know your
            // customer's country, we recommend that you pass it to the Element as the
            // placeholderCountry.
            // placeholderCountry: 'DE',
        };

        // Create an instance of the IBAN Element
        var sepaIban = sepaElements.create('iban', sepaOptions);

        // Add an instance of the IBAN Element into the `iban-element` <div>
        sepaIban.mount('#sepa-iban-element');

        sepaIban.on('change', function(event) {
            var displayError = document.getElementById('sepa-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
                displayError.style = "display: block";
            } else {
                displayError.textContent = '';
                displayError.style = "display: hidden";
            }
        });

        // End - Mount SEPA Direct Debit element to collect SEPA details

        var isApplePayLoaded = false;

        jQuery.noConflict()(function($){

            selectedPackage = $('input[name=package]:checked').val();
            packagePrice = getPackagePrice(selectedPackage);
            packageCurrency = getPackageCurrency(selectedPackage);
            var paymentMethod = $("input[name='payment_method']:checked").attr('data-name');

            /* Check Payment Method */
            checkPaymentMethodForStripeCard(paymentMethod, packagePrice);

            // $('#payment_method').on('change', function () {
            $('input:radio[name=payment_method]').on('change', function(e) {
                paymentMethod = $(this).data('name');
                checkPaymentMethodForStripeCard(paymentMethod, packagePrice);
            });

            $('.payment-method[data-method=card], .payment-method[data-method=ideal], .payment-method[data-method=eps], .payment-method[data-method=giropay], .payment-method[data-method=sofort], .payment-method[data-method=applepay], .payment-method[data-method=sepa]')
            .click(function(e) {
                $(this).find('input:radio').prop('checked', true);
                paymentMethod = $(this).find('input:radio').data('name');
                checkPaymentMethodForStripeCard(paymentMethod, packagePrice);
                e.preventDefault();
            });

            $('.package-selection').on('click', function () {
                selectedPackage = $(this).val();
                packagePrice = getPackagePrice(selectedPackage);
                packageCurrency = getPackageCurrency(selectedPackage);
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
                checkPaymentMethodForStripeCard(paymentMethod, packagePrice);
            });

            /* Send Payment Request */
            $('#submitPostForm').on('click', function (e)
            {
                e.preventDefault();
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
                var type = $('#accept_method').val();
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

            $('#payment-ideal-submit').on('click', function(e){
                e.preventDefault();
                if ($('#ideal-name').val() == "") {
                    $('#ideal-errors').text(stripecardValidationMessages['require_ideal_name']);
                    return false;
                }
                if (selectedIdealBank == null) {
                    console.log(stripecardValidationMessages);
                    $('#ideal-errors').text(stripecardValidationMessages['require_ideal_bank']);
                    return false;
                }
                $('#ideal-errors').html("");


                $('#couponDiscout').val(JSON.stringify(couponDiscountArr));
                $('#paymentMethodDiscount').val(JSON.stringify(savePaymentMethodCouponArr));
                // var addedDiscountData = '&coupon_discount_array='+JSON.stringify(couponDiscountArr)+'&payment_method_discount_array='+JSON.stringify(savePaymentMethodCouponArr);

                $.ajax({
                    url: $('#postForm').attr('action') + 'ajax',
                    method: "POST",
                    data: $('#postForm').serialize(),
                    beforeSend: function(){
                        $(".loading-process").show();
                    },
                    complete: function(){
                        $(".loading-process").hide();
                    },
                    success: function(data) {
                        if(data != '' && data != null){
                            var result = JSON.parse(data);
                            if(result.result != undefined && result.result == 'approved'){
                                window.location.href = result.url; return false;
                            }
                            stripe.confirmIdealPayment(
                                result.client_secret,
                                {
                                    payment_method: {
                                        ideal: idealBank,
                                    },
                                    return_url: result.url.paymentCheckUrl,
                                }
                            );
                        }else{
                            $('#ideal-errors').html(someErrorOccurredMessage);
                        }
                    }
                });
            });

            $('#payment-eps-submit').on('click', function(e) {
                e.preventDefault();
                // var addedDiscountData = '&coupon_discount_array='+JSON.stringify(couponDiscountArr)+'&payment_method_discount_array='+JSON.stringify(savePaymentMethodCouponArr);

                $('#couponDiscout').val(JSON.stringify(couponDiscountArr));
                $('#paymentMethodDiscount').val(JSON.stringify(savePaymentMethodCouponArr));
                $('#eps-errors').html('');
                $.ajax({
                    url: $('#postForm').attr('action') + 'ajax',
                    method: "POST",
                    data: $('#postForm').serialize(),
                    beforeSend: function(){
                        $(".loading-process").show();
                    },
                    complete: function(){
                        $(".loading-process").hide();
                    },
                    success: function(data) {

                        if(data != '' && data != null){
                            var result = JSON.parse(data);
                            if(result.result != undefined && result.result == 'approved'){
                                window.location.href = result.url; return false;
                            }else{
                                window.location.href = result.eps_redirect_url;    
                            }
                        }else{
                            $('#eps-errors').html(someErrorOccurredMessage);
                        }
                    }
                });
            });

            $('#payment-giropay-submit').on('click', function(e) {
                e.preventDefault();
                // var addedDiscountData = '&coupon_discount_array='+JSON.stringify(couponDiscountArr)+'&payment_method_discount_array='+JSON.stringify(savePaymentMethodCouponArr);
                $('#couponDiscout').val(JSON.stringify(couponDiscountArr));
                $('#paymentMethodDiscount').val(JSON.stringify(savePaymentMethodCouponArr));
                $('#giropay-errors').html('');
                $.ajax({
                    url: $('#postForm').attr('action') + 'ajax',
                    method: "POST",
                    data: $('#postForm').serialize(),
                    beforeSend: function(){
                        $(".loading-process").show();
                    },
                    complete: function(){
                        $(".loading-process").hide();
                    },
                    success: function(data) {
                        if(data != '' && data != null){
                            var result = JSON.parse(data);
                            if(result.result != undefined && result.result == 'approved'){
                                window.location.href = result.url; return false;
                            }else{
                                window.location.href = result.giropay_redirect_url;
                            }
                        }else{
                            $('#giropay-errors').html(someErrorOccurredMessage);
                        }
                    }
                });
            });            

            $('#payment-sofort-submit').on('click', function(e) {
                e.preventDefault();
                // var addedDiscountData = '&coupon_discount_array='+JSON.stringify(couponDiscountArr)+'&payment_method_discount_array='+JSON.stringify(savePaymentMethodCouponArr);
                $('#couponDiscout').val(JSON.stringify(couponDiscountArr));
                $('#paymentMethodDiscount').val(JSON.stringify(savePaymentMethodCouponArr));
                $('#sofort-errors').html('');
                $.ajax({
                    url: $('#postForm').attr('action') + 'ajax',
                    method: "POST",
                    data: $('#postForm').serialize(),
                    beforeSend: function(){
                        $(".loading-process").show();
                    },
                    complete: function(){
                        $(".loading-process").hide();
                    },
                    success: function(data) {
                        if(data != '' && data != null){
                            var result = JSON.parse(data);
                            if(result.result != undefined && result.result == 'approved'){
                                window.location.href = result.url; return false;
                            }
                            if (result.result == 'error') {
                                $('#sofort-errors').html(result.message).show();        
                                return false;                    
                            }
                            $('#sofort-errors').html('').hide();
                            window.location.href = result.sofort_redirect_url;
                        }else{
                            $('#sofort-errors').html(someErrorOccurredMessage);
                        }
                    }
                });
            });

            $('#payment-card-submit').on('click', function(e) {

                prepareCard();
                // stripe.confirmCardPayment(cardClientSecret, {
                //     payment_method: {
                //         card: cardElement,
                //     }
                // }).then(function(result) {
                //     if(result.error) {
                //         const displayError = document.getElementById('card-errors');
                //         displayError.textContent = result.error.message;
                //         return false;
                //     } else {
                //         if(result.paymentIntent.status === 'succeeded') {
                //             console.log(cardPaymentReturnUrl);
                //             window.location.href = cardPaymentReturnUrl;
                //         }
                //     }
                // });
            });
            $('#payment-applepay-submit').on('click', function(e) {
                prepareApplapay();
            });

            $("#payment-sepa-submit").on('click', function(e) {
                e.preventDefault();
                sepacardSubmitButton.disabled = true;
                prepareSepa();

            })


        });
        
        // make payment
        function confirmCardPayment(){
            stripe.confirmCardPayment(cardClientSecret, {
                payment_method: {
                    card: cardElement,
                }
            }).then(function(result) {
                if(result.error) {
                    const displayError = document.getElementById('card-errors');
                    displayError.textContent = result.error.message;
                    return false;
                } else {
                    if(result.paymentIntent.status === 'succeeded') {
                        window.location.href = cardPaymentReturnUrl;
                    }
                }
            });
        }

        function confirmSepaPayment() {
            var sepaName = $('#sepa-name').val();
            var sepaEmail = $('#sepa-email').val();
            stripe.confirmSepaDebitPayment(sepaClientSecret,{
                payment_method: {
                    sepa_debit: sepaIban,
                    billing_details: {
                        name: sepaName,
                        email: sepaEmail,
                    },
                },
            }).then(function(result) {
                if(result.error) {
                    sepacardSubmitButton.disabled = false;
                    $('#sepa-errors').html(result.error.message).show();
                } else {
                    $('#sepa-errors').html('').hide();
                    window.location.href = sepaPaymentReturnUrl;
                    // console.log(sepaPaymentReturnUrl); return false;
                    // window.location.href = sepaPaymentSuccessUrl;
                    // window.location.href = sepaPaymentReturnUrl;
                }
            });
        }


        /* Check the Payment Method */
        function checkPaymentMethodForStripeCard(paymentMethod, packagePrice)
        {
            var $form = $('#postForm');

            $form.find('#submitPostForm').html('{{ t('Pay') }}').prop('disabled', false);

            /* Hide errors on the form */
            $form.find('#stripePaymentErrors').hide();
            $form.find('#stripePaymentErrors').find('.payment-errors').text('');

            if (packagePrice <= 0) {
                return false;
            }
            $('.payment-errors').html('');
            $('.stripecard, .stripe-payment, .paypal-payment, .offline-payment').hide();

            switch (paymentMethod) {
                case 'ideal':
                    $('#payment-form-ideal').show();
                    disableYScroll();
                    $('#payment_sub_method').val('ideal');
                    break;
                case 'eps':
                    $('#payment-form-eps').show();
                    disableYScroll();
                    $('#payment_sub_method').val('eps');
                    break;
                case 'giropay':
                    $('#payment-form-giropay').show();
                    disableYScroll();
                    $('#payment_sub_method').val('giropay');
                    break;
                case 'sofort':
                    $('#payment-form-sofort').show();
                    disableYScroll();
                    $('#payment_sub_method').val('sofort');
                    break;
                case 'applepay':
                    $('#payment-form-applepay').show();
                    disableYScroll();
                    $('#payment_sub_method').val('applepay');
                    // prepareApplapay();
                    break;
                case 'card':
                    $('#payment-form-card').show();
                    disableYScroll();
                    $('#payment_sub_method').val('card');
                    // prepareCard();
                    break;
                case 'sepa':
                    $('#payment-form-sepa').show();
                    disableYScroll();
                    $('#payment_sub_method').val('sepa');
                    // prepareSepa();
                    break;

                default:
                    $('#payment_sub_method').val('');
                    $('.stripecard').hide();
                    break;
            }

            if (paymentMethod == 'stripecard' && packagePrice > 0) {
                $('#stripecardPayment').show();
            } else {
                $('#stripecardPayment').hide();
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

        function disableYScroll()
        {
            if ($('.mobile-section').is(':visible')) {
                $('html, body').css('overflow-y', 'hidden');
            } else {
                $("html, body").animate({ scrollTop: $(document).height() }, "slow");
            }
        }

        function enableYScroll()
        {
            $('html, body').css('overflow-y', 'auto');
        }

        function prepareApplapay()
        {
            if ( isApplePayLoaded ) {
                return true;
            }
            // var addedDiscountData = '&coupon_discount_array='+JSON.stringify(couponDiscountArr)+'&payment_method_discount_array='+JSON.stringify(savePaymentMethodCouponArr);
            $('#couponDiscout').val(JSON.stringify(couponDiscountArr));
            $('#paymentMethodDiscount').val(JSON.stringify(savePaymentMethodCouponArr));

            $.ajax({
                url: $('#postForm').attr('action') + 'ajax',
                method: "POST",
                data: $('#postForm').serialize(),
                success: function(data) {
                    var result = JSON.parse(data);
                    var applepayElement = stripe.elements();

                    var paymentReturnUrl = result.url.paymentReturnUrl;
                    var paymentCancelUrl = result.url.paymentCancelUrl;

                    var paymentRequest = stripe.paymentRequest({
                        country: result.user_country_code,
                        currency: result.currency,
                        total: {
                            label: "Go-Models@",
                            amount: result.amount
                        }
                    });

                    var prButton = applepayElement.create('paymentRequestButton', {
                        paymentRequest: paymentRequest
                    });

                    paymentRequest.canMakePayment().then(function(result) {
                        if (result && result.applePay) {
                            prButton.mount('#payment-request-button');
                            isApplePayLoaded = true;
                        } else {
                            alert("Your browser doesn't support Apple Pay. Please use other payment method!");
                            isApplePayLoaded = true;
                            $('#payment-form-applepay').hide();
                            enableYScroll();
                        }
                    });

                    paymentRequest.on('paymentmethod', function(ev) {
                        stripe.confirmCardPayment(
                            result.client_secret,
                            {
                                payment_method: ev.paymentMethod.id,
                            },
                            {
                                handleActions: false,
                            }
                        ).then(function(confirmResult) {
                            if (confirmResult.error) {
                                alert('Confirm result error.');
                                // Report to the browser that the payment failed, prompting it to
                                // re-show the payment interface, or show an error message and close
                                // the payment interface.
                                ev.complete('fail');
                            } else {
                                // Report to the browser that the confirmation was successful, prompting
                                // it to close the browser payment method collection interface.
                                ev.complete('success');
                                stripe.confirmCardPayment(result.client_secret).then(function(result) {
                                    // alert("Confirm Card Payment");
                                    if (result.error) {
                                        window.location.href = paymentCancelUrl;
                                        // alert("errror :" + result.error);
                                    // The payment failed -- ask your customer for a new payment method.
                                    } else {
                                        window.location.href = paymentReturnUrl
                                        // alert("The payment has succeeded.");
                                    // The payment has succeeded.
                                    }
                                });
                            }
                        })
                    });
                }
            });
        }

        function prepareCard()
        {   
            if(isCardElementLoaded) {
                return true;
            }

            var displayCardError = document.getElementById('card-errors');
            displayCardError.textContent = '';
            var paymentMethodId = '';

            cardSubmitButton.disabled = true;

            stripe.createPaymentMethod("card", cardElement).then(function(result) {
                if (result.error) {
                    cardSubmitButton.disabled = false;
                    // showError(result.error.message);
                    displayCardError.textContent = someErrorOccurredMessage; return false;
                } else {

                    $('#couponDiscout').val(JSON.stringify(couponDiscountArr));
                    $('#paymentMethodDiscount').val(JSON.stringify(savePaymentMethodCouponArr));

                    $.ajax({
                        url: $('#postForm').attr('action') + 'ajax',
                        method: "POST",
                        data: $('#postForm').serialize()+'&stripePaymentMethodId='+result.paymentMethod.id,
                        beforeSend: function(){
                          $(".loading-process").show();
                        },
                        complete: function(){
                            $(".loading-process").hide();
                        },
                        success: function(data) {
                            if(data != '' && data != null){
                                var result = JSON.parse(data);

                                if(result.result != undefined && result.result == 'approved'){
                                    window.location.href = result.url; return false;
                                }
                                if(result.client_secret != null && result.client_secret != '' ) {
                                    cardClientSecret = result.client_secret;
                                    isCardElementLoaded = true;
                                    cardPaymentReturnUrl = result.url.paymentReturnUrl;
                                    cardPaymentCancelUrl = result.url.paymentCancelUrl;
                                    window.location.href = cardPaymentReturnUrl;
                                    // confirmCardPayment();
                                }else{
                                    if(result.error){
                                        cardSubmitButton.disabled = false;
                                        displayCardError.textContent = result.error;
                                    }
                                }
                            }else{
                                cardSubmitButton.disabled = false;
                                displayCardError.textContent = someErrorOccurredMessage;
                            }
                        }
                    });
                }
            });
        }

        function prepareSepa()
        {

            // if(isSepaElementLoaded) {
            //     return true;
            // }
            // var addedDiscountData = '&coupon_discount_array='+JSON.stringify(couponDiscountArr)+'&payment_method_discount_array='+JSON.stringify(savePaymentMethodCouponArr);
            $('#couponDiscout').val(JSON.stringify(couponDiscountArr));
            $('#paymentMethodDiscount').val(JSON.stringify(savePaymentMethodCouponArr));
            var displaySepaError = document.getElementById('sepa-errors');
            displaySepaError.textContent = paymentProcessMessage;
            // sepacardSubmitButton.disabled = true;

           if(sepacardSubmitButton.disabled){
                // console.log('here');
                $.ajax({
                    url: $('#postForm').attr('action') + 'ajax',
                    method: "POST",
                    data: $('#postForm').serialize(),
                    beforeSend: function(){
                      $(".loading-process").show();
                    },
                    complete: function(){
                      $(".loading-process").hide();
                    },
                    success: function(data) {

                        // console.log(data); return false;
                        if(data != '' && data != null){
                            var result = JSON.parse(data);  
                            if(result.result != undefined && result.result == 'approved'){
                                window.location.href = result.url; return false;
                            }
                            if (result.client_secret != null && result.client_secret != '' ) {
                                sepaClientSecret = result.client_secret;
                                isSepaElementLoaded = true;
                                sepaPaymentReturnUrl = result.url.paymentReturnUrl;
                                sepaPaymentCancelUrl = result.url.paymentCancelUrl;
                                confirmSepaPayment();
                                // window.location.href = result.finish_page_url;
                            }
                        }else{
                            displaySepaError.textContent = someErrorOccurredMessage;
                            sepacardSubmitButton.disabled = false;
                        }



                        // $.ajax({
                        //     url: siteUrl+"/webhook-ajax",
                        //     type: "POST",
                        //     data:{"data": data},
                        //     success:function(data){ 
                        //         // return false;
                        //     }
                        // });
                    }
                })
           }
        }

    </script>
@endsection
