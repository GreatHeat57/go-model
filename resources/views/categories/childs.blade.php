@extends('layouts.app')

@section('content')
    <div class="cover">
        <img src="{{ URL::to('images/covers/category_childs.jpg') }}" alt="go-Kindermodel - Jeder fängt mal klein an!" />
        <div class="inner">
            <div class="text">
                <div class="holder">
                    <h1>Go-to-Job</h1>
                    <h3>go-Kindermodel - Jeder fängt mal klein an!</h3>

                    <p>Du stöberst in Katalogen oder Magazinen und siehst dabei immer wieder hübsche Kinder, die stolz in der neuen Mode posieren. Und denkst Dir: Das kann mein Kind auch!
                    Oder Du bist zwischen 2 und 15 Jahren und möchtest auch Kindermodel werden?
                    Dann seid ihr bei go-models genau richtig!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="block no-pd-b">
        <div class="cols-2 no-mg-b">
            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/childs/promo1.jpg') }}" alt="Direkt Kindermodels buchen" />
                    <div class="data">
                        <h2>Direkt Kindermodels buchen</h2>
                        <ul>
                            <li>Registriere Dich jetzt als Auftraggeber</li>
                            <li>Stelle jederzeit Jobs ein</li>
                            <li>Kindermodels direkt finden und für einen Auftrag buchen</li>
                        </ul>
                        <div class="btn">
                            <a href="{{ route('book_a_model') }}" class="next">Jetzt Kindermodels buchen</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="promo">
                    <img src="{{ URL::to(config('app.cloud_url').'/images/promos/childs/promo2.jpg') }}" alt="Jetzt Kindermodel werden" />
                    <div class="data">
                        <h2>Jetzt Kindermodel werden</h2>
                        <ul>
                            <li>Bewirb Dein Kind jetzt als Kindermodel</li>
                            <li>verschiedene Auftraggeber und Kindermodel Jobs</li>
                            <li>Trete in Kontakt mit geprüften Auftraggebern</li>
                        </ul>
                        <div class="btn">
                            <a href="#" class="next mfp-register-form">Jetzt Kindermodel werden</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="block">
        <h2>3 Gründe, um ein Go-Kindermodel zu werden:</h2>

        <div class="cols-3 nested">
            <div class="col">
                <div class="reason">
                    <span>1</span>
                    <h4>Jobs in Deiner Umgebung</h4>
                    <p>Du entscheidest, wo Du Jobs mit Deinem Kind annehmen möchtest!</p>
                </div>
            </div>

            <div class="col">
                <div class="reason">
                    <span>2</span>
                    <h4>Datenschutz ist uns wichtig!</h4>
                    <p>Das Profil Deines Kindes ist nur für geprüfte Auftraggeber sichtbar!</p>
                </div>
            </div>

            <div class="col">
                <div class="reason">
                    <span>3</span>
                    <h4>Gemeinsam</h4>
                    <p>Als Elternteil bist Du bei Aufträgen immer an der Seite Deines Kindes! So könnt ihr zusammen in die Model Welt eintauchen!</p>
                </div>
            </div>
        </div>

        <div class="btn">
            <a href="{{ route('premium_membership') }}">Erfahre mehr bei der go-Tour</a>
        </div>
    </div>

    <div class="block colored pd-10">
        <div class="testimonials owl-carousel">
            @for($i=1;$i<=3;$i++)
                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url') . '/images/testimonials/childs/img1.jpg') }}" alt="Lena" />
                        </div>
                        <div class="name">Lena</div>
                        <div class="company">14 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Ich möchte auf jeden Fall weitermachen</blockquote>
                        </div>

                    <p>“Ich habe bei go-models als Kindermodel angefangen, um zu sehen ob es mir Spaß macht.
                    Auf jeden Fall möchte ich mit dem Modeln weitermachen!”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/childs/img2.jpg') }}" alt="Robert" />
                        </div>
                        <div class="name">Robert</div>
                        <div class="company">9 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Mein neues Hobby</blockquote>
                        </div>

                        <p>“Fußball spielen und modeln sind jetzt meine Hobbys. Meine Freunde in der Schule finden es auch ganz cool”</p>
                    </div>
                </div>

                <div class="item">
                    <div class="holder">
                        <div class="image">
                            <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/childs/img3.jpg') }}" alt="Michael-Julian" />
                        </div>
                        <div class="name">Michael-Julian</div>
                        <div class="company">11 Jahre</div>

                        <div class="quote-holder">
                            <blockquote>Aufträge selber aussuchen</blockquote>
                        </div>

                        <p>“Bei go-models kann ich zusammen mit meiner Mutter nach Aufträgen suchen und mich auch direkt darauf bewerben!”</p>
                    </div>
                </div>
            @endfor
        </div>

        <div class="btn">
            <a href="#" class="mfp-register-form">Registriere Dein Kind jetzt als Kindermodel!</a>
        </div>
    </div>

    <div class="block">
        <h2>Jetzt Kindermodel werden - Denn Kinderlachen ist das Schönste!</h2>

        <div class="cols-2 nested">
            <div class="col">
                <div class="howto">
                    <ul>
                        <li><span>Registriere Dein Kind</span> ganz einfach und schnell als Kindermodel. Die Bewerbung wird von uns ausgewertet und Du bekommst in den nächsten 48 Stunden Bescheid.</li>
                        <li><span>Keine teure Sedcard</span><br />Wir sind viel mehr als eine klassische Kindermodel Agentur, denn auf unserem Model Portal braucht Dein Kind keine teure Sedcard um Kindermodel zu werden. Die Sedcard Deines Kindes ist bei uns im Kindermodel Profil schon dabei!</li>
                    </ul>
                </div>
            </div>

            <div class="col">
                <div class="howto">
                    <ul>
                        <li><span>Jobs finden</span><br />Bei uns kannst Du direkt nach Jobs für Dein Kind suchen und Dein Kind gleich auf Jobs bewerben</li>
                        <li><span>Datenschutz</span><br />Deine Daten und die Deines Kindes sind bei uns in der Datenbank sicher!</li>
                        <li><span>Online Profil</span><br />Das Kindermodel Profil Deines Kindes kannst Du ganz einfach und schnell jederzeit bequem von zu Hause aktualisieren.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="btn">
            <a href="#" class="next mfp-register-form">Jetzt bewerben</a>
        </div>
    </div>

    @include('childs.categories',['title' => 'Werde auch Du ein go-Kindermodel!', 'class' => 'colored-light'])
    @include('childs.jobs')
    <?php /*
    @include('childs.featured')
    @include('childs.prices')
    */?>
@endsection