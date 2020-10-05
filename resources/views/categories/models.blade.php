@extends('layouts.app')

@section('content')
    <div class="cover">
        <img src="{{ URL::to('images/covers/category_models.jpg') }}" alt="Die Welt der Models, Fotografen, Agenturen und Branchen Profis!" />
        <div class="inner">
            <div class="text">
                <div class="holder">
                    <h1>Go-to-Job</h1>
                    <h3>Die Welt der Models, Fotografen, Agenturen und Branchen Profis!</h3>

                    <p>Tolle Aufträge, Abwechslung und neue Leute: Die Welt der Models bietet endlose Möglichkeiten!
                    Auch Du bist zwischen 15 und 50 Jahre und möchtest Model werden?
                    Dann bist Du bei go-models genau richtig! Bei uns kommen Models und Auftraggeber zusammen!</p>

                    <a href="#" class="watch">Intro ansehen</a>
                </div>
            </div>
        </div>
    </div>

    <div class="block no-pd-b">
        <div class="cols-2 no-mg-b">
            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/models/promo1.jpg') }}" alt="Direkt Models buchen" />
                    <div class="data">
                        <h2>Direkt Models buchen</h2>
                        <ul>
                            <li>Registriere Dich jetzt als Auftraggeber</li>
                            <li>Finde jetzt passende Models für Deine Model Jobs</li>
                            <li>Kontaktiere und buche direkt Models online</li>
                        </ul>
                        <div class="btn">
                            <a href="{{ route('book_a_model') }}" class="next">Jetzt Models finden</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/models/promo2.jpg') }}" alt="Jetzt Model werden" />
                    <div class="data">
                        <h2>Jetzt Model werden</h2>
                        <ul>
                            <li>Bewirb Dich jetzt als Model</li>
                            <li>Werde direkt von Auftraggebern in Deiner Nähe - oder international - kontaktiert</li>
                            <li>Bewirb Dich auf spannende Jobs  - vom Fotoshooting bis hin zur Werbekampagne</li>
                        </ul>
                        <div class="btn">
                            <a href="#" class="next mfp-register-form">Jetzt Model werden</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <h2>3 Gründe, um ein Go-Model zu werden:</h2>

        <div class="cols-3 nested">
            <div class="col">
                <div class="reason">
                    <span>1</span>
                    <h4>Jobs - lokal &amp; international </h4>
                    <p>Du entscheidest, wo Du Jobs annehmen möchtest!</p>
                </div>
            </div>

            <div class="col">
                <div class="reason">
                    <span>2</span>
                    <h4>Datenschutz ist uns wichtig!</h4>
                    <p>Daher sind alle Auftraggeber bei uns geprüft!</p>
                </div>
            </div>

            <div class="col">
                <div class="reason">
                    <span>3</span>
                    <h4>Keine Idealmaße</h4>
                    <p>Bei uns brauchst Du keine Idealmaße, um Model zu werden!</p>
                </div>
            </div>
        </div>

        <div class="btn">
            <a href="{{ route('premium_membership') }}">Erfahre mehr</a>
        </div>
    </div>

    <div class="block colored pd-10">
        <div class="testimonials owl-carousel">
            @for($i=1;$i<=3;$i++)
                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/models/img1.jpg') }}" alt="Marina" />
                        </div>
                        <div class="name">Marina</div>
                        <div class="company">24 Monate</div>

                        <div class="quote-holder">
                            <blockquote>Nebenbei Geld verdienen</blockquote>
                        </div>

                        <p>“Mit go-models kann ich mir neben meinem Studium bei Jobs etwas Geld dazuverdienen.
                        Auch finde ich es super, dass ich nicht wie bei Modelagenturen Vermittlungsprovision zahlen muss!”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/models/img2.jpg') }}" alt="Kathrin" />
                        </div>
                        <div class="name">Kathrin</div>
                        <div class="company">30 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Von zu Hause aus</blockquote>
                        </div>

                        <p>“Ich kann mein Profil von überall aus bearbeiten, das finde ich super und auch ziemlich einfach”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/models/img3.jpg') }}" alt="Andreas" />
                        </div>
                        <div class="name">Andreas</div>
                        <div class="company">40 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Traum verwirklich</blockquote>
                        </div>

                        <p>“Bekannte haben immer gemeint, ich sollte doch Model werden. Nun habe ich es gewagt und meinen Traum verwirklicht. Das Posen macht mir sehr viel Spaß!”</p>
                    </div>
                </div>
            @endfor
        </div>

        <div class="btn">
            <a href="#" class="mfp-register-form">Register and get featured</a>
        </div>
    </div>

    <div class="block">
        <h2>Go-Model - Gehe Deinen Weg zum Model!</h2>

        <div class="cols-2 nested">
            <div class="col">
                <div class="howto">
                    <ul>
                        <li><span>Registriere Dich</span> jetzt ganz einfach und schnell online als M odel. Die Bewerbung wird von uns ausgewertet und Du bekommst innerhalb 48 Stunden Bescheid.</li>
                        <li><span>Keine teure Sedcard</span><br />Wir sind viel mehr als eine klassische Modelagentur, denn auf unserem Model Portal brauchst Du keine teure Sedcard um Model zu werden. Deine Sedcard ist bei uns im Model Profil schon dabei!</li>
                    </ul>
                </div>
            </div>

            <div class="col">
                <div class="howto">
                    <ul>
                        <li><span>Model Jobs finden</span><br />Bei uns kannst Du jederzeit nach aufregenden Jobs - ob in Deiner Umgebung oder international - suchen und Dich direkt auf passende Model Jobs bewerben.</li>
                        <li><span>Datenschutz</span><br />Deine Daten sind bei uns in der Datenbank sicher!</li>
                        <li><span>Online Profil</span><br />Dein Model Profil und Deine Sedcard kannst Du ganz einfach und schnell online erstellen und regelmäßig aktualisieren.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="btn">
            <a href="#" class="next mfp-register-form">Jetzt als Model bewerben</a>
        </div>
    </div>

    @include('childs.categories',['title' => 'Jetzt go-Model werden!', 'class' => 'colored-light'])
    @include('childs.jobs')
    <?php /*
    @include('childs.featured')
    */?>
    @include('childs.prices')
@endsection