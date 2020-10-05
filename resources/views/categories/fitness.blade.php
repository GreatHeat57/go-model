@extends('layouts.app')

@section('content')
    <div class="cover">
        <img src="{{ URL::to('images/covers/category_fitness.jpg') }}" alt="Lass Deine Muskeln spielen!" />
        <div class="inner">
            <div class="text">
                <div class="holder">
                    <h1>Go-to-Job</h1>
                    <h3>Lass Deine Muskeln spielen!</h3>

                    <p>Internationale Sportmarken, Action, definierte Körper: Ob Hobbysportler oder Profi: In Sportwerbungen wird Dein Körper zum Blickfang!
                    Auch Du möchtest gerne eine Fitness Model werden?
                    Dann bist Du bei go-models genau richtig! Bei uns kommen Fitnessbegeisterte und Auftraggeber zusammen!!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="block no-pd-b">
        <div class="cols-2 no-mg-b">
            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/fitness/promo1.jpg') }}" alt="Direkt Fitness Models buchen" />
                    <div class="data">
                        <h2>Direkt Fitness Models buchen</h2>
                        <ul>
                            <li>Registriere Dich jetzt als Auftraggeber</li>
                            <li>Stelle jederzeit Jobs ein</li>
                            <li>Fitness Models direkt finden und buchen</li>
                        </ul>
                        <div class="btn">
                            <a href="{{ route('book_a_model') }}" class="next">Jetzt Fitness Models buchen</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/fitness/promo2.jpg') }}" alt="Jetzt Fitness Model werden" />
                    <div class="data">
                        <h2>Jetzt Fitness Model werden</h2>
                        <ul>
                            <li>Bewirb Dich jetzt als Fitness Model</li>
                            <li>Werde direkt von Auftraggebern kontaktiert</li>
                            <li>Sportliche Aufträge der verschiedensten Branchen</li>
                        </ul>
                        <div class="btn">
                            <a href="#" class="next mfp-register-form">Jetzt Fitness Model werden</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <h2>3 Gründe, um ein Go-Fitness Model zu werden:</h2>

        <div class="cols-3 nested">
            <div class="col">
                <div class="reason">
                    <span>1</span>
                    <h4>Jobs - Wo Du willst</h4>
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
                    <h4>Eigenes Model Profil</h4>
                    <p>Starte Deine Fitness Model Karriere mit Deinem eigenen Model Profil!</p>
                </div>
            </div>
        </div>

        <div class="btn">
            <a href="{{ route('premium_membership') }}">Erfahre mehr bei unserer go-Tour</a>
        </div>
    </div>

    <div class="block colored pd-10">
        <div class="testimonials owl-carousel">
            @for($i=1;$i<=3;$i++)
                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/fitness/img1.jpg') }}" alt="Alex" />
                        </div>
                        <div class="name">Alex</div>
                        <div class="company">26 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Meine Bühne</blockquote>
                        </div>

                        <p>“Ich trainiere hart für meinen Körper und zeige daher auch gerne meine Muskeln! Ich habe lange überlegt, Fitnessmodel zu werden!  Das Modeln ist für mich daher die perfekte Bühne!”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/fitness/img2.jpg') }}" alt="Mirjam" />
                        </div>
                        <div class="name">Mirjam</div>
                        <div class="company">22 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Ehrgeizig sein Ziel verfolgen</blockquote>
                        </div>

                        <p>“Als Fitness Model sollte man schon diszipliniert sein und sein Ziel verfolgen. Als Fitness Model kann ich Leidenschaft und Beruf verbinden!”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/fitness/img3.jpg') }}" alt="David" />
                        </div>
                        <div class="name">David</div>
                        <div class="company">30 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Neue Herausforderungen</blockquote>
                        </div>

                        <p>“Ich bin immer auf der Suche nach etwas Abwechslung, da mir schnell langweilig wird.
                        Bis jetzt habe ich noch keine passende Modelagentur gefunden, so bin ich auf go-models gestoßen!
                        Da es immer unterschiedliche Model Jobs sind, finde ich es ziemlich spannend!”</p>
                    </div>
                </div>
            @endfor
        </div>

        <div class="btn">
            <a href="#" class="mfp-register-form">Register and get featured!</a>
        </div>
    </div>

    <div class="block">
        <h2>Go-Model - Gehe Deinen Weg zum Fitness Model!</h2>

        <div class="cols-2 nested">
            <div class="col">
                <div class="howto">
                    <ul>
                        <li><span>Registriere Dich</span> jetzt ganz einfach und schnell online als Fitness Model. Die Bewerbung wird von uns ausgewertet und Du bekommst innerhalb 48 Stunden Bescheid.</li>
                        <li><span>Keine teure Sedcard</span><br />Wir sind viel mehr als eine klassische Fitness Modelagentur, denn auf unserem Model Portal brauchst Du keine teure Sedcard um Fitness Model zu werden. Deine Sedcard ist bei uns im Model Profil schon dabei!</li>
                    </ul>
                </div>
            </div>

            <div class="col">
                <div class="howto">
                    <ul>
                        <li><span>Model Jobs finden</span><br />Bei uns kannst Du jederzeit nach aufregenden Jobs - ob in Deiner Umgebung oder international - suchen und Dich direkt auf passende Fitness Model Jobs bewerben.</li>
                        <li><span>Datenschutz</span><br />Deine Daten sind bei uns in der Datenbank sicher!</li>
                        <li><span>Online Profil</span><br />Dein Model Profil und Deine Sedcard kannst Du ganz einfach und schnell online erstellen und regelmäßig aktualisieren.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="btn">
            <a href="#" class="next mfp-register-form">Jetzt Fitness Model werden</a>
        </div>
    </div>

    @include('childs.categories',['title' => 'Jetzt go-Fitness Model werden!', 'class' => 'colored-light'])
    @include('childs.jobs')
    <?php /*
    @include('childs.featured')
    @include('childs.prices')
    */?>
@endsection