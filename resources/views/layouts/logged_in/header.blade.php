<header class="d-flex align-items-center bg-white box-shadow">
    <div class="d-flex flex-grow-1 align-items-center justify-content-between">
        <a href="#" class="mobile-menu-button d-md-none"></a>
        <a href="#"><img srcset="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }},
                                     {{ URL::to(config('app.cloud_url').'/images/img-logo@2x.png') }} 2x,
                                     {{ URL::to(config('app.cloud_url').'/images/img-logo@3x.png') }} 3x"
                         src="{{ URL::to(config('app.cloud_url').'/images/img-logo.png') }}" alt="{{ trans('metaTags.Go-Models') }}" class="logo2"/></a>
    </div>
    <div class="flex-grow-2">
        <nav class="d-none d-md-block">
            <ul class="m-0 d-flex align-items-center">
                <li><a href="#" class="dashboard-btn">Dashboard</a></li>
                <li><a href="#" class="social-btn">Social</a></li>
                <li><a href="#">Find models</a></li>
                <li><a href="#">Posted jobs</a></li>
                <li class="d-none d-lg-inline-block"><a href="#">Find work</a></li>
                <li class="d-none d-lg-inline-block"><a href="#">My jobs</a></li>
                <li class="d-none d-lg-inline-block"><a href="#" class="message-btn">Messages<span class="msg-num">23</span></a></li>
                <li class="d-none d-lg-inline-block"><a href="#" class="notif-btn">Notifications<span class="msg-num">23</span></a></li>
                <li><a href="#" class="d-none d-md-block d-lg-none btn btn-white more_white mini h-40"></a></li>
            </ul>
        </nav>
    </div>
    <div class="d-flex flex-grow-1 align-items-center justify-content-end">
        <a href="#" class="d-none d-md-inline-block btn btn-success add_new mini h-40 mr-20"></a>
        <div class="dropdown">
            <img srcset="{{ URL::to('images/avatars/avatar-phot-small.jpg') }},
                                 {{ URL::to('images/avatars/avatar-phot-small@2x.jpg') }} 2x,
                                 {{ URL::to('images/avatars/avatar-phot-small@3x.jpg') }} 3x"
                 src="/images/img-logo.png" alt="{{ trans('metaTags.Go-Models') }}" class="avatar rounded-circle"/>
            <a href="#" class="d-none d-xl-inline-block myaccount">My account</a>
        </div>
    </div>
</header>