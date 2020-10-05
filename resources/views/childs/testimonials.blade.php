<div class="block colored pd-10">
    <div class="testimonials owl-carousel">
        @for($i=1;$i<=3;$i++)
            <div class="item">
                <div class="holder">
                    <div class="image">
                        <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/img1.jpg') }}" alt="" />
                    </div>
                    <div class="name">Daniel Smith</div>
                    <div class="company">— Love Clothes Group —</div>

                    <div class="quote-holder">
                        <blockquote>I can't live without go-models</blockquote>
                    </div>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mollis lorem quis nibh consequat, non sollicitudin
                    augue pretium. Duis vel ante quis nulla sagittis luctus. Sed sed mauris sed elit oncus fringilla. Duis consequat orci
                    ac diam mattis.</p>
                </div>
            </div>

            <div class="item">
                <div class="holder">
                    <div class="image">
                        <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/img2.jpg') }}" alt="" />
                    </div>
                    <div class="name">Karla Gray</div>
                    <div class="company">— Love Clothes Group —</div>

                    <div class="quote-holder">
                        <blockquote>I can't live without go-models</blockquote>
                    </div>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mollis lorem quis nibh consequat, non sollicitudin
                    augue pretium. Duis vel ante quis nulla sagittis luctus. Sed sed mauris sed elit oncus fringilla. Duis consequat orci
                    ac diam mattis.</p>
                </div>
            </div>

            <div class="item">
                <div class="holder">
                    <div class="image">
                        <img src="{{ URL::to(config('app.cloud_url'). '/images/testimonials/img3.jpg') }}" alt="" />
                    </div>
                    <div class="name">Martha Taylor</div>
                    <div class="company">— Love Clothes Group —</div>

                    <div class="quote-holder">
                        <blockquote>I can't live without go-models</blockquote>
                    </div>

                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi mollis lorem quis nibh consequat, non sollicitudin
                    augue pretium. Duis vel ante quis nulla sagittis luctus. Sed sed mauris sed elit oncus fringilla. Duis consequat orci
                    ac diam mattis.</p>
                </div>
            </div>
        @endfor
    </div>

    <div class="btn">
        <a href="#" class="mfp-register-form">Register and get featured</a>
    </div>
</div>