<footer id="footer2" class="d-flex justify-content-center">
    <div class="text-center mw-460">
        &copy; {{ date('Y') }}  go-models.com Alle Rechte vorbehalten
        <a href="#">Datenschutzerklärung</a>  —  <a href="#">Nutzervereinbarung</a>  —  <a href="#">Copyright Policy</a>
        <!-- <a href="#" class="d-block">Impressum</a> -->
        <!-- Website design by <a href="http://www.voov.hu" target="_blank">voov</a> -->

    </div>
    @include('childs.process_loader')
</footer>
<div class="col-12 px-20 py-20 text-center">
     @include('cookieConsent::index')
</div>
@stack('scripts')