<div class="white-popup-block country-popup-block" id="mfp-country">
    <h2 class="smaller">{{ t('Select your Country') }}</h2>
    <div class="content static_page_content margin-10" style="margin-top: 0px !important;">
        <div class="" wfd-id="40">
            <div class="inner" wfd-id="42">
                <div class="row">
                    @if (isset($contient))
                        @foreach ($contient as $key => $country)
                            <ul class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 country-list">
                                <li class="border-li">
                                    <span class="c_title">{{ $country->name }}</span>
                                </li>
                                <div class="row rpt-10">
                                    @foreach ($country->country as $k => $cont)
                                            <ul class="col sub-li countrylist">
                                                @foreach ($cont as $k => $col)
                                                    <li class="countrylist-item">
                                                        <a href="{{ url(config('lang.abbr').'/country?d=' . $col->code) }}" data-code="{{ $country->code }}" class="tooltip-test flag-lable country-link" title="{{ $col->name }}">
                                                            @if (file_exists(public_path().'/images/flags/24/'.strtolower($col->code).'.png'))
                                                                <img src="{{ URL::to(config('app.cloud_url').'/images/flags/24/'.strtolower($col->code).'.png') }}" class="flag flag-zw fg-select" style="margin-bottom: 4px; margin-right: 5px;" alt="{{ strtolower($col->code).'.png' }}">
                                                            @else
                                                                <img src="{{ url('images/flags/no-flag.png') }}" class="flag flag-zw" style="margin-bottom: 4px; margin-right: 5px;">
                                                            @endif
                                                        <span class="countrylist-caption block-link" >{{ $col->asciiname }}</span></a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                     @endforeach
                                </div>
                             </ul>
                        @endforeach
                    @endif
                </div>
            </div>
	    </div>
  	</div>
</div>
<style type="text/css">
    .border-li { border-bottom: 1px solid;  border-color: gray; margin-top: 40px;}
    .rpt-10 {  padding-top: 20px; }
    .c_title { font-family: work_sansbold, arial, tahoma; font-size: 17px; }
    .flag-lable { display: inline-block; vertical-align: middle; line-height: 1.33341; font-weight: 400; letter-spacing: -.01em; width: 75%; }
    ul.sub-li li {  padding-top: 10px; }
    span.countrylist-caption.block-link {
        display: inline-block;
        width: 150px;
        vertical-align: middle;
    }
    @media screen and (max-width: 600px) { 
        li.countrylist-item{
            width: 100%;
            display: flex;
            -webkit-box-align: center;
            align-items: center;
            float: left;
            padding-left: 10px;
        }
        ul.col.sub-li.countrylist{
            display: contents;    
        }
        span.countrylist-caption.block-link {
            width: 220px;
            display: initial;
            vertical-align: middle;
            font-size: 12px;
            line-height: 1.33341;
            font-weight: 400;
            letter-spacing: -.01em;
        }
    }
    a.country-link:hover {
        text-decoration: none;
    }
    span.countrylist-caption.block-link:hover{
        text-decoration: underline;
        color: #0070c9;
    }
    .flag-lable{
        display: contents;
    }

    @media (min-width: 992px) {
        .country-popup-block { max-width: 85%; }
    }
}
    
</style>