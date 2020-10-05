@extends('layouts.app')

@section('content')
    <div class="cover">
        <img src="{{ URL::to('images/covers/category_plussize.jpg') }}" alt="Zeige, was in Dir steckt!" />
        <div class="inner">
            <div class="text">
                <div class="holder">
                    <h1>Go-to-Job</h1>
                    <h3>Zeige, was in Dir steckt!</h3>

                    <p>Sports Illustrated, Vogue, Elle: Plus Size Models zieren die Covers der angesehensten Magazine und sind gefragter denn je!
                    Auch Du möchtest ein Plus Size Model werden?
                    Dann bist Du bei go-models genau richtig! Wir suchen Persönlichkeit anstatt Idealmaße!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="block no-pd-b">
        <div class="cols-2 no-mg-b">
            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/plussize/promo1.jpg') }}" alt="Direkt Plus Size Models buchen" />
                    <div class="data">
                        <h2>Direkt Plus Size Models buchen</h2>
                        <ul>
                            <li>Registriere Dich jetzt als Auftraggeber</li>
                            <li>Finde passende Plus Size Models online</li>
                            <li>trete in direkten Kontakt mit den Models</li>
                        </ul>
                        <div class="btn">
                            <a href="{{ route('book_a_model') }}" class="next">Jetzt Models finden</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/plussize/promo2.jpg') }}" alt="Jetzt Plus Size Model werden" />
                    <div class="data">
                        <h2>Jetzt Plus Size Model werden</h2>
                        <ul>
                            <li>Bewirb Dich jetzt als Plus Size Model</li>
                            <li>Direkt von Auftraggebern kontaktiert werden</li>
                            <li>trete in Kontakt mit Auftraggebern aus den unterschiedlichsten Branchen</li>
                        </ul>
                        <div class="btn">
                            <a href="#" class="next mfp-register-form">Jetzt Plus Size Model werden</a>
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
                    <p>Starte Deine Model Karriere mit Deinem eigenen Model Profil!</p>
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
                            <img src="{{ URL::to('images/testimonials/plussize/img1.jpg') }}" alt="Johanna" />
                        </div>
                        <div class="name">Johanna</div>
                        <div class="company">25 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Fühl Dich wohl in Deinem Körper</blockquote>
                        </div>

                        <p>“Ich möchte vor allem junge Frauen dazu inspirieren, sich in ihrem Körper wohlzufühlen. Ohne dem Druck, ein gewisses Schönheitsideal erfüllen zu müssen!”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to('images/testimonials/plussize/img2.jpg') }}" alt="Nicole" />
                        </div>
                        <div class="name">Nicole</div>
                        <div class="company">22 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Geld verdienen mit meinem Hobby</blockquote>
                        </div>

                        <p>“Als Plus Size Model verdiene ich mir immer mal wieder nebenbei etwas Geld dazu. Ich finde es toll, mich so zeigen zu können wie ich bin!”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to('images/testimonials/plussize/img3.jpg') }}" alt="Delisha" />
                        </div>
                        <div class="name">Delisha</div>
                        <div class="company">35 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Gute Laune</blockquote>
                        </div>

                        <p>“Meine Freunde sagen meine gute Laune ist ansteckend. Also habe ich mir gedacht: Dann probiere ich es doch einmal als Plus Size Model!”</p>
                    </div>
                </div>
            @endfor
        </div>

        <div class="btn">
            <a href="#" class="mfp-register-form">Register and get featured!</a>
        </div>
    </div>

    <div class="block">
        <h2>Go-Model - Gehe Deinen Weg zum Plus Size Model!</h2>

        <div class="cols-2 nested">
            <div class="col">
                <div class="howto">
                    <ul>
                        <li><span>Registriere Dich</span> jetzt ganz einfach und schnell online als Plus Size Model. Die Bewerbung wird von uns ausgewertet und Du bekommst innerhalb 48 Stunden Bescheid.</li>
                        <li><span>Keine teure Sedcard</span><br />Wir sind viel mehr als eine klassische Plus Size Modelagentur, denn auf unserem Model Portal brauchst Du keine teure Sedcard um Plus Size Model zu werden. Deine Sedcard ist bei uns im Model Profil schon dabei!</li>
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
            <a href="#" class="next mfp-register-form">Jetzt Plus Size Model werden</a>
        </div>
    </div>

    @include('childs.categories',['title' => 'Jetzt go-Plus Size Model werden!', 'class' => 'colored-light'])
    @include('childs.jobs')
    <?php /*
    @include('childs.featured')
    */?>
    @include('childs.prices')
@endsection