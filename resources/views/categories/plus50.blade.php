@extends('layouts.app')

@section('content')
    <div class="cover">
        <img src="{{ URL::to('images/covers/category_plus50.jpg') }}" alt="Verwirkliche Dich selbst!" />
        <div class="inner">
            <div class="text">
                <div class="holder">
                    <h1>Go-to-Job</h1>
                    <h3>Verwirkliche Dich selbst!</h3>

                    <p>Ob in Magazinen, Katalogen, Plakaten oder Werbespots: 50plus Models sind überall zu finden!
                    Auch Du möchtest neu durchstarten und 50plus Model werden?
                    Dann bist Du bei go-models genau richtig!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="block no-pd-b">
        <div class="cols-2 no-mg-b">
            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/plus50/promo1.jpg') }}" alt="Direkt 50plus Models buchen" />
                    <div class="data">
                        <h2>Direkt 50plus Models buchen</h2>
                        <ul>
                            <li>Registriere Dich jetzt als Auftraggeber</li>
                            <li>Finde passende 50plus Models online</li>
                            <li>trete in direkten Kontakt mit 50plus Models</li>
                        </ul>
                        <div class="btn">
                            <a href="{{ route('book_a_model') }}" class="next">Jetzt 50plus Models finden</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/plus50/promo2.jpg') }}" alt="Jetzt 50plus Model werden" />
                    <div class="data">
                        <h2>Jetzt 50plus Model werden</h2>
                        <ul>
                            <li>Bewirb Dich jetzt als 50plus Model</li>
                            <li>Direkt von Auftraggebern kontaktiert werden</li>
                            <li>verschiedene Auftraggeber der unterschiedlichsten Branchen</li>
                        </ul>
                        <div class="btn">
                            <a href="#" class="next mfp-register-form">Jetzt 50plus Model werden</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <h2>3 Gründe, um ein Go-50plus Model zu werden:</h2>

        <div class="cols-3 nested">
            <div class="col">
                <div class="reason">
                    <span>1</span>
                    <h4>Jobs in Deiner Nähe</h4>
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
                    <h4>Eintauchen in die Model Welt</h4>
                    <p>Verwirkliche jetzt Deinen Traum als 50plus Model!</p>
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
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/plus50/img1.jpg') }}" alt="Angelika" />
                        </div>
                        <div class="name">Angelika</div>
                        <div class="company">60 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Abwechslung im Alltag</blockquote>
                        </div>

                        <p>“Früher war ich bei einer Modelagentur dabei und war jetzt auf der Suche nach etwas neuem. Modeln ist für mich ein toller Zeitvertreib, der mir Spaß macht und Abwechslung in meinem Alltag bringt”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/plus50/img2.jpg') }}" alt="Josef" />
                        </div>
                        <div class="name">Josef</div>
                        <div class="company">55 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Auch für keine Technik Profis</blockquote>
                        </div>

                        <p>“Am Anfang hatte ich Bedenken, mein Profil online zu erstellen, da ich nicht wirklich ein Computer Fan bin. Durch Unterstützung des go-models Support Teams habe ich es aber doch geschafft und bin jetzt froh, mir alles selbst erstellen zu können.”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/plus50/img3.jpg') }}" alt="Brigitte" />
                        </div>
                        <div class="name">Brigitte</div>
                        <div class="company">52 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Neue Seiten</blockquote>
                        </div>

                        <p>“Vor der Kamera entdecke ich immer wieder neue Seiten an mir und lerne neues dazu. Man hat nie ausgelernt! :)“</p>
                    </div>
                </div>
            @endfor
        </div>

        <div class="btn">
            <a href="#" class="mfp-register-form">Register and get featured!</a>
        </div>
    </div>

    <div class="block">
        <h2>Go-Model - Gehe Deinen Weg zum 50plus Model!</h2>

        <div class="cols-2 nested">
            <div class="col">
                <div class="howto">
                    <ul>
                        <li><span>Registriere Dich</span> jetzt ganz einfach und schnell online als 50plus Model. Die Bewerbung wird von uns ausgewertet und Du bekommst innerhalb 48 Stunden Bescheid.</li>
                        <li><span>Keine teure Sedcard</span><br />Wir sind viel mehr als eine klassische Modelagentur, denn auf unserem Model Portal brauchst Du keine teure Sedcard um 50plus Model zu werden. Deine Sedcard ist bei uns im Model Profil schon dabei!</li>
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
            <a href="#" class="next mfp-register-form">Jetzt bewerben</a>
        </div>
    </div>

    @include('childs.categories',['title' => 'Jetzt go-50plus Model werden!', 'class' => 'colored-light'])
    @include('childs.jobs')
    <?php /*
    @include('childs.featured')
    */?>
    @include('childs.prices')
@endsection