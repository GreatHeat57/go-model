@extends('layouts.app')

@section('content')
    
    <!-- <div class="cover">
    
        <div class="slotholder " style="position: absolute; top: 0px; left: 0px; z-index: 0; width: 100%; height: 100%; visibility: inherit; opacity: 1; transform: matrix(1, 0, 0, 1, 0, 0);"><div class="tp-bgimg defaultimg" style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url(&quot;http://go-model.local/images/partner-benefits/partner-benefits-5.jpg&quot;); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit; z-index: 20;" src="http://go-model.local/images/partner-benefits/partner-benefits-5.jpg"></div></div>
        <div id="rrzt_144" class="rev_row_zone rev_row_zone_top" style="z-index: 7;">

        <div class="tp-parallax-wrap rev_row_wrap" style="position: relative; visibility: visible; left: 0px; top: 0px; width: 1422px; z-index: 7;"><div class="tp-loop-wrap" style="position:relative;;"><div class="tp-mask-wrap" style="position: relative; overflow: visible;"><div class="tp-caption   rev_row" id="slide-144-layer-13" data-x="100" data-y="100" data-width="['auto']" data-height="['auto']" data-type="row" data-columnbreak="3" data-responsive_offset="on" data-responsive="off" data-frames="[{&quot;delay&quot;:0,&quot;speed&quot;:300,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;opacity:0;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:300,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;opacity:0;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;}]" data-margintop="[0,0,0,0]" data-marginright="[0,0,0,0]" data-marginbottom="[0,0,0,0]" data-marginleft="[0,0,0,0]" data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 7; white-space: nowrap; font-size: 20px; line-height: 22px; font-weight: 400; color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;; visibility: inherit; transition: none 0s ease 0s; text-align: inherit; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">
        <div class="tp-parallax-wrap rev_column" style="position: relative; visibility: visible; left: 0px; top: 0px; width: 50%; z-index: 8;"><div class="tp-loop-wrap" style="position:relative;;"><div class="tp-mask-wrap" style="position: relative; overflow: visible;"><div class="tp-caption   rev_column_inner" id="slide-144-layer-14" data-x="100" data-y="100" data-width="['auto']" data-height="['auto']" data-type="column" data-responsive_offset="on" data-frames="[{&quot;delay&quot;:0,&quot;speed&quot;:300,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;opacity:0;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:300,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;opacity:0;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;}]" data-columnwidth="50%" data-margintop="[0,0,0,0]" data-marginright="[0,0,0,0]" data-marginbottom="[0,0,0,0]" data-marginleft="[0,0,0,0]" data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 8; width: auto; font-family: &quot;Open Sans&quot;; visibility: inherit; transition: none 0s ease 0s; text-align: inherit; line-height: 16px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 15px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none; background-color: rgba(255, 255, 255, 0); opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">                <div class="rev_column_bg rev_column_bg_man_sized" style="display: none; background-size: auto; opacity: 1; background-position: 0% 0%; background-repeat: repeat; background-image: none; background-color: rgba(0, 0, 0, 0); height: 0px; width: 100%;"></div></div></div></div><div class="rev_column_bg rev_column_bg_auto_sized" style="background-size: auto; opacity: 1; background-position: 0% 0%; background-repeat: repeat; background-image: none; background-color: rgba(0, 0, 0, 0); border-width: 0px; display: block;"></div></div>

        <div class="tp-parallax-wrap rev_column" style="position: relative; visibility: visible; left: 0px; top: 0px; width: 50%; z-index: 9;"><div class="tp-loop-wrap" style="position:relative;;"><div class="tp-mask-wrap" style="position: relative; overflow: visible;"><div class="tp-caption   rev_column_inner" id="slide-144-layer-15" data-x="100" data-y="100" data-width="['auto']" data-height="['auto']" data-type="column" data-responsive_offset="on" data-frames="[{&quot;delay&quot;:0,&quot;speed&quot;:300,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;opacity:0;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:300,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;opacity:0;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;}]" data-columnwidth="50%" data-margintop="[0,0,0,0]" data-marginright="[0,0,0,0]" data-marginbottom="[0,0,0,0]" data-marginleft="[0,0,0,0]" data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 9; width: auto; font-family: &quot;Open Sans&quot;; visibility: inherit; transition: none 0s ease 0s; text-align: inherit; line-height: 16px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 15px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none; background-color: rgba(255, 255, 255, 0); opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">                <div class="rev_column_bg rev_column_bg_man_sized" style="display: none; background-size: auto; opacity: 1; background-position: 0% 0%; background-repeat: repeat; background-image: none; background-color: rgba(0, 0, 0, 0); height: 0px; width: 100%;"></div></div></div></div><div class="rev_column_bg rev_column_bg_auto_sized" style="background-size: auto; opacity: 1; background-position: 0% 0%; background-repeat: repeat; background-image: none; background-color: rgba(0, 0, 0, 0); border-width: 0px; display: block;"></div></div>
            </div></div></div></div>
        </div>

        <div class="tp-parallax-wrap" style="position: absolute; display: block; visibility: visible; left: 734px; top: 147px; z-index: 5;"><div class="tp-loop-wrap" style="position:absolute;display:block;;"><div class="tp-mask-wrap" style="position: absolute; display: block; overflow: visible;"><div class="tp-caption   tp-resizeme" id="slide-144-layer-22" data-x="991" data-y="199" data-width="['none','none','none','none']" data-height="['none','none','none','none']" data-type="image" data-responsive_offset="on" data-frames="[{&quot;delay&quot;:0,&quot;speed&quot;:300,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;opacity:0;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:300,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;opacity:0;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;}]" data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 5; visibility: inherit; transition: none 0s ease 0s; text-align: inherit; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 11px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;"><img src="data:image/webp;base64,UklGRhwCAABXRUJQVlA4TBACAAAvZ8SUEH+goG0byfvu+LM7NDcaCtq2YbLxBzgsN2rbtmGY8v+1mWPFkSQlJ8CP/LMhBIo83PUTAK+ibt9FPqrCgLSa4CMExIalyGyW/L4+rgPUbNuWLQ/ukokPLonukegS6b4AK7g7E9gCdJbgYAISB/X/ge8nX+WK6D8URpIcSVHnPb77pwmiYK+XSz2JxeZP3+JfuyndAseO2itf6lxNPjbbVdFMErLp5grH9WRka22Fx8fuhGQvRcfPgcRk3wV2k5PtdPw970tQ9lV0DsxZ6X5U1vj7VZKVPf8ylqxs9Nd3Q6VHw7L6iLhLWvYQEVPFn5uRX7uqIoYSlzVH9CYuq4v35GUfsZe87CAmS5+alwfGSAKz1uEEZi2DCcya+hOYNZS/FgLmi6HSf+ABs9okZtX6z2vpP/2n//Sf/tN/+k//6T9Rpf/0n/7Tf/pP/+k//af/RJX+03/6T//pP/2n//Sf/hNV+k//6T/9p//0n/7Tf/pPVOk//af/9J/+03/6T//pP1Gl//Sf/tN/+k//6T/9p/9Elf7Tf/pP/+k//af/9J/+E1X6T//xSv8x0zArZlqJxUyTtZhpPxczjflipmVhyDRzjJk2lzHTADRmWqPGTNPYmGmnGzKNhmOmBXPMNKcOmbbdMdPQPGZavYdME/yYaQ8gMo0TRKalhMw02xCZNiQi06BFdlrXiExTHwM=" alt="" data-ww="571px" data-hh="302px" data-no-retina="" data-pagespeed-url-hash="2788903595" onload="pagespeed.CriticalImages.checkImageForCriticality(this);" style="width: 422.938px; height: 223.691px; transition: none 0s ease 0s; text-align: inherit; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 8px;"> </div></div></div></div>

        <div class="tp-parallax-wrap" style="position: absolute; display: block; visibility: visible; left: 760px; top: 289px; z-index: 6;"><div class="tp-loop-wrap" style="position:absolute;display:block;;"><div class="tp-mask-wrap" style="position: absolute; display: block; overflow: hidden; transform: matrix(1, 0, 0, 1, 0, 0);"><div class="tp-caption   tp-resizeme" id="slide-144-layer-12" data-x="1027" data-y="391" data-width="['572']" data-height="['75']" data-type="text" data-responsive_offset="on" data-frames="[{&quot;delay&quot;:1440,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;x:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;&quot;,&quot;mask&quot;:&quot;x:0px;y:0px;s:inherit;e:inherit;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:2000,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;opacity:0;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;}]" data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 6; min-width: 400px; max-width: 424px; white-space: normal; font-size: 26px; line-height: 30px; font-weight: 400; color: rgb(35, 53, 83); font-family: Dosis; visibility: inherit; transition: none 0s ease 0s; text-align: inherit; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; min-height: 56px; max-height: 56px; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">Connect with models and professionals from all over the world </div></div></div></div>

        <div class="tp-parallax-wrap" style="position: absolute; display: block; visibility: visible; left: 760px; top: 160px; z-index: 10;"><div class="tp-loop-wrap" style="position:absolute;display:block;;"><div class="tp-mask-wrap" style="position: absolute; display: block; overflow: hidden; transform: matrix(1, 0, 0, 1, 0, 0);"><div class="tp-caption   tp-resizeme" id="slide-144-layer-17" data-x="1027" data-y="217" data-width="['none','none','none','none']" data-height="['none','none','none','none']" data-type="image" data-responsive_offset="on" data-frames="[{&quot;delay&quot;:0,&quot;speed&quot;:2000,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;x:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;&quot;,&quot;mask&quot;:&quot;x:0px;y:0px;s:inherit;e:inherit;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:1000,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;opacity:0;&quot;,&quot;ease&quot;:&quot;Power2.easeIn&quot;}]" data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 10; visibility: inherit; transition: none 0s ease 0s; text-align: inherit; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 11px; white-space: nowrap; min-height: 0px; min-width: 0px; max-height: none; max-width: none; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;"><img src="http://go-model.local/images/partner-benefits/partner-benefits-4.jpg" alt="" data-ww="132px" data-hh="128px" width="512" height="512" data-no-retina="" data-pagespeed-url-hash="3628971602" onload="pagespeed.CriticalImages.checkImageForCriticality(this);" style="width: 97.7721px; height: 94.8093px; transition: none 0s ease 0s; text-align: inherit; line-height: 0px; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; font-weight: 400; font-size: 8px;"> </div></div></div></div>

        <div class="tp-parallax-wrap" style="position: absolute; display: block; visibility: visible; left: 881px; top: 166px; z-index: 11;"><div class="tp-loop-wrap" style="position:absolute;display:block;;"><div class="tp-mask-wrap" style="position: absolute; display: block; overflow: hidden; transform: matrix(1, 0, 0, 1, 0, 0);"><div class="tp-caption   tp-resizeme" id="slide-144-layer-20" data-x="1190" data-y="225" data-width="['478']" data-height="['165']" data-type="text" data-responsive_offset="on" data-frames="[{&quot;delay&quot;:1440,&quot;speed&quot;:1500,&quot;frame&quot;:&quot;0&quot;,&quot;from&quot;:&quot;x:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;&quot;,&quot;mask&quot;:&quot;x:0px;y:0px;s:inherit;e:inherit;&quot;,&quot;to&quot;:&quot;o:1;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;},{&quot;delay&quot;:&quot;wait&quot;,&quot;speed&quot;:2000,&quot;frame&quot;:&quot;999&quot;,&quot;to&quot;:&quot;opacity:0;&quot;,&quot;ease&quot;:&quot;Power3.easeInOut&quot;}]" data-textalign="['inherit','inherit','inherit','inherit']" data-paddingtop="[0,0,0,0]" data-paddingright="[0,0,0,0]" data-paddingbottom="[0,0,0,0]" data-paddingleft="[0,0,0,0]" style="z-index: 11; min-width: 354px; max-width: 354px; white-space: nowrap; font-size: 74px; line-height: 89px; font-weight: 800; color: rgb(198, 164, 109); font-family: Dosis; visibility: inherit; transition: none 0s ease 0s; text-align: inherit; border-width: 0px; margin: 0px; padding: 0px; letter-spacing: 0px; min-height: 122px; max-height: 122px; opacity: 1; transform: matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1); transform-origin: 50% 50% 0px;">Partner </div></div></div></div>
    
</div> -->



    <!-- <div class="block no-pd-b">
        <h2>WELCOME TO GO-MODELS.COM</h2>

        <div class="image-and-text-rows">
            <div class="row">
                <div>
                    <span class="num">1</span>
                    <h3>LEARN MORE ABOUT YOUR UNIQUE BENEFITS AS A PARTNER!</h3>
                    <ul>
                        <li>You can register quickly, without obligation and is 100% free of charge.
Through your free access to our online model platform, the world of models and industry professionals is open to you!</li>
                        <li>You can find suitable models for your projects with our model search.But also you can get orders and jobs from advertising agencies and other industry professionals - both locally and internationally!</li>
                        <li>Paving the way from model agencies to a special and up-to-date online model portal! - That's go-models!</li>
                    </ul>
                    We stand for:
                    <br/>
                    <br/>
                    <ul>
                        <li>Seriousness, transparency & security</li>

                        <li>Internationality</li>

                        <li>Personality</li>

                        <li>Passionate Support</li>
                    </ul>
                </div>

                <div>
                    <img src="http://go-model.local/images/ezgif.com-webp-to-jpg (2).jpg" alt="" >
                </div>
            </div>
            <h2>GO-SUCCESS - WORLDWIDE SUCCESS</h2>
            <div class="row">
                <div>
                    <img src="http://go-model.local/images/xpartner-model-agentur1.jpg" alt="" >
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><blockquote class="">
        <span> go-models - become known worldwide </span>
        <span class="author-name"> <a href="#">-- </a></span>
        </blockquote></div>
                </div>

                <div>
                    <span class="num">2</span>
                    <h3>LOCAL & INTERNATIONAL</h3>
                    <ul>
                        <li>With go-models, we offer you an international platform where models, photographers, advertising agencies and other industry professionals can meet.</li>
                        <li>We are looking for you! No matter what industry you are, with you, we create a network of professionals and provide an online portal that offers a variety of advantages.</li>
                        <li>Make international contacts and make your company known beyond the national borders!</li>
                        <li>Through go-models you can strengthen your online presence. Link your online profile to your website and increase your personal Google ranking. So you can now appear at the top of Google Search Requests and get customers.</li>
                        
                    </ul>
                    <br/>
                    We offer: 
                    <br/>
                    <br/>
                    <ul>
                        <li>Become known worldwide, make international contacts and strengthen your own online presence</li>
                        <li>Models of different categories</li>
                        <li>Find & be found</li>
                        <li>Online Profile & online job management</li>
                        <li>100% free & non-binding</li>
                        <li>A wide range of possibilities, features and functions awaits!</li>
                    </ul>
                </div>
            </div>
            <h2>WHY GO-MODELS?</h2>
            <h3 style="
    text-align: center;
">Your benefits</h3>
            <div class="row">
                <div>
                    <span class="num">3</span>
                    <h3>GO-EASY -FAST AND EASY</h3>
                    <ul>
                        <li>On go-models, you don’t only find people for jobs, but you can also get your own jobs! Get to know new people from different sectors and work with the best.</li>
                        <li>You get unrestricted access to your job management.</li>
                        <li>This way, you can easily search, contact, and book online models and industry professionals in your area. Create jobs and receive an alert when a model has applied.</li>
                        <li>So you always have an overview!</li>
                    </ul>
                </div>

                <div>
                    <img src="http://go-model.local/images/ezgif.com-webp-to-jpg (1) (2).jpg" alt="">
                    
                </div>
            </div>
        </div>
    </div> -->

    <!--- GERMAN -->
    <!-- <div class="block no-pd-b">
        <h2>WILLKOMMEN BEI GO-MODELS.COM</h2>

        <div class="image-and-text-rows">
            <div class="row">
                <div>
                    <span class="num">1</span>
                    <h3>ERFAHREN SIE MEHR ÜBER IHRE EINZIGARTIGEN VORTEILE ALS PARTNER!</h3>
                    <ul>
                        <li>Sie können sich schnell und unverbindlich anmelden und sind zu 100% kostenlos.
Durch Ihren kostenlosen Zugang zu unserer Online-Modellplattform steht Ihnen die Welt der Modelle und Branchenexperten offen!</li>
                        <li>Mit unserer Modellsuche finden Sie passende Modelle für Ihre Projekte. Sie können aber auch Aufträge und Jobs von Werbeagenturen und anderen Branchenexperten erhalten - lokal und international!</li>
                        <li>Weg von Modellagenturen zu einem speziellen und aktuellen Online-Modellportal! - Das sind Go-Models!</li>
                    </ul>
                    Wir stehen für:
                    <br/>
                    <br/>
                    <ul>
                        <li>Seriosität, Transparenz und Sicherheit</li>

                        <li>Internationalität</li>

                        <li>Persönlichkeit</li>

                        <li>Leidenschaftliche Unterstützung</li>
                    </ul>
                </div>

                <div>
                    <img src="http://go-model.local/images/ezgif.com-webp-to-jpg (2).jpg" alt="" >
                </div>
            </div>
            <h2>GO-SUCCESS - WELTWEITER ERFOLG</h2>
            <div class="row">
                <div>
                    <img src="http://go-model.local/images/xpartner-model-agentur1.jpg" alt="" >
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><blockquote class="">
        <span> go-models - weltweit bekannt werden </span>
        <span class="author-name"> <a href="#">-- </a></span>
        </blockquote></div>
                </div>

                <div>
                    <span class="num">2</span>
                    <h3>LOKAL & INTERNATIONAL</h3>
                    <ul>
                        <li>Mit go-models bieten wir Ihnen eine internationale Plattform, auf der sich Modelle, Fotografen, Werbeagenturen und andere Branchenexperten treffen können.</li>
                        <li>Wir suchen Dich! Egal in welcher Branche Sie sich befinden, wir schaffen mit Ihnen ein Netzwerk von Fachleuten und bieten ein Online-Portal mit vielfältigen Vorteilen.</li>
                        <li>Knüpfen Sie internationale Kontakte und machen Sie Ihr Unternehmen über die Landesgrenzen hinaus bekannt!</li>
                        <li>Durch Go-Models können Sie Ihre Online-Präsenz stärken. Verknüpfen Sie Ihr Online-Profil mit Ihrer Website und erhöhen Sie Ihr persönliches Google-Ranking. Sie können jetzt oben in den Google-Suchanfragen erscheinen und Kunden gewinnen.</li>
                        
                    </ul>
                    <br/>
                    Wir bieten:
                    <br/>
                    <br/>
                    <ul>
                        <li>Werden Sie weltweit bekannt, knüpfen Sie internationale Kontakte und stärken Sie Ihre eigene Online-Präsenz</li>
                        <li>Modelle verschiedener Kategorien</li>
                        <li>Finden & gefunden werden</li>
                        <li>Online-Profil & Online-Jobverwaltung</li>
                        <li>100% kostenlos und unverbindlich</li>
                        <li>Es erwartet Sie eine Vielzahl von Möglichkeiten, Funktionen und Funktionen!</li>
                    </ul>
                </div>
            </div>
            <h2>WARUM GO-MODELS?</h2>
            <h3 style="
    text-align: center;
">Ihre Vorteile</h3>
            <div class="row">
                <div>
                    <span class="num">3</span>
                    <h3>GO-EASY - SCHNELL UND EINFACH</h3>
                    <ul>
                        <li>Bei go-Models finden Sie nicht nur Personen für Jobs, sondern können auch Ihre eigenen Jobs bekommen! Lernen Sie neue Leute aus verschiedenen Bereichen kennen und arbeiten Sie mit den Besten zusammen.</li>
                        <li>Sie erhalten uneingeschränkten Zugriff auf Ihre Jobverwaltung.</li>
                        <li>Auf diese Weise können Sie Online-Modelle und Branchenexperten in Ihrer Nähe einfach suchen, kontaktieren und buchen. Erstellen Sie Jobs und erhalten Sie eine Benachrichtigung, wenn ein Modell angewendet wurde.</li>
                        <li>So haben Sie immer den Überblick!</li>
                    </ul>
                </div>

                <div>
                    <img src="http://go-model.local/images/ezgif.com-webp-to-jpg (1) (2).jpg" alt="">
                    
                </div>
            </div>
        </div>
    </div> -->
    {!! $page->content !!}
@endsection