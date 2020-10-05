
var paymentCouponDiscountArr = '';
var responseCouponDiscountArr = '';
var couponDiscountArr = {};
var savePaymentMethodCouponArr = {};
if (packages > 0 && paymentMethods > 0){

    jQuery.noConflict()(function($){
        $(document).ready(function (){

            $('.coupon-img-div-mobile').hide();

            // default coupon value blanck
            $('#coupon_code').val('');
            // enable offline payment click event

            if(document.getElementById('offlinepayment_div')){
                document.getElementById('offlinepayment_div').style.pointerEvents = 'auto';
            }

            showPackagePriceTableDetails();
            
            $('.btn-close').click(function() {
                $('.discount-line').css('display','none');
                $('.payment-method-form').hide();
                $('body').css('overflow-y', 'auto');
            });

            /* Select a Package */
            $('.package-selection').click(function () {
                selectedPackageVal = $(this).val();
                $('#feature-' + selectedPackageVal).slideToggle();
                
                var totalReminderFees = $('.totalReminderFees').val();
                var reminderTax = $('.reminderTax').val();
                var selectedPackage = $('input[name=package]:checked');
                var package_name = selectedPackage.attr('data-name');
                var currency = selectedPackage.attr('data-currencysymbol');
                var price = parseFloat(selectedPackage.attr('data-price')).toFixed(2);
                var tax = parseFloat(selectedPackage.attr('data-tax'));
                var tax_amount = ((price * tax)/ 100).toFixed(2);
                var tax_amount = parseFloat(reminderTax) + parseFloat(tax_amount); //total tax
                $('.tax-int').val(tax_amount);
                var total = parseFloat(price) + parseFloat(tax_amount).toFixed(2);
                // $('#transaction_amount').val(total);
                // packagePrice = getPackagePrice(selectedPackage);
                packageCurrencySymbol = $(this).data('currencysymbol');
                packageCurrencyInLeft = $(this).data('currencyinleft');
                showAmount(total, packageCurrencySymbol, packageCurrencyInLeft);

                if(total != null && total != undefined && total != ""){
                    if (packageCurrencyInLeft == 1) {
                       $('.tax-calculation').html('('+packageCurrencySymbol+' '+tax_amount+' '+vat_label+')');
                    } else {
                       $('.tax-calculation').html('('+tax_amount+' '+packageCurrencySymbol+' '+vat_label+')');
                    }
                }
                
                showPaymentSubmitButton(currentPackagePrice, total, currentPaymentActive, paymentMethod);
            });

            // /* Select a Payment Method */
            $('input[type=radio][name=payment_method]').on('click', function () {
                paymentMethod = $(this).attr('data-name');
                showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentActive, paymentMethod);
                var paymentMethodDiscount = findPaymentDiscount(paymentMethod);
                calculatePrice(responseCouponDiscountArr, paymentMethodDiscount);
            });

            $('.payment-method[data-method=card], .payment-method[data-method=ideal], .payment-method[data-method=eps], .payment-method[data-method=giropay], .payment-method[data-method=sofort], .payment-method[data-method=applepay], .payment-method[data-method=sepa]')
                .click(function(e) {
                    $(this).find('input:radio').prop('checked', true);
                    paymentMethod = $(this).find('input:radio').data('name');
                    var paymentMethodDiscount =  findPaymentDiscount(paymentMethod);

                    // add label in responsive menu
                    var discountLable = $(this).find('input:radio').data('label');
                    $('.discount-line').hide();
                    // mobile payment discount Comment by AJ (23-04-2020)
                    // $('.paymentMethod-discount-td').css('border-bottom','none').html('');
                    if(discountLable != undefined && discountLable != null && discountLable != ""){
                        $('.discount-line').show();
                        $('#discount-lable-'+paymentMethod).html(discountLable);
                    }

                    calculatePrice(responseCouponDiscountArr, paymentMethodDiscount);
                });

            // $('.payment-method').click(function(e){
            //     // alert("before trigger");
            //     $(this).find('input[type=radio][name=payment_method]').attr('checked', true).trigger('click');
            //     // return false;
            // });


            /* Form Default Submission */
            $('#submitPostForm').on('click', function (e) {

                e.preventDefault();
                paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
                
                if (paymentMethod == 'stripe') {
                    var type = $('#accept_method').val();
                    if (type == 'cards') {

                        // if (!ccFormValidationForStripe()) {
                        //     return false;
                        // }

                        /* Call the token request function */
                       payWithStripe();
                    } else {

                       payWithSofort();
                    }
                }else{

                    if (packagePrice >= 0) {

                        $('#postForm').submit();
                        $(".loading-process").show();
                        $('#submitPostForm').prop('disabled', true);
                    }
                }

                /* Prevent form from submitting */
                return false;
            });
        });
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

function showPackagePriceTableDetails(){ 
    couponDiscountArr = {};
    $('#submitPostForm').prop('disabled', false);
    var totalReminderFees = $('.totalReminderFees').val();
    var reminderTax = $('.reminderTax').val();
    var selectedPackage = $('input[name=package]:checked');
    var package_name = selectedPackage.attr('data-name');
    var currency = selectedPackage.attr('data-currencysymbol');
    var price = parseFloat(selectedPackage.attr('data-price')).toFixed(2);
    var tax = parseFloat(selectedPackage.attr('data-tax'));
    var tax_amount = 0;
    // check package tax discount greater than 0
    if(parseFloat(tax) > 0 ){
        tax_amount = ((price * tax)/ 100).toFixed(2);
    }
    var tax_amount = parseFloat(reminderTax) + parseFloat(tax_amount); //total tax
    $('.tax-int').val(tax_amount);
    var total = (parseFloat(price) + parseFloat(tax_amount) + parseFloat(totalReminderFees)).toFixed(2);

    var packageCurrencySymbol = $('input[name=package]:checked').data('currencysymbol');
    var packageCurrencyInLeft = $('input[name=package]:checked').data('currencyinleft');
    // var paymentMethod = $('#payment_method').find('option:selected').data('name');
    var paymentMethod = $("input[name='payment_method']:checked").attr('data-name');
    // $('#transaction_amount').val(total);
    showAmount(Math.round(total).toFixed(2), packageCurrencySymbol, packageCurrencyInLeft);
    if(total != null && total != undefined && total != ""){

        if (packageCurrencyInLeft == 1) {
           $('.tax-calculation').html('('+packageCurrencySymbol+' '+tax_amount+' '+vat_label+')');
        } else {
           $('.tax-calculation').html('('+tax_amount+' '+packageCurrencySymbol+' '+vat_label+')');
        }
    }

    couponDiscountArr['is_coupon_applied'] = 0;
    savePaymentMethodCouponArr['is_payment_coupon_applied'] = 0;
    couponDiscountArr['transaction_amount'] = Math.round(total).toFixed(2);
}
jQuery.noConflict()(function($){
    $(document).ready(function($) {
        $('#validate_coupon').click( function(e){
            e.preventDefault();
            
            var coupon_code = $('#coupon_code').val();
            var go_code = $('#go_code').val();
            var token = $('input[name=_token]').val();
            var is_renew = $('input[name=is_renew]').val();
            var user_id = $('#userId').val();
            var post_id = $('input[name=post_id]').val();

            data = {
                '_token' : token,
                'coupon_code' : coupon_code,
                'go_code' : go_code,
                'is_renew' : is_renew,
                'user_id' : user_id,
                'post_id' : post_id,
            }

            $.ajax({
                url: $('#postForm').attr('action') + '/' + 'validatecoupon',
                method: "POST",
                type:'json',
                data: data,
                beforeSend: function(){
                  $(".loading-process").show();
                  $('#coupon_error').hide();
                },
                complete: function(){
                  $(".loading-process").hide();
                },
                success: function(response) {
                    if(response.status == true){ 

                        responseCouponDiscountArr = response.data;
                        calculatePrice(responseCouponDiscountArr, paymentCouponDiscountArr);
                        $('.apply-coupon-tr').hide();
                        $('.coupon-img-div-mobile').show();
                    }else{

                        responseCouponDiscountArr = '';
                        $('.discount-title').html('-');
                        $('.discount-amount').html('-'); 
                        $('.discount-row').hide();
                        
                        // check payment method coupon
                        if (typeof paymentCouponDiscountArr != 'undefined' && paymentCouponDiscountArr != null && paymentCouponDiscountArr != ''){
                            calculatePrice(responseCouponDiscountArr, paymentCouponDiscountArr);
                        }else{
                            $('.payment-discount-title').html('-');
                            $('.payment-discount-amount').html('-');
                            $('.payment-discount-row').hide();
                            // call function page onload default package view  
                            showPackagePriceTableDetails();
                        }
                        // enable offline payment click event
                        if(document.getElementById('offlinepayment_div')){
                            document.getElementById('offlinepayment_div').style.pointerEvents = 'auto';
                        }

                        if(response.message != undefined && response.message != ''){

                            var message = response.message;
                        }else{
                            var message = someErrorOccurredMessage;
                        }

                        
                        var coupon_error_message = '<span class="fa fa-exclamation-circle"></span>'+message;
                        $('#coupon_error').html(coupon_error_message);
                        $('#coupon_error').show();
                    }
                }
            });
        });

        // $('#postForm').on('submit', function(e){
        //     $('#couponDiscout').val(JSON.stringify(couponDiscountArr));
        //     $('#paymentMethodDiscount').val(JSON.stringify(savePaymentMethodCouponArr));
        //     this.submit(); 
        //     return true;
        // });
    });
});

window.onload = function() {
    document.getElementById('postForm').onsubmit = function() {
        $('#couponDiscout').val(JSON.stringify(couponDiscountArr));
        $('#paymentMethodDiscount').val(JSON.stringify(savePaymentMethodCouponArr));
    };
};
/*
    #calculate price with discount coupon code and payment method discount
*/
function calculatePrice(couponDiscountData = '', paymentMethodDiscountData = ''){

    couponDiscountArr = {};
    savePaymentMethodCouponArr = {};
    couponDiscountArr['is_coupon_applied'] = 0;
    savePaymentMethodCouponArr['is_payment_coupon_applied'] = 0;

    // total package Amount with tax and without discount
    var packageTotalAmount = parseFloat($('.package-total-price').html()).toFixed(2);
    // package price
    var packagePrice = parseFloat($('.price-int').html()).toFixed(2);
    // package tax
    var packageTax = parseInt($('.package-tax').html());
    // discount coupon tax asign default package tax
    var discount_coupon_tax = packageTax;
    var PaymentMethodDiscountAmount = 0;
    var discountAmount = 0;
    //packages currency symbol
    var packageCurrencySymbol = $('input[name=package]:checked').data('currencysymbol');
    // currency symbol left or right side
    var packageCurrencyInLeft = $('input[name=package]:checked').data('currencyinleft');

    var packageCurrencyCode = $('input[name=package]:checked').data('currencycode');

    var packageTaxAmount = parseFloat(packagePrice * packageTax / 100).toFixed(2);
    
    // check condition coupon code apply or not
    if (typeof couponDiscountData != 'undefined' && couponDiscountData != null && couponDiscountData != '') {
        // discount sent
        var discount = couponDiscountData.discount;
        // discount type RS or percentage
        var type = couponDiscountData.type;
        // CRM coupon Id
        var coupon_id = couponDiscountData.coupon_id;
        // CRM coupon id coupon
        var coupon_id_coupon = couponDiscountData.coupon_id_coupon;
        // CRM coupon code
        var coupon = couponDiscountData.coupon;

        // chack coupon discount greater than 0
        if(parseFloat(discount) > 0 ){

            // disabled offline payment click event
            if(document.getElementById('offlinepayment_div')){
                $("#offlinepayment_div").find( ".card-body" ).css( "background-color", "#dddddd" );
                document.getElementById('offlinepayment_div').style.pointerEvents = 'none';
                $('#payment_method_5').prop('checked', false);
                $('.offline-payment').hide();
            }

            if(locale == 'de'){ 
                $('.discount-title').html(couponDiscountData.coupon_name.german);
                // CRM coupon name
                var coupon_name = couponDiscountData.coupon_name.german;
            }else{
                $('.discount-title').html(couponDiscountData.coupon_name.english);
                // CRM coupon name
                var coupon_name = couponDiscountData.coupon_name.english;
            }

            var discount_coupon_tax = 0;

            if(type == 'cash'){
                // total discount amount
                var discountAmount = discount;
            }else{
                // package price without added tax discount amount 
                var discountAmount = ((packageTotalAmount * discount)/ 100).toFixed(2);
            }

            // calculate new total package price
            var newTotalPackagePrice = parseFloat(packageTotalAmount - discountAmount).toFixed(2);
            
            packageTotalAmount = parseFloat(newTotalPackagePrice).toFixed(2);

            
            // check package tax discount greater than 0
            if(parseFloat(packageTax) > 0 ){
                //calculate new package tax
                var newTaxCalculate = parseFloat(packageTax / 100 + 1).toFixed(2);
                // package price
                packagePrice = parseFloat(newTotalPackagePrice / newTaxCalculate).toFixed(2);
                // package tax amount
                packageTaxAmount = parseFloat(packagePrice * packageTax / 100).toFixed(2);

                // discount coupon tax calculate
                var discount_coupon_tax_calculate = parseFloat(discountAmount / newTaxCalculate).toFixed(2);
                // coupon discount tax
                var discount_coupon_tax = parseFloat(discountAmount - discount_coupon_tax_calculate).toFixed(2);
            }
            
            if(type == 'cash'){
                // show price
                if (packageCurrencyInLeft == 1) {
                    var show_discount_html = packageCurrencySymbol +' '+ parseFloat(discount).toFixed(2);
                } else {
                    var show_discount_html =  parseFloat(discount).toFixed(2) +' '+ packageCurrencySymbol;
                }
                var discount_name_coupon_html = parseFloat(discount).toFixed(2) +' '+ packageCurrencyCode;
            }else{
                var show_discount_html = discount+'%';
                var discount_name_coupon_html = discount+'%';;
            }
            
            $('.discount-row').show();
            $('.discount-amount').html(show_discount_html);
            // mobile discount comment by AJ (23-04-2020)
            // $('.coupon-discount-td').css('border-bottom','1px solid #D3E3EF').html('<span style="font-weight:600">'+discountLabel+':</span> ' + couponDiscountArr['coupon_name']+' '+ show_discount_html);
            
            couponDiscountArr['crm_coupon_id'] = coupon_id;
            couponDiscountArr['crm_coupon_id_coupon'] = coupon_id_coupon;
            couponDiscountArr['crm_coupon'] = coupon;
            couponDiscountArr['crm_discount'] = discount;
            couponDiscountArr['crm_discount_type'] = type;
            couponDiscountArr['is_coupon_applied'] = 1;
            couponDiscountArr['discount_coupon_amount'] = discountAmount;
            couponDiscountArr['discount_coupon_tax'] = discount_coupon_tax;
            couponDiscountArr['coupon_name'] = coupon_name+' - '+discount_name_coupon_html+' ('+ coupon +')';
            couponDiscountArr['coupon_type'] = couponDiscountData.coupon_type;
        }
    }

    // check payment method coupon apply or not
    if (typeof paymentMethodDiscountData != 'undefined' && paymentMethodDiscountData != null && paymentMethodDiscountData != ''){ 
        
        var paymentMethosDiscountId = paymentMethodDiscountData.id;
        var paymentMethosDiscountName = paymentMethodDiscountData.name_int;
        var paymentMethosDiscountCouponCode = paymentMethodDiscountData.coupon_code;
        var paymentMethosDiscountType = paymentMethodDiscountData.type;
        var paymentMethodDiscount = paymentMethodDiscountData.discount;
        var paymentMethosDiscountCouponIdCoupon = paymentMethodDiscountData.id_coupon_coupon;
        var payment_discount_coupon_tax = 0;
        
        // chack paymnet discount greater than 0
        if(parseFloat(paymentMethodDiscount) > 0 ){
            
            if(paymentMethosDiscountType == 'cash'){
                // payment discount price
                var PaymentMethodDiscountAmount = paymentMethodDiscount;
            }else{
                var PaymentMethodDiscountAmount = ((packageTotalAmount * paymentMethodDiscount) / 100).toFixed(2);
            }
            // calculate new total package price
            var newTotalPackagePrice = parseFloat(packageTotalAmount - PaymentMethodDiscountAmount).toFixed(2);
            packageTotalAmount = parseFloat(newTotalPackagePrice).toFixed(2);
            // check package tax discount greater than 0
            if(parseFloat(packageTax) > 0 ){
                // calculate new tax
                var newTaxCalculate = parseFloat(packageTax / 100 + 1).toFixed(2);
                // package price
                packagePrice = parseFloat(newTotalPackagePrice / newTaxCalculate).toFixed(2);
                // package discount tax
                var packageTaxAmount = parseFloat(packagePrice * packageTax / 100).toFixed(2);
                // discount coupon tax calculate
                var payment_discount_coupon_tax_calculate = parseFloat(PaymentMethodDiscountAmount / newTaxCalculate).toFixed(2);
                // coupon discount tax
                var payment_discount_coupon_tax = parseFloat(PaymentMethodDiscountAmount - payment_discount_coupon_tax_calculate).toFixed(2);
            }
            
            if(paymentMethosDiscountType == 'cash'){
                //show package price in view
                if (packageCurrencyInLeft == 1) {
                    var show_payment_method_discount_html = packageCurrencySymbol +' '+ parseFloat(paymentMethodDiscount).toFixed(2);
                } else {
                    var show_payment_method_discount_html =  parseFloat(paymentMethodDiscount).toFixed(2) +' '+ packageCurrencySymbol;
                }
                // concate name with api data
                var payment_discount_name_coupon_html = parseFloat(paymentMethodDiscount).toFixed(2) +' '+ packageCurrencyCode;
            }else{
                var show_payment_method_discount_html = paymentMethodDiscount+'%';
                var payment_discount_name_coupon_html = paymentMethodDiscount+'%';
            } 
            
            $('.payment-discount-row').show();
            $('.payment-discount-title').html(paymentMethosDiscountName);
            $('.payment-discount-amount').html(show_payment_method_discount_html);

            // mobile payment discount Comment by AJ (23-04-2020)
            // $('.paymentMethod-discount-td').css('border-bottom','1px solid #D3E3EF').html('<span style="font-weight:600">'+discountLabel+':</span> ' + paymentMethosDiscountName+' '+ show_payment_method_discount_html);
            
            savePaymentMethodCouponArr['payment_method_discount_name'] =  paymentMethosDiscountName+' - '+payment_discount_name_coupon_html+' ('+ paymentMethosDiscountCouponCode +')';;
            savePaymentMethodCouponArr['payment_method_discount'] = paymentMethodDiscount;
            savePaymentMethodCouponArr['payment_method_discount_type'] = paymentMethosDiscountType;
            savePaymentMethodCouponArr['payment_method_discount_coupon_code'] = paymentMethosDiscountCouponCode;
            savePaymentMethodCouponArr['payment_method_discount_amount'] = PaymentMethodDiscountAmount;
            savePaymentMethodCouponArr['payment_method_discount_tax'] = payment_discount_coupon_tax;
            savePaymentMethodCouponArr['payment_method_discount_id'] = paymentMethosDiscountId;
            savePaymentMethodCouponArr['payment_method_discount_coupon_id_coupon'] = paymentMethosDiscountCouponIdCoupon;
            savePaymentMethodCouponArr['is_payment_coupon_applied'] = 1;
            savePaymentMethodCouponArr['payment_method_coupon_type'] = paymentMethodDiscountData.coupon_type;
        }else{
            savePaymentMethodCouponArr['is_payment_coupon_applied'] = 0;
            $('.payment-discount-row').hide();
            $('.payment-discount-title').html('-');
            $('.payment-discount-amount').html('-');
        }
    }else{
        savePaymentMethodCouponArr['is_payment_coupon_applied'] = 0;
        $('.payment-discount-row').hide();
        $('.payment-discount-title').html('-');
        $('.payment-discount-amount').html('-');
    }
    
    // Reminder fees
    var totalReminderFees = $('.totalReminderFees').val();
    var tax_amount = parseFloat(packageTaxAmount).toFixed(2);
    var totalAmount = (parseFloat(packageTotalAmount) + parseFloat(totalReminderFees)).toFixed(2);
    // show footer payble amount html
    showAmount(totalAmount, packageCurrencySymbol, packageCurrencyInLeft);
    $('.tax-int').val(tax_amount);
    if(totalAmount != null && totalAmount != undefined && totalAmount != ""){
        if (packageCurrencyInLeft == 1) {
           $('.tax-calculation').html('('+packageCurrencySymbol+' '+tax_amount+' '+vat_label+')');
        } else {
           $('.tax-calculation').html('('+tax_amount+' '+packageCurrencySymbol+' '+vat_label+')');
        }
    }
    // tax amount
    couponDiscountArr['coupon_tax'] = tax_amount;
    // total transaction amount
    couponDiscountArr['transaction_amount'] = totalAmount;
    // payment methos and coupon discount amount total
    couponDiscountArr['total_discounted_amount_with_payment_method_coupon'] = (parseFloat(PaymentMethodDiscountAmount) + parseFloat(discountAmount)).toFixed(2);    
}

/*
    #find selected payment method discount available or not 
*/
function findPaymentDiscount(paymentMethod){


    var data = $.parseJSON(couponPaymentListArr);

    switch (paymentMethod) {
        case 'ideal':
             paymentCouponDiscountArr = data.ideal;
            break;
        case 'eps':
            paymentCouponDiscountArr = data.eps;
            break;
        case 'giropay':
            paymentCouponDiscountArr = data.giropay;
            break;
        case 'sofort':
            paymentCouponDiscountArr = data.sofort;
            break;
        case 'applepay':
            paymentCouponDiscountArr = data.applepay;
            break;
        case 'card':
            paymentCouponDiscountArr = data.card;
            break;
        case 'paypal':
            paymentCouponDiscountArr = data.paypal;
            break;
        case 'offlinepayment':
            paymentCouponDiscountArr = data.offlinepayment;
            break;
        case 'sepa':
            paymentCouponDiscountArr = data.sepa;
            break;

        default:
            paymentCouponDiscountArr = '';
            break;
    }
    return paymentCouponDiscountArr;
}