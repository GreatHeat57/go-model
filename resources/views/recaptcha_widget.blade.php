<?php
if ( ! function_exists('renderDataAttributes')) {
    function renderDataAttributes($attributes)
    {
        $mapped = [ ];
        foreach ($attributes as $key => $value) {
            $mapped[] = 'data-' . $key . '="' . $value . '"';
        };

        return implode(' ', $mapped);
    }
}
$divID = 'recap_'.uniqid();
?>
@if(!isset($jsincluded) || !$jsincluded)
    @if(!empty($options))
        <script type="text/javascript">
            var RecaptchaOptions = <?=json_encode($options) ?>;

            var HEADER_HEIGHT = 0; // Height of header/menu fixed if exists
            var isIOS = /iPhone|iPad|iPod/i.test(navigator.userAgent);
            var grecaptchaPosition;

            console.log(isIOS);

            var isScrolledIntoView = function (elem) {
              var elemRect = elem.getBoundingClientRect();
              var isVisible = (elemRect.top - HEADER_HEIGHT >= 0 && elemRect.bottom <= window.innerHeight);
              return isVisible;
            };

            if (isIOS) {
                $('body').attr('style', 'overflow: visible !important');
                $('.mfp-wrap').attr('style', 'position: fixed !important');
                var recaptchaElements = document.querySelectorAll('.g-recaptcha');
                window.addEventListener('scroll', function () {
                    Array.prototype.forEach.call(recaptchaElements, function (element) {
                      if (isScrolledIntoView(element)) {
                        grecaptchaPosition = document.documentElement.scrollTop || document.body.scrollTop;
                      }
                    });
                }, false);
            }

            var onReCaptchaSuccess = function () {
              if (isIOS && grecaptchaPosition !== undefined) {
                window.scrollTo(0, grecaptchaPosition);
              }
            };

            function CaptchaCallback() {
                /*
                if (window.innerWidth < 768 && (/iPhone|iPod/.test(navigator.userAgent) && !window.MSStream)) {
                    var destElementOffset = $('.g-recaptcha').position().top - window.innerWidth;
                    $('html, body').animate({ scrollTop: destElementOffset }, 0);
                }
                */

                
                $('.g-recaptcha').each(function(){
                    try{
                        var widgetId = grecaptcha.render($(this).attr('id'), {'sitekey' : '{{ $public_key }}'});
                        $(this).attr('data-widgetId', widgetId);
                    }catch(error){/*possible duplicated instances*/}
                })
            }
        </script>
    @endif
    <script src='https://www.google.com/recaptcha/api.js?onload=CaptchaCallback{{ (isset($lang) ?
            '&hl='.$lang : "") }}&render=explicit' async defer></script>
    <?php
        View::share('jsincluded', true);
    ?>
@endif
<div id="{{ $divID }}" class="g-recaptcha" data-sitekey="{{ $public_key }}" data-callback="onReCaptchaSuccess" data-widgetId="" <?=renderDataAttributes($dataParams)?>></div>

