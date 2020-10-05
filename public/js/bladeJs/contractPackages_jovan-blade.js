
function initCredit()
{
  var stripe = Stripe('pk_test_TYooMQauvdEDq54NiTphI7jx');
  var elements = stripe.elements();

  $.get({

  });
  // Set up Stripe.js and Elements to use in checkout form
  var style = {
    base: {
      color: "#32325d",
    }
  };

  var card = elements.create("card", { style: style });
  card.mount("#credit-element");

  card.addEventListener('change', ({error}) => {
    const displayError = document.getElementById('credit-errors');
    if (error) {
      displayError.textContent = error.message;
    } else {
      displayError.textContent = '';
    }
  });

  var submitButton = document.getElementById('credit-submit');

  submitButton.addEventListener('click', function(ev) {
    stripe.confirmCardPayment(clientSecret, {
      payment_method: {
        card: card,
        billing_details: {
          name: 'Jenny Rosen'
        }
      }
    }).then(function(result) {
      if (result.error) {
        // Show error to your customer (e.g., insufficient funds)
        console.log(result.error.message);
      } else {
        // The payment has been processed!
        if (result.paymentIntent.status === 'succeeded') {
          // Show a success message to your customer
          // There's a risk of the customer closing the window before callback
          // execution. Set up a webhook or plugin to listen for the
          // payment_intent.succeeded event that handles any business critical
          // post-payment actions.
        }
      }
    });
  });
}

var stripe = Stripe(stripePubKey);
var creditCardElements = stripe.elements();
var creditCardElementsStyle = {
    base: {
        color: "#32325d",
    }
};
var creditCard = creditCardElements.create("card", { style: creditCardElementsStyle });
creditCard.mount("#credit-element");

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

if (packages > 0 && paymentMethods > 0){

    $(document).ready(function (){

        $('.payment-method-form').hide();

        var selectedPackage = $('input[name=package]:checked');
        var package_name = selectedPackage.attr('data-name');
        var currency = selectedPackage.attr('data-currencysymbol');
        var currencyCode = selectedPackage.attr('data-currencycode');
        var price = parseFloat(selectedPackage.attr('data-price')).toFixed(2);
        var tax = parseFloat(selectedPackage.attr('data-tax'));
        var tax_amount = ((price * tax)/ 100).toFixed(2);
        var total = Math.round(parseFloat(price) + parseFloat(tax_amount)).toFixed(2);

        var packageCurrencySymbol = $('input[name=package]:checked').data('currencysymbol');
        var packageCurrencyInLeft = $('input[name=package]:checked').data('currencyinleft');

        // var paymentMethod = $('#payment_method').find('option:selected').data('name');
        var paymentMethod = $("input[name='payment_method']:checked").attr('data-name');

        showAmount(total, packageCurrencySymbol, packageCurrencyInLeft);
        if(total != null && total != undefined && total != ""){

            if (packageCurrencyInLeft == 1) {
               $('#tax-calculation').html('( '+packageCurrencySymbol+' '+tax_amount+' '+vat_label+' )');
            } else {
               $('#tax-calculation').html('( '+tax_amount+' '+packageCurrencySymbol+' '+vat_label+' )');
            }
        }
        /* Select a Package */
        $('.package-selection').click(function () {
            selectedPackageVal = $(this).val();
            $('#feature-' + selectedPackageVal).slideToggle();

            var selectedPackage = $('input[name=package]:checked');
            var package_name = selectedPackage.attr('data-name');
            var currency = selectedPackage.attr('data-currencysymbol');
            var currencyCode = selectedPackage.attr('data-currencycode');
            var price = parseFloat(selectedPackage.attr('data-price')).toFixed(2);
            var tax = parseFloat(selectedPackage.attr('data-tax'));
            var tax_amount = ((price * tax)/ 100).toFixed(2);
            var total = Math.round(parseFloat(price) + parseFloat(tax_amount)).toFixed(2);

            // packagePrice = getPackagePrice(selectedPackage);
            packageCurrencySymbol = $(this).data('currencysymbol');
            packageCurrencyInLeft = $(this).data('currencyinleft');
            showAmount(total, packageCurrencySymbol, packageCurrencyInLeft);

            if(total != null && total != undefined && total != ""){
                if (packageCurrencyInLeft == 1) {
                   $('#tax-calculation').html('( '+packageCurrencySymbol+' '+tax_amount+' '+vat_label+' )');
                } else {
                   $('#tax-calculation').html('( '+tax_amount+' '+packageCurrencySymbol+' '+vat_label+' )');
                }
            }
            
            showPaymentSubmitButton(currentPackagePrice, total, currentPaymentActive, paymentMethod);
        });


        $('.btn-close').click(function() {
            $('.payment-method-form').hide();
            $('body').css('overflow-y', 'auto')
        });

        paypal.Buttons({
            style: {
                layout: 'horizontal',
                tagline: false,
                size: 'responsive',
            },

            funding: {
                disallowed: [paypal.FUNDING.CREDIT, paypal.FUNDING.CARD]
            },
            createOrder: function(data, actions) {
              // This function sets up the details of the transaction, including the amount and line item details.
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                        value: '0.01'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
              // This function captures the funds from the transaction.
              return actions.order.capture().then(function(details) {
                // This function shows a transaction success message to your buyer.
                alert('Transaction completed by ' + details.payer.name.given_name);
              });
            }
          }).render('#payment-form-paypal .payment-method-form-inner');


        // paypal.Button.render({
        //     style: {
        //         size: 'responsive'
        //     }
        // }, '#payment-form-paypal .payment-method-form-inner');


        $('.payment-method input[type="radio"]').click(function(event) {
            event.preventDefault();
        });

        $('.payment-method').click(function() {
            var method = $(this).data('method');
            if ($(this).find('input[type="radio"]').prop('checked') == false) {
                $('input[name="payment_method"]').attr("checked", false);
                $(this).find('input[type="radio"]').attr('checked', true);

                $('.payment-method-form').each(function() {
                    if ($(this).attr('id') == 'payment-form-' + method) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                if ($('.mobile-section').is(':visible')) {
                    $('body').css('overflow-y', 'hidden')
                }
            }

            switch (method) {
                case "credit":
                    processCreditPayment(total, currencyCode, username);
                    break;
                case "ideal":
                    processIdealPayment(total, currencyCode, username);
                    break;
                case "eps":
                    document.getElementById('payment-eps-submit').addEventListener('click', function(event){
                        processSourcePayment(total, currencyCode, username, 'eps');
                    })
                    break;
                case "giropay":
                    document.getElementById('payment-giropay-submit').addEventListener('click', function(event){
                        processSourcePayment(total, currencyCode, username, 'giropay');
                    })
                    break;
                case "sofort":
                    document.getElementById('payment-sofort-submit').addEventListener('click', function(event){
                        processSourcePayment(total, currencyCode, username, 'sofort');
                    })
                    break;
                case "applepay":
                    processApplePayment(total, currencyCode, username, 'applepay');
                    break;
                case "paypal":
                    // processPaypalPayment(total, currencyCode, username, 'paypal');
                    break;
                default:
                    break;
            }

      });

    });
}

/**
 * Card Payment
 */
function processCreditPayment(amount, currency, username)
{
    $.ajax({
        url: createPaymentIntentUrl,
        method: 'GET',
        data: {
            method: 'card',
            amount: amount * 100,
            currency: currency,
            username: username
        },
        dataType: 'json',
        success: function(result) {
            
            creditCard.addEventListener('change', ({error}) => {
                const displayError = document.getElementById('credit-errors');
                if (error) {
                    displayError.textContent = error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            var btnCreditCardSubmit = document.getElementById('credit-submit');

            btnCreditCardSubmit.addEventListener('click', function(event) {

                console.log(result.client_secret);
                stripe.confirmCardPayment(result.client_secret, {
                    payment_method: {card: creditCard}
                }).then(function(result) {
                    if (result.error) {
                        // Show error to your customer (e.g., insufficient funds)
                        console.log(result.error.message);
            
                        divAlert.textContent = result.error.message;
                        divAlert.style.display = "block";
                    } else {
                        // The payment has been processed!
                        console.log("-----------------------CARD PAYMENT PROCESSED-----------------------");
                        console.log(result);
                        if (result.paymentIntent.status === 'succeeded') {
                            console.log("-----------------------CARD PAYMENT SUCCEEDED-----------------------");
                            console.log(result);
                            //   document.location.href = '/payment';
                            // Show a success message to your customer
                            // There's a risk of the customer closing the window before callback execution
                            // Set up a webhook or plugin to listen for the payment_intent.succeeded event
                            // that handles any business critical post-payment actions
                        }
                    }
                });
            });        
        }
    });
}

/**
 * iDeal Bank Payment
 */
function processIdealPayment(amount, currency, username)
{
    $.ajax({
        url: createPaymentIntentUrl,
        method: 'GET',
        data: {
            method: 'ideal',
            amount: amount * 100,
            currency: 'eur',
            username: username
        },
        dataType: 'json',
        success: function(result) {
            var selectedBank = null;
            idealBank.on('change', function(event) {
                selectedBank = event.value;
            });

            var idealPaymentForm = document.getElementById('form-ideal-payment');

            idealPaymentForm.addEventListener('submit', function(event) {
                event.preventDefault();
                if(!selectedBank) {
                    return false;
                }
                stripe.confirmIdealPayment(
                    result.client_secret,
                    {
                        payment_method: {
                            ideal: idealBank,
                        },
                        return_url: 'http://192.168.0.23/',
                    }
                );
            });
        }
    });
}

/**
 * EPS, Giropay, SOFORT Payment
 */
function processSourcePayment(amount, currency, username, type) {
    var stripe = Stripe(stripePubKey);

    var opts = {
        type: type,
        amount: amount*100,
        currency: 'eur',
        statement_descriptor: username,
        owner: {
            name: "Sample Username",
        },
        redirect: {
            return_url: "http://192.168.0.23/",
        },
    };

    if(type == 'sofort') {
        opts['sofort'] = {
            country: 'DE',
            preferred_language: 'de',
        };
    }

    stripe.createSource(opts).then(function(result) {
        const displayError = document.getElementById('div-alert');
        if(result.error) {
            switch (result.error.type) {
                case 'payment_method_not_available':
                    displayError.textContent = result.error.message;
                    break;
                case 'processing_error':
                    displayError.textContent = result.error.message;
                    break;
                case 'invalid_amount':
                    displayError.textContent = result.error.message;
                    break;
                case 'invalid_sofort_country':
                    displayError.textContent = result.error.message;
                case 'invalid_request_error':
                    displayError.textContent = result.error.message;
                    break;
            }
            displayError.style.display = 'block';
        } else {
            console.log(result);
            document.location.href = result.source.redirect.url;
        }
    });
}

/**
 * Apple Pay 
 * 
 * @param {*} amount 
 * @param {*} currency 
 * @param {*} username 
 * @param {*} type 
 */
function processApplePayment(amount, currency, username, type){
    var stripe = Stripe(stripePubKey);
    var paymentRequest = stripe.paymentRequest({
        country: 'US',
        currency: 'usd',
        total: {
            label: 'Demo total',
            amount: amount * 100,
        },
        requestPayerName: true,
        requestPayerEmail: true,
    });

    var elements = stripe.elements();
    var prButton = elements.create('paymentRequestButton', {
        paymentRequest: paymentRequest,
    });

    // Check the availability of the Payment Request API first.
    paymentRequest.canMakePayment().then(function(result) {
        // alert(result);
        if (result) {
            prButton.mount('#payment-form-applepay .payment-method-form-inner');
        } else {
            document.getElementById('payment-form-applepay').style.display = 'none';
            $('body').css('overflow-y', 'auto')
        }
    });
}





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

function showAmount(t, e, i) {
    $(".payable-amount").html(t), $(".amount-currency").html(e), 1 == i ? ($(".amount-currency.currency-in-left").show(), $(".amount-currency.currency-in-right").hide()) : ($(".amount-currency.currency-in-left").hide(), $(".amount-currency.currency-in-right").show()), t <= 0 ? $("#packagesTable").hide() : $("#packagesTable").show()
}

function getPackagePrice(t) {
    var e = $("#price-" + t + " .price-int").html();
    return e = parseFloat(e)
}
