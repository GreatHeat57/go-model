@extends('layouts.app')

@section('content')
    <div class="subcover colored-very-light-blue">
        <h1>{{ trans('frontPage.pricing_page_title') }}</h1>
    </div>
    <?php /*
    <!-- <div class="block">
        <div class="cols-2 no-mg-b">
            <div class="col full">
                <div class="price-box">
                    <h3>Free</h3>

                    <p>Sieh dir an, wie go-models funktioniert und erstelle Dein eigenes Model Profil.</p>

                    <ul>
                        <li><span>Bewirb Dich jetzt als Model in Deiner Model Kategorie</span></li>
                        <li><span>Erstelle Dein Model Profil und lade Deine schönsten Fotos hoch</span></li>
                        <li><span>Erstelle Deine Model Sedcard</span></li>
                    </ul>

                    <div class="price">
                        <span>0 &euro;</span> / Jahr
                    </div>

                    <div class="btn">
                        <a href="#" class="mfp-register">Jetzt bewerben</a>
                    </div>
                </div>
            </div>

            <div class="col full">
                <div class="price-box">
                    <h3>Premium</h3>

                    <p>Nutze alle Funktionen von go-models. Starte jetzt Deine Model Karriere - Du bist nur mehr einen Schritt davon entfernt!</p>

                    <ul>
                        <li><span>Bewirb Dich als Model in Deiner Kategorie</span></li>
                        <li><span>Erstelle Dein Model Profil inkl. Model Sedcard</span></li>
                        <li><span>Bewirb Dich auf Jobs in Deiner Jobliste</span></li>
                        <li><span>trete in direkten Kontakt mit Auftraggebern</span></li>
                        <li><span>werde von uns auf der Webseite oder Social Media gefeatured und als Model vorgestellt</span></li>
                    </ul>

                    <div class="price">
                        <span>132 &euro;</span> / Jahr
                    </div>

                    <div class="btn">
                        <a href="#" class="green mfp-register">Jetzt als Model durchstarten</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    */ ?>
    @include('childs.have_a_job')

    <div class="block colored-light-blue2">
        <h2>{{ t('lbl_go_premiium') }}</h2>
        <div class="cols-3 no-mg-b text-center">
            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.go_premium_feature1_title') }}</h3>
                    <p>{{ trans('frontPage.go_premium_feature1_description') }} </p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.go_premium_feature2_title') }}</h3>
                    <p>{!! trans('frontPage.go_premium_feature2_description') !!}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.go_premium_feature3_title') }}</h3>
                    <p>{{ trans('frontPage.go_premium_feature3_description') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.go_premium_feature4_title') }}</h3>
                    <p>{{ trans('frontPage.go_premium_feature4_description') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.go_premium_feature5_title') }}</h3>
                    <p>{!! trans('frontPage.go_premium_feature5_description') !!}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.go_premium_feature6_title') }}</h3>
                    <p>{{ trans('frontPage.go_premium_feature6_description') }}</p>
                </div>
            </div>
        </div>

        <div class="btn">
            @if (auth()->check())
                <a href="javascript:void(0);" class="green disabled_opacity disabled">{{ trans('frontPage.go_premium_btn_lbl') }}</a>
            @else
                <a href="#" class="mfp-register-form green">{{ trans('frontPage.go_premium_btn_lbl') }}</a>
            @endif
        </div>
    </div>

    <div class="block no-pd-b bd-b-light">
        <h2>{{ trans('frontPage.advantage_title') }}</h2>
        <div class="cols-3">
            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.advantage1_title') }}</h3>
                    <p>{{ trans('frontPage.advantage1_desc') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.advantage2_title') }}</h3>
                    <p>{{ trans('frontPage.advantage2_desc') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.advantage3_title') }}</h3>
                    <p>{{ trans('frontPage.advantage3_desc') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.advantage4_title') }}</h3>
                    <p>{{ trans('frontPage.advantage4_desc') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.advantage5_title') }}</h3>
                    <p>{{ trans('frontPage.advantage5_desc') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.advantage6_title') }}</h3>
                    <p>{{ trans('frontPage.advantage6_desc') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.advantage7_title') }}</h3>
                    <p>{{ trans('frontPage.advantage7_desc') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.advantage8_title') }}</h3>
                    <p>{{ trans('frontPage.advantage8_desc') }}</p>
                </div>
            </div>

            <div class="col">
                <div class="faq-item">
                    <h3>{{ trans('frontPage.advantage9_title') }}</h3>
                    <p>{{ trans('frontPage.advantage9_desc') }}</p>
                </div>
            </div>
        </div>
    </div>

    <?php /* <!-- @include('childs.references') --> */ ?>

    <div class="block colored-light-blue2">
        <div class="testimonials owl-carousel no-mg-b">
            <div class="item">
                <div class="holder">
                    <div class="image">
                        <img data-src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/img1.jpg') }}" alt="Drezzer" class="lazyload"/>
                    </div>
                    <div class="name">Drezzer</div>
                    <div class="company">— go-models —</div>

                    <div class="quote-holder">
                        <blockquote>Fotoshooting für das Fashion Portal Drezzer</blockquote>
                    </div>

                    <p>“Drezzer ist immer wieder auf der Suche nach neuen Models für kommende Modekollektionen. Bei unserem letzten Shooting wurden einige unserer Models gebucht, die die Mode der Designer präsentieren durften. Ein toller Shooting Day mit wunderbaren Bildern ist entstanden! :)”</p>
                </div>
            </div>

            <div class="item">
                <div class="holder">
                    <div class="image">
                        <img data-src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/img2.jpg') }}" alt="Model Isabell" class="lazyload"/>
                    </div>
                    <div class="name">Model Isabell</div>
                    <div class="company">— Nachwuchsmodel aus Berlin —</div>

                    <div class="quote-holder">
                        <blockquote>Mein erster internationaler Job</blockquote>
                    </div>

                    <p>“Bei meinem letzten Model Job wurde ich aus Wien angefragt und eingeflogen. Ein wahnsinnig tolles Erlebnis mit ”Superstar Feeling”. Danke, für das spannende Model Shooting und die unvergessliche Zeit in Wien”</p>
                </div>
            </div>

            <div class="item">
                <div class="holder">
                    <div class="image">
                        <img data-src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/img3.jpg') }}" alt="Männermodel Stefan" class="lazyload"/>
                    </div>
                    <div class="name">Männermodel Stefan</div>
                    <div class="company">— go-models —</div>

                    <div class="quote-holder">
                        <blockquote>Fashion Shooting als Männermodel</blockquote>
                    </div>

                    <p>“Als tätowiertes Männer bzw. Fitnessmodel bin ich sicher nicht das klassische Model einer Modelagentur. Aber bei go-models konnte ich bei meinem letzten Auftrag den Auftraggeber überzeugen - dabei sind lässige und lockere Bilder entstanden bei meinem Model Job” </p>
                </div>
            </div>
        </div>
    </div>
@endsection