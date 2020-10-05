
function clearCookie(d,b,c){
    try{
        if(function(h){
            var e=document.cookie.split(";"),a="",f="",g="";
            for(i=0;i<e.length;i++){
                a=e[i].split("=");
                f=a[0].replace(/^\s+|\s+$/g,"");
                if(f==h){
                    if(a.length>1)g=unescape(a[1].replace(/^\s+|\s+$/g,""));
                    return g
                }
            }
            return null
        }
        (d)){
            b=b||document.domain;
            c=c||"/";document.cookie=d+"=; expires="+new Date+"; domain="+b+"; path="+c
        }
    }
    catch(j){}
};

window.addEventListener("load", function() {


    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var result = JSON.parse(this.responseText);
            if (result.showCookieConsentPopup == true) {

                window.cookieconsent.initialise({
                    container: document.getElementById("cookie-consent-block"),
                    palette: {
                        popup: { background: "#FFFFFF" },
                        button: { background: "#14a7d0" },
                        switches: {
                            background: "",
                            backgroundChecked: "",
                            switch: "#000000",
                            text: ""
                        }
                    },
                    setDiffDefaultCookiesFirstPV: 0,
                    blockScreen: 0,
                    position: "bottom-left",
                    type: 'detailedRev',
                    content: {
                        message: html,
                        deny: "I DO NOT ACCEPT",
                        allow: "I ACCEPT",
                        link: "",
                        savesettings: "Change Settings",
                    },
                    compliance: {
                        'detailedRev': '<div class="cc-compliance cc-highlight">{{allowall}} {{savesettings}}</div>',
                    },
                    elements: {
                        messageswitchlink: '<span id="cookieconsent:desc" class="cc-message">{{message}} <a aria-label="learn more about cookies" role=button tabindex="0" class="cc-link" href="{{href}}" rel="noopener noreferrer nofollow" target="{{target}}">{{link}}</a><div class="cc-allswitches {{allswitchesclasses}} cc-vivid-hide">{{allswitches}}</div></span>',
                        allowall: '<a aria-label="deny cookies" role=button tabindex="0"  class="cc-btn cc-vivid">{{savesettings}}</a>',
                        savesettings: '<a aria-label="deny cookies" role=button tabindex="0"  class="cc-btn cc-savesettings cc-allowall"><span style="display:inline;"><i class="fa fa-check"></i></span>{{allow}}</a>',
                    },
                    cookietypes: [{
                            label: "Technical",
                            checked: "checked",
                            disabled: "disabled",
                            cookie_suffix: "tech",
                        },
                        {
                            label: "Statistics",
                            checked: "checked",
                            disabled: "",
                            cookie_suffix: "statistics",
                        },
                        {
                            label: "Marketing",
                            checked: "checked",
                            disabled: "",
                            cookie_suffix: "marketing",
                        },
                        {
                            label: "Social Media",
                            checked: "checked",
                            disabled: "",
                            cookie_suffix: "socialmedia",
                        },
                    ],
                    revokable: true,
                    law: {
                        regionalLaw: true,
                        countryCode: 'ch',
                    },
                    onPopupOpen: function() {
                        console.log('open');
                        /* $('body').css({'background-color':'rgba(0, 0, 0, 0.3)'}); */
                    },
                    onPopupClose: function() {
                        console.log('close');
                        /* $('body').css({'background-color':'transparent'}); */
                    },
                    onStatusChange: function(status) {
                        var type = this.options.type;
                        var didConsent = this.hasConsented();
                        console.log("status changes");

                        window.dataLayer = window.dataLayer || [];
                        dataLayer.push({'event': 'cookies_accepted'});
                        if (document.querySelector('input[id="statistics"]').checked == true) {
                            dataLayer.push({'cookie_consent_statistics' : '1'});
                        } else {
                            dataLayer.push({'cookie_consent_statistics' : '0'});
                        }

                        if (document.querySelector('input[id="marketing"]').checked == true) {
                            dataLayer.push({'cookie_consent_marketing' : '1'});
                        } else {
                            dataLayer.push({'cookie_consent_marketing' : '0'});
                        }

                        if (document.querySelector('input[id="socialmedia"]').checked == true) {
                            dataLayer.push({'cookie_consent_socialmedia' : '1'});
                        } else {
                            dataLayer.push({'cookie_consent_socialmedia' : '0'});
                        }
                        dataLayer.push({'event': 'cookies_accepted'});

                        if (type == 'detailedRev' && didConsent) {
                            console.log('status change');
            
                            function gtag() { dataLayer.push(arguments); }
                            gtag('js', new Date());
                            gtag('config', 'GTM-5MDBX23'); /* Add your google tag manager id */
                        } 
                    },
                    onInitialise: function(status) {
                        var type = this.options.type;
                        var didConsent = this.hasConsented();
                        console.log("initialize");
                        if (type == 'detailedRev' && didConsent) {
                            console.log('intialize');
                            window.dataLayer = window.dataLayer || [];
            
                            function gtag() { dataLayer.push(arguments); }
                            gtag('js', new Date());
                            gtag('config', 'GTM-5MDBX23'); /*Add your google tag manager id */
                        } else {
                            console.log("cookie consent was not configured");
                            clearCookie();
                        }
                    }
                });

                document.querySelector('.cc-vivid').addEventListener('click', function () {
                    var vivid_btn_txt = this.text;
                    if (vivid_btn_txt == "Change Settings") {
                        this.text = "Save Settings";
                        document.querySelector('.cc-allswitches').classList.remove('cc-vivid-hide');
                    } else {
                        this.text = "Change Settings";
                        document.querySelector('.cc-allswitches').classList.add('cc-vivid-hide');
                    }
                });

                document.querySelector('.os_clickable_wecare').addEventListener('click', function () {
                    document.querySelectorAll('.os_clickable_col').forEach(function (element) {
                        element.classList.remove('osano_active');
                    });
                    document.querySelectorAll('.os_popup_txt').forEach(function (element) {
                        element.classList.remove('osano_active');
                        element.style.display = 'none';
                    });
                    this.classList.add('osano_active');
                    document.getElementById('wecare_txt').style.display = 'block';
                    document.getElementById('wecare_txt').classList.add('osano_active');
                });
                
                document.querySelector('.os_clickable_privacy').addEventListener('click', function () {
                    document.querySelectorAll('.os_clickable_col').forEach(function (element) {
                        element.classList.remove('osano_active');
                    });
                    document.querySelectorAll('.os_popup_txt').forEach(function (element) {
                        element.classList.remove('osano_active');
                        element.style.display = 'none';
                    });
                    this.classList.add('osano_active');
                    document.getElementById('privacy_txt').style.display = 'block';
                    document.getElementById('privacy_txt').classList.add('osano_active');
                });
                
                document.querySelector('.os_clickable_cookie').addEventListener('click', function () {
                    document.querySelectorAll('.os_clickable_col').forEach(function (element) {
                        element.classList.remove('osano_active');
                    });
                    document.querySelectorAll('.os_popup_txt').forEach(function (element) {
                        element.classList.remove('osano_active');
                        element.style.display = 'none';
                    });
                    this.classList.add('osano_active');
                    document.getElementById('cookie_txt').style.display = 'block';
                    document.getElementById('cookie_txt').classList.add('osano_active');
                });
            }
        }
    };

    xhttp.open('GET', '/getCountryInfo', true);
    xhttp.send();

});
