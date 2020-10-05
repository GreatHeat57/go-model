@extends('layouts.logged_in.app-model')
@section('content')
    <div class="container px-0 pt-40 pb-60 mb-20">
        <div class="text-center mb-30">
            <h1 class="prata">{{ ucWords(t('go-Academy')) }}</h1>
            <div class="divider mx-auto"></div>
        </div>

        <!-- start tabbing  -->
        <div class="custom-tabs mb-20 mb-xl-30">
            <ul class="d-none d-md-flex justify-content-center">
                <li  id="academy_tab" >
                    <a class=" position-relative active" id="academy_active">{{ t('academy') }}</a>
                </li>
                <li id="courses_tab" >
                    <a class=" position-relative" id="courses_active" >{{ t('courses') }}</a>
                </li>
                <li  id="vip_tab" >
                    <a class=" position-relative" id="vip_active" >{{ t('vip') }}</a>
                </li>
            </ul>
        </div>
        <!-- End tabbing section -->

        <div class="col-lg-12 pb-30" id="academy-progress">
            <div class="academy-progress-item active"><span>{{ t('NEWBIE') }}</span></div>
            <div class="academy-progress-arrow active"></div>
            <div class="academy-progress-item active"><span>{{ t('BEGINNER') }}</span></div>
            <div class="academy-progress-arrow active"></div>
            <div class="academy-progress-item active"><span>{{ t('TALENTED') }}</span></div>
            <div class="academy-progress-arrow "></div>
            <div class="academy-progress-item "><span>{{ t('SKILLED') }}</span></div>
            <div class="academy-progress-arrow "></div>
            <div class="academy-progress-item "><span>{{ t('ADVANCED') }}</span></div>
            <div class="academy-progress-arrow "></div>
            <div class="academy-progress-item "><span>{{ t('EXPERT') }}</span></div>
            <div class="academy-progress-arrow "></div>
            <div class="academy-progress-item master"><span>{{ t('MASTER') }}</span></div>
        </div>
        <!-- Academy section start -->
        <div class="col-lg-12 pb-40 mt-40" style="display: block;" id="academy_container">
            <div class="col-lg-12 pt-40" id="academy_description">
                <h1 class="subtitle center">Learn new skills</h1>
                <div id="academy-progress-info" class="clear-both pt-40 pb-40 mb-40">
                    <div class="progress-item">
                        <div class="thumb-icon note"></div>
                        <div class="value-section">
                            <span class="value">4/7</span>
                            <span class="comment">Completed courses</span>
                        </div>
                    </div>
                    <div class="progress-item">
                        <div class="thumb-icon comma"></div>
                        <div class="value-section">
                            <span class="value">2</span>
                            <span class="comment">Testimonials</span>
                        </div>
                    </div>
                </div>

                <h2 class="subtitle">Welcome to the go-models Academy</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue, pede vitae dapibus aliquet, elit magna vulputate arcu, vel tempus metus leo non est. Etiam sit amet lectus quis est congue mollis. Phasellus congue lacus eget neque.</p>
                <h2 class="subtitle">From Newbie to Master</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue.</p>
                <h2 class="subtitle">How to become a VIP model</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue, pede vitae dapibus aliquet, elit magna vulputate arcu, vel tempus metus leo non est. Etiam sit amet lectus quis est congue mollis. Phasellus congue lacus eget neque.</p>
                <div class="text-center full-width pb-40 pt-40">
                    <a href="#" class="btn btn-success">START NOW</a>
                </div>
            </div>

            <div class="col-lg-12 pt-40" id="academy_faqs">
                <h1 class="subtitle center">FAQs</h1>
                <div class="academy_faq_list">
                    <div class="faq_item">
                        <h4 class="pb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                    </div>
                    <div class="faq_item">
                        <h4 class="pb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                    </div>
                    <div class="faq_item">
                        <h4 class="pb-10">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 pt-40 pb-40 mt-40" id="academy_download_guide">
                <div class="col-lg-2">
                    <img src="/images/icons/ebook.png" />
                </div>
                <div class="col-lg-7">
                    <h2 class="subtitle">go-models E-book</h2>
                    <p>Check out our brand new ebook with essential tips and helpful information on topics such as home-model jobs, image editing, comp card, and more!</p>
                </div>
                <div class="col-lg-3">
                    <a href="#" class="btn btn-white download mini-mobile position-relative">Download e-book</a>
                </div>
            </div>

            <div class="col-lg-12 pt-40 pb-40" id="academy_articles">
                <h1 class="subtitle center">Check useful articles</h1>
                <div class="cols-3">
                    <div class="col">
                        <div class="post emphasized">
                            <a href="https://staging.go-models.com/magazine/my-test-blog-create">
                                <img src="https://staging.go-models.com/uploads/app/page/the-new-style-trends-for-this-fall!-350x210.jpg" alt="363c75e27356e559d6e2ad641f59e981" class="thumb ls-is-cached lazyloaded" onerror="this.src='https://staging.go-models.com/uploads/app/page/363c75e27356e559d6e2ad641f59e981-350x210.jpg'">
                            </a>
                            <h6 class="text-center mt-10 mb-10"><a href="https://staging.go-models.com/blog-category/trends">Trends </a></h6>
                            <h2 class="subtitle center"><a href="https://staging.go-models.com/magazine/my-test-blog-create">My test blog create</a></h2>
                        </div>
                    </div>
                    <div class="col">
                        <div class="post emphasized">
                            <a href="https://staging.go-models.com/magazine/interviewing-tips-for-a-modeling-career">
                                <img src="https://staging.go-models.com/uploads/app/page/interviewing-tips-for-a-modelling-career-350x210.jpg" alt="interviewing-tips-for-a-modelling-career" class="thumb ls-is-cached lazyloaded" onerror="this.src='https://staging.go-models.com/uploads/app/page/interviewing-tips-for-a-modelling-career-350x210.jpg'">
                            </a>
                            <h6 class="text-center mt-10 mb-10"><a href="https://staging.go-models.com/blog-category/tips-and-tricks">Tips and Tricks </a></h6>
                            <h2 class="subtitle center"><a href="https://staging.go-models.com/magazine/interviewing-tips-for-a-modeling-career">Interviewing Tips for a Modeling Career</a></h2>
                        </div>
                    </div>
                    <div class="col">
                        <div class="post emphasized">
                            <a href="https://staging.go-models.com/magazine/the-new-style-trends-for-this-fall">
                                <img src="https://staging.go-models.com/uploads/app/page/the-new-style-trends-for-this-fall!-350x210.jpg" alt="the-new-style-trends-for-this-fall!" class="thumb ls-is-cached lazyloaded" onerror="this.src='https://staging.go-models.com/uploads/app/page/the-new-style-trends-for-this-fall!-350x210.jpg'">
                            </a>
                            <h6 class="text-center mt-10 mb-10"><a href="https://staging.go-models.com/blog-category/trends">Trends </a></h6>
                            <h2 class="subtitle center"><a href="https://staging.go-models.com/magazine/the-new-style-trends-for-this-fall">The new style trends for this fall!</a></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 pt-40 pb-40" id="academy_articles">
                <h1 class="subtitle center">Reviews</h1>
                
                <div class="testimonials owl-carousel owl-loaded owl-drag">
                            

                

                
                            

                

                
                            

                

                
                    <div class="owl-stage-outer owl-height" style="height: 753px;"><div class="owl-stage" style="transform: translate3d(-5112px, 0px, 0px); transition: all 0.25s ease 0s; width: 8094px;"><div class="owl-item cloned" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp" class="lazyload" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/earn-money-as-a-model.jpg'">
                        </div>
                        <div class="name">Model Lisa</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>
Extremely professional</blockquote>
                        </div>
                        <p>“Couldn't have gone better. The company was extremely professional and the contact person was very pleasant. Everything was explained to me in great detail and I left with a feeling of accomplishment.”
</p>
                    </div>
                </div></div><div class="owl-item cloned" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/baby-model.webp" class="lazyload" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/baby-model.jpg'">
                        </div>
                        <div class="name">Mother of Lisa Marie </div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Great experience</blockquote>
                        </div>
                        <p>“Honestly, I can state that I can easily work with your portal. The actual profile editing was quite simple and really meant with everyone in mind. You can edit your own comp card and design it the way you choose. Everything is clearly explained!" </p>
                    </div>
                </div></div><div class="owl-item cloned" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/casting-agency.webp" class=" ls-is-cached lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/casting-agency.jpg'" src="https://staging.go-models.com/images/testimonials/casting-agency.webp">
                        </div>
                        <div class="name">Drezzer</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Photo shoot for fashion platform Drezzer</blockquote>
                        </div>
                        <p>"Drezzer is always looking for new models for upcoming fashion collections. At our last shoot, some of our models were booked to showcase the fashion of the designers. A great shooting day with wonderful pictures!"</p>
                    </div>
                </div></div><div class="owl-item cloned" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp" class=" lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/earn-money-as-a-model.jpg'" src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp">
                        </div>
                        <div class="name">Model Lisa</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>
Extremely professional</blockquote>
                        </div>
                        <p>“Couldn't have gone better. The company was extremely professional and the contact person was very pleasant. Everything was explained to me in great detail and I left with a feeling of accomplishment.”
</p>
                    </div>
                </div></div><div class="owl-item cloned" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/baby-model.webp" class=" lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/baby-model.jpg'" src="https://staging.go-models.com/images/testimonials/baby-model.webp">
                        </div>
                        <div class="name">Mother of Lisa Marie </div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Great experience</blockquote>
                        </div>
                        <p>“Honestly, I can state that I can easily work with your portal. The actual profile editing was quite simple and really meant with everyone in mind. You can edit your own comp card and design it the way you choose. Everything is clearly explained!" </p>
                    </div>
                </div></div><div class="owl-item" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/casting-agency.webp" class=" lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/casting-agency.jpg'" src="https://staging.go-models.com/images/testimonials/casting-agency.webp">
                        </div>
                        <div class="name">Drezzer</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Photo shoot for fashion platform Drezzer</blockquote>
                        </div>
                        <p>"Drezzer is always looking for new models for upcoming fashion collections. At our last shoot, some of our models were booked to showcase the fashion of the designers. A great shooting day with wonderful pictures!"</p>
                    </div>
                </div></div><div class="owl-item" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp" class=" lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/earn-money-as-a-model.jpg'" src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp">
                        </div>
                        <div class="name">Model Lisa</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>
Extremely professional</blockquote>
                        </div>
                        <p>“Couldn't have gone better. The company was extremely professional and the contact person was very pleasant. Everything was explained to me in great detail and I left with a feeling of accomplishment.”
</p>
                    </div>
                </div></div><div class="owl-item" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/baby-model.webp" class=" lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/baby-model.jpg'" src="https://staging.go-models.com/images/testimonials/baby-model.webp">
                        </div>
                        <div class="name">Mother of Lisa Marie </div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Great experience</blockquote>
                        </div>
                        <p>“Honestly, I can state that I can easily work with your portal. The actual profile editing was quite simple and really meant with everyone in mind. You can edit your own comp card and design it the way you choose. Everything is clearly explained!" </p>
                    </div>
                </div></div><div class="owl-item" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/casting-agency.webp" class=" lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/casting-agency.jpg'" src="https://staging.go-models.com/images/testimonials/casting-agency.webp">
                        </div>
                        <div class="name">Drezzer</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Photo shoot for fashion platform Drezzer</blockquote>
                        </div>
                        <p>"Drezzer is always looking for new models for upcoming fashion collections. At our last shoot, some of our models were booked to showcase the fashion of the designers. A great shooting day with wonderful pictures!"</p>
                    </div>
                </div></div><div class="owl-item" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp" class=" lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/earn-money-as-a-model.jpg'" src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp">
                        </div>
                        <div class="name">Model Lisa</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>
Extremely professional</blockquote>
                        </div>
                        <p>“Couldn't have gone better. The company was extremely professional and the contact person was very pleasant. Everything was explained to me in great detail and I left with a feeling of accomplishment.”
</p>
                    </div>
                </div></div><div class="owl-item" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/baby-model.webp" class=" ls-is-cached lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/baby-model.jpg'" src="https://staging.go-models.com/images/testimonials/baby-model.webp">
                        </div>
                        <div class="name">Mother of Lisa Marie </div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Great experience</blockquote>
                        </div>
                        <p>“Honestly, I can state that I can easily work with your portal. The actual profile editing was quite simple and really meant with everyone in mind. You can edit your own comp card and design it the way you choose. Everything is clearly explained!" </p>
                    </div>
                </div></div><div class="owl-item" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/casting-agency.webp" class=" ls-is-cached lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/casting-agency.jpg'" src="https://staging.go-models.com/images/testimonials/casting-agency.webp">
                        </div>
                        <div class="name">Drezzer</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Photo shoot for fashion platform Drezzer</blockquote>
                        </div>
                        <p>"Drezzer is always looking for new models for upcoming fashion collections. At our last shoot, some of our models were booked to showcase the fashion of the designers. A great shooting day with wonderful pictures!"</p>
                    </div>
                </div></div><div class="owl-item active" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp" class=" ls-is-cached lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/earn-money-as-a-model.jpg'" src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp">
                        </div>
                        <div class="name">Model Lisa</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>
Extremely professional</blockquote>
                        </div>
                        <p>“Couldn't have gone better. The company was extremely professional and the contact person was very pleasant. Everything was explained to me in great detail and I left with a feeling of accomplishment.”
</p>
                    </div>
                </div></div><div class="owl-item active" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/baby-model.webp" class=" ls-is-cached lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/baby-model.jpg'" src="https://staging.go-models.com/images/testimonials/baby-model.webp">
                        </div>
                        <div class="name">Mother of Lisa Marie </div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Great experience</blockquote>
                        </div>
                        <p>“Honestly, I can state that I can easily work with your portal. The actual profile editing was quite simple and really meant with everyone in mind. You can edit your own comp card and design it the way you choose. Everything is clearly explained!" </p>
                    </div>
                </div></div><div class="owl-item cloned active" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/casting-agency.webp" class=" ls-is-cached lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/casting-agency.jpg'" src="https://staging.go-models.com/images/testimonials/casting-agency.webp">
                        </div>
                        <div class="name">Drezzer</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Photo shoot for fashion platform Drezzer</blockquote>
                        </div>
                        <p>"Drezzer is always looking for new models for upcoming fashion collections. At our last shoot, some of our models were booked to showcase the fashion of the designers. A great shooting day with wonderful pictures!"</p>
                    </div>
                </div></div><div class="owl-item cloned" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp" class=" ls-is-cached lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/earn-money-as-a-model.jpg'" src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp">
                        </div>
                        <div class="name">Model Lisa</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>
Extremely professional</blockquote>
                        </div>
                        <p>“Couldn't have gone better. The company was extremely professional and the contact person was very pleasant. Everything was explained to me in great detail and I left with a feeling of accomplishment.”
</p>
                    </div>
                </div></div><div class="owl-item cloned" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/baby-model.webp" class=" ls-is-cached lazyloaded" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/baby-model.jpg'" src="https://staging.go-models.com/images/testimonials/baby-model.webp">
                        </div>
                        <div class="name">Mother of Lisa Marie </div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Great experience</blockquote>
                        </div>
                        <p>“Honestly, I can state that I can easily work with your portal. The actual profile editing was quite simple and really meant with everyone in mind. You can edit your own comp card and design it the way you choose. Everything is clearly explained!" </p>
                    </div>
                </div></div><div class="owl-item cloned" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/casting-agency.webp" class="lazyload" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/casting-agency.jpg'">
                        </div>
                        <div class="name">Drezzer</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>Photo shoot for fashion platform Drezzer</blockquote>
                        </div>
                        <p>"Drezzer is always looking for new models for upcoming fashion collections. At our last shoot, some of our models were booked to showcase the fashion of the designers. A great shooting day with wonderful pictures!"</p>
                    </div>
                </div></div><div class="owl-item cloned" style="width: 426px;"><div class="item">
                    <div class="holder">
                        <div class="image">
                            <img data-src="https://staging.go-models.com/images/testimonials/earn-money-as-a-model.webp" class="lazyload" alt="" onerror="this.src='https://staging.go-models.com/images/testimonials/earn-money-as-a-model.jpg'">
                        </div>
                        <div class="name">Model Lisa</div>
                        <div class="company">— go-models —</div>

                        <div class="quote-holder">
                            <blockquote>
Extremely professional</blockquote>
                        </div>
                        <p>“Couldn't have gone better. The company was extremely professional and the contact person was very pleasant. Everything was explained to me in great detail and I left with a feeling of accomplishment.”
</p>
                    </div>
                </div></div></div></div><div class="owl-nav"><button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button></div><div class="owl-dots"><button role="button" class="owl-dot"><span></span></button><button role="button" class="owl-dot"><span></span></button><button role="button" class="owl-dot active"><span></span></button></div></div>



            </div>
        </div>
        <!-- End Of Academy -->

        <!-- Courses section start -->
        <div class="col-lg-12 pb-40 mt-40" style="display: none;" id="courses_container">

            <div id="course-list" class="clear-both">
                <div class="course-item">
                    <div class="course-item-inner">
                        <div class="course-logo">
                            <span class="logo-mark contract passed"></span>
                            <p class="attempt-info">Attempts: 1/3</p>
                        </div>
                        <h2 class="subtitle">Contact</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                        <div class="start-rate"></div>
                        <div class="total-info pt-20 pb-10">
                            <div class="total-review">
                                <span class="mark comma"></span>
                                <span>2 reviews</span>
                            </div>
                            <div class="total-passed">
                                <span class="mark user"></span>
                                <span>120 passed</span>
                            </div>
                        </div>
                        <div class="center pt-20">
                            <a href="#" class="btn btn-white mini-mobile position-relative">Go to course</a>
                        </div>
                    </div>
                </div>

                <div class="course-item">
                    <div class="course-item-inner">
                        <div class="course-logo">
                            <span class="logo-mark comp-card passed"></span>
                            <p class="attempt-info">Attempts: 2/3</p>
                        </div>
                        <h2 class="subtitle">Comp card</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                        <div class="start-rate"></div>
                        <div class="total-info pt-20 pb-10">
                            <div class="total-review">
                                <span class="mark comma"></span>
                                <span>2 reviews</span>
                            </div>
                            <div class="total-passed">
                                <span class="mark user"></span>
                                <span>120 passed</span>
                            </div>
                        </div>
                        <div class="center pt-20">
                            <a href="#" class="btn btn-white mini-mobile position-relative">Go to course</a>
                        </div>
                    </div>
                </div>

                <div class="course-item">
                    <div class="course-item-inner">
                        <div class="course-logo">
                            <span class="logo-mark home-modeling passed"></span>
                            <p class="attempt-info">Attempts: 2/3</p>
                        </div>
                        <h2 class="subtitle">Home modeling</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                        <div class="start-rate"></div>
                        <div class="total-info pt-20 pb-10">
                            <div class="total-review">
                                <span class="mark comma"></span>
                                <span>2 reviews</span>
                            </div>
                            <div class="total-passed">
                                <span class="mark user"></span>
                                <span>120 passed</span>
                            </div>
                        </div>
                        <div class="center pt-20">
                            <a href="#" class="btn btn-white mini-mobile position-relative">Go to course</a>
                        </div>
                    </div>
                </div>

                <div class="course-item">
                    <div class="course-item-inner">
                        <div class="course-logo">
                            <span class="logo-mark nutrition passed"></span>
                            <p class="attempt-info">Attempts: 3/3</p>
                        </div>
                        <h2 class="subtitle">Nutrition</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                        <div class="start-rate"></div>
                        <div class="total-info pt-20 pb-10">
                            <div class="total-review">
                                <span class="mark comma"></span>
                                <span>2 reviews</span>
                            </div>
                            <div class="total-passed">
                                <span class="mark user"></span>
                                <span>120 passed</span>
                            </div>
                        </div>
                        <div class="center pt-20">
                            <a href="#" class="btn btn-white mini-mobile position-relative">Go to course</a>
                        </div>
                    </div>
                </div>

                <div class="course-item">
                    <div class="course-item-inner">
                        <div class="course-logo">
                            <span class="logo-mark fitness"></span>
                            <p class="attempt-info">Attempts: 3/3</p>
                        </div>
                        <h2 class="subtitle">Fitness</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                        <div class="start-rate"></div>
                        <div class="total-info pt-20 pb-10">
                            <div class="total-review">
                                <span class="mark comma"></span>
                                <span>2 reviews</span>
                            </div>
                            <div class="total-passed">
                                <span class="mark user"></span>
                                <span>120 passed</span>
                            </div>
                        </div>
                        <div class="center pt-20">
                            <a href="#" class="btn btn-white mini-mobile position-relative">Go to course</a>
                        </div>
                    </div>
                </div>

                <div class="course-item">
                    <div class="course-item-inner">
                        <div class="course-logo">
                            <span class="logo-mark todo"></span>
                            <p class="attempt-info">Attempts: 3/3</p>
                        </div>
                        <h2 class="subtitle">Dos and Dont's</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                        <div class="start-rate"></div>
                        <div class="total-info pt-20 pb-10">
                            <div class="total-review">
                                <span class="mark comma"></span>
                                <span>2 reviews</span>
                            </div>
                            <div class="total-passed">
                                <span class="mark user"></span>
                                <span>120 passed</span>
                            </div>
                        </div>
                        <div class="center pt-20">
                            <a href="#" class="btn btn-white mini-mobile position-relative">Go to course</a>
                        </div>
                    </div>
                </div>

                <div class="course-item">
                    <div class="course-item-inner">
                        <div class="course-logo">
                            <span class="logo-mark training"></span>
                            <p class="attempt-info">Attempts: 3/3</p>
                        </div>
                        <h2 class="subtitle">Trained go-model</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. </p>
                        <div class="start-rate"></div>
                        <div class="total-info pt-20 pb-10">
                            <div class="total-review">
                                <span class="mark comma"></span>
                                <span>2 reviews</span>
                            </div>
                            <div class="total-passed">
                                <span class="mark user"></span>
                                <span>120 passed</span>
                            </div>
                        </div>
                        <div class="center pt-20">
                            <a href="#" class="btn btn-white mini-mobile position-relative">Go to course</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="course-review-form">
                <div class="d-flex justify-content-center align-items-center container px-0">
                    <a href="#" class="btn btn-white mb-20">Back to courses</a>
                </div>
                <div class="review-form-wrapper">
                    <div class="inner pt-40">
                        <span class="logo-mark contract passed"></span>
                        <h2 class="subtitle center mb-40">Contract</h1>
                        <div class="attempt-info clear-both">
                            <a href="#" class="btn btn-white download mb-20">Certificate</a>
                            <ul class="pull-left">
                                <li>Date: 10.09.2020</li>
                                <li>Attempts: 2/3</li>
                            </ul>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue, pede vitae dapibus aliquet, elit magna vulputate arcu, vel tempus metus leo non est. Etiam sit amet lectus quis est congue mollis. Phasellus congue lacus eget neque.</p>
                        <h2 class="subtitle center">Add Review</h1>
                        <div>
                            <form action="">
                                <div class="row">
                                    <label for="">Review heading</label>
                                    <input placeholder="Instagram" class="mb-30" name="instagram" type="text" value="">
                                </div>
                                <div class="row">
                                    <label for="">Your opinion about this course</label>
                                    <textarea class="mb-30" rows="5"></textarea>
                                </div>
                                <div class="row d-flex justify-content-center align-items-center container px-0">
                                    <button type="submit" class="btn btn-success save">SUBMIT</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Of Courses -->

        <!-- VIP section start -->
        <div class="col-lg-12 pb-40 mt-40" style="display: none;" id="vip_container">
            <div class="col-lg-12 pt-40 mb-40" id="vip_description">
                <h2 class="subtitle ">Welcome to the go-models VIP</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue, pede vitae dapibus aliquet, elit magna vulputate arcu, vel tempus metus leo non est. Etiam sit amet lectus quis est congue mollis. Phasellus congue lacus eget neque.</p>
                <h2 class="subtitle">VIP Benefits</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue.</p>
                <ul>
                    <li>Phasellus pharetra nulla ac diam</li>
                    <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</li>
                    <li>Quisque semper justo at risus.</li>
                    <li>Etiam pellentesque aliquet tellus.</li>
                </ul>
                <div class="text-center full-width pb-40 pt-40">
                    <a href="#" class="btn btn-success">JOIN NOW!</a>
                </div>
            </div>

            <div class="col-lg-12 mt-40" id="vip-request">
                <div class="inner pt-40">
                    <span class="logo-mark contract passed"></span>
                    <h1 class="subtitle center mb-40">Welcome to the go-models VIP</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue, pede vitae dapibus aliquet, elit magna vulputate arcu, vel tempus metus leo non est. Etiam sit amet lectus quis est congue mollis. Phasellus congue lacus eget neque.</p>
                    <h2 class="subtitle">VIP Benefits</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Proin nibh augue, suscipit a, scelerisque sed, lacinia in, mi. Cras vel lorem. Etiam pellentesque aliquet tellus. Phasellus pharetra nulla ac diam. Quisque semper justo at risus. Donec venenatis, turpis vel hendrerit interdum, dui ligula ultricies purus, sed posuere libero dui id orci. Nam congue.</p>                
                </div>
            </div>

        </div>
        <!-- End Of Courses -->

    </div>
    @include('childs.bottom-bar')
</div>
@endsection
@section('page-script')

{{ Html::script(config('app.cloud_url').'/assets/js/app/make.favorite.js') }}
{{ Html::style(config('app.cloud_url').'/css/bladeCss/static-inner-page.css') }}
<link rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/inc/layout.css') }}" media="all" />
<link rel="stylesheet" type="text/css" href="{{ url(config('app.cloud_url').'/css/dcsns_wall.css') }}" media="all" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script src="{{ url(config('app.cloud_url').'/inc/js/jquery.plugins.js') }}"></script>
<script src="{{ url(config('app.cloud_url').'/inc/js/jquery.site.js') }}"></script>
<script src="{{url(config('app.cloud_url').'/js/jquery.social.stream.wall.1.8.js')}}"></script>
<script src="{{url(config('app.cloud_url').'/js/jquery.social.stream.1.6.2.min.js')}}"></script>
<script type="text/javascript">
    $('#academy_tab').click(function() {
        removeActiveClass();
        $("#academy_active").addClass("active");
        $("#academy_container").attr('style', 'display: block');
        $("#courses_container").attr('style', 'display: none');
        $("#vip_container").attr('style', 'display: none');
    });
    $('#courses_tab').click(function() {
        if (!$("#courses_tab a").data('toggle')){
            removeActiveClass();
            $("#courses_active").addClass("active");
            $("#academy_container").attr('style', 'display: none');
            $("#courses_container").attr('style', 'display: block');
            $("#vip_container").attr('style', 'display: none');
        }
    });
    $('#vip_tab').click(function() {
        if (!$("#vip_tab a").data('toggle')){
            removeActiveClass();
            $("#vip_active").addClass("active");
            $("#academy_container").attr('style', 'display: none');
            $("#courses_container").attr('style', 'display: none');
            $("#vip_container").attr('style', 'display: block');
        }
    });

    function removeActiveClass(){
        $("#academy_active").removeClass("active");
        $("#courses_active").removeClass("active");
        $("#vip_active").removeClass("active");
    }

</script>
<style type="text/css">
    .stream li.dcsns-twitter .section-intro,.filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:#4ec2dc!important;}.stream li.dcsns-facebook .section-intro,.filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:#3b5998!important;}.stream li.dcsns-google .section-intro,.filter .f-google a:hover, .wall-outer .dcsns-toolbar .filter .f-google a.iso-active{background-color:#2d2d2d!important;}.stream li.dcsns-rss .section-intro,.filter .f-rss a:hover, .wall-outer .dcsns-toolbar .filter .f-rss a.iso-active{background-color:#FF9800!important;}.stream li.dcsns-flickr .section-intro,.filter .f-flickr a:hover, .wall-outer .dcsns-toolbar .filter .f-flickr a.iso-active{background-color:#f90784!important;}.stream li.dcsns-delicious .section-intro,.filter .f-delicious a:hover, .wall-outer .dcsns-toolbar .filter .f-delicious a.iso-active{background-color:#3271CB!important;}.stream li.dcsns-youtube .section-intro,.filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:#DF1F1C!important;}.stream li.dcsns-pinterest .section-intro,.filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:#CB2528!important;}.stream li.dcsns-lastfm .section-intro,.filter .f-lastfm a:hover, .wall-outer .dcsns-toolbar .filter .f-lastfm a.iso-active{background-color:#C90E12!important;}.stream li.dcsns-dribbble .section-intro,.filter .f-dribbble a:hover, .wall-outer .dcsns-toolbar .filter .f-dribbble a.iso-active{background-color:#F175A8!important;}.stream li.dcsns-vimeo .section-intro,.filter .f-vimeo a:hover, .wall-outer .dcsns-toolbar .filter .f-vimeo a.iso-active{background-color:#4EBAFF!important;}.stream li.dcsns-stumbleupon .section-intro,.filter .f-stumbleupon a:hover, .wall-outer .dcsns-toolbar .filter .f-stumbleupon a.iso-active{background-color:#EB4924!important;}.stream li.dcsns-deviantart .section-intro,.filter .f-deviantart a:hover, .wall-outer .dcsns-toolbar .filter .f-deviantart a.iso-active{background-color:#607365!important;}.stream li.dcsns-tumblr .section-intro,.filter .f-tumblr a:hover, .wall-outer .dcsns-toolbar .filter .f-tumblr a.iso-active{background-color:#385774!important;}.stream li.dcsns-instagram .section-intro,.filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:#413A33!important;}.dcwss.dc-wall .stream li {width: 425px!important; margin: 0px 15px 15px 0px!important;}.wall-outer #dcsns-filter.dc-center{padding-left: 0% !important;margin-left: 0px !important;padding-right: 0%;}.stream li.dcsns-facebook .section-intro, .filter .f-facebook a:hover, .wall-outer .dcsns-toolbar .filter .f-facebook a.iso-active{background-color:transparent !important; }.stream li.dcsns-twitter .section-intro, .filter .f-twitter a:hover, .wall-outer .dcsns-toolbar .filter .f-twitter a.iso-active{background-color:transparent !important;}.stream li.dcsns-youtube .section-intro, .filter .f-youtube a:hover, .wall-outer .dcsns-toolbar .filter .f-youtube a.iso-active{background-color:transparent !important;}.stream li.dcsns-pinterest .section-intro, .filter .f-pinterest a:hover, .wall-outer .dcsns-toolbar .filter .f-pinterest a.iso-active{background-color:transparent !important;}.stream li.dcsns-instagram .section-intro, .filter .f-instagram a:hover, .wall-outer .dcsns-toolbar .filter .f-instagram a.iso-active{background-color:transparent !important;}.wall-outer .dcsns-toolbar .filter li a{padding: 10px 16px;}#socialstream-section{height:auto !important;}.wall-outer{max-height: 1000px;}.wall-outer .dcsns-toolbar .filter li{padding-top: 3px;}

        .wall-outer .dcsns-toolbar .filter li a{padding: 10px 27px; }
        span.socicon.socicon-facebook { color: #3b5998; } span.socicon.socicon-twitter{ color: #55acee;  } span.socicon.socicon-youtube { color: #cd201f; } span.socicon.socicon-pinterest{ color: #bd081c; } span.socicon.socicon-instagram { color: #3f729b;  }

        @media (min-width: 768px) and (max-width: 1024px) {
            .dcwss.dc-wall .stream li {
               width: 500px; margin: 0px 15px 15px 9px !important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ width: auto; padding: 10px 36px; }
            .wall-outer #dcsns-filter.dc-center {   float: center !important;margin-left: -73px !important }
            .wall-outer .dcsns-toolbar { padding: 0px 0px 0px 100px; }
            .wall-outer .dcsns-toolbar .filter li{ padding: 8px; padding-top: 3px; }

            /*.wall-outer .dcsns-toolbar .filter li{ padding: 3px 50px 0px 40px; }*/
            
        }

        /*Portrait*/ 
        @media only screen and (min-width: 1024px) and (orientation: portrait) { 
            .dcwss.dc-wall .stream li {
               width: 500px; margin: 0px 15px 15px 9px !important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ width: 100%; padding: 10px 20px; }
            .wall-outer #dcsns-filter.dc-center {   float: center !important; margin-left: -73px !important; }
            .wall-outer .dcsns-toolbar { padding: 0px 0px 0px 0px; }
            .wall-outer .dcsns-toolbar .filter li{ padding: 8px; padding-top: 3px;}
        }
        
        @media (min-width: 320px) and (max-width: 480px) {
            .dcwss.dc-wall .stream li {
                width: auto; margin: 0px 15px 15px 0px!important;
            }
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 18px; }
            .dcwss.dc-wall.modern.light .stream li { max-width: 100%;  }
            ul.stream{  width: auto !important; }
        }
        @media (max-width: 320px){
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 15px; }
            ul.stream{  width: auto !important; }
        }
        /* center text for social link */
        .dcsns-toolbar {
            display: flex !important;
            justify-content: center !important;
        }
        #dcsns-filter {
            display: flex !important;
            justify-content: center !important;
            width: 100% !important;
        }
        /*@media (min-width: 375px) and (max-width: 424px) {
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 21px; }
        }
        @media (min-width: 425px) and (max-width: 767px) {
            .wall-outer .dcsns-toolbar .filter li a{ padding: 10px 23px; }
        }
*/
</style>

<script src="{{ url(config('app.cloud_url').'/assets/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ url(config('app.cloud_url').'/assets/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
<script>
    $(window).on('load', function() {
        var height =  ($('.wall-outer').height() + 200);
        $("#social_container").css('height',height);
    });
</script>
@endsection