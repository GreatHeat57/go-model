        @if(Session::has('success'))
            @if (session('success') != '')
                @if (!(isset($paddingTopExists) and $paddingTopExists))
                    <div class="h-spacer"></div>
                @endif
                <?php $paddingTopExists = true;?>
                <div class="container no-padding no-margin">
                    <div class="row">
                        <div class="alert alert-success home-message position-absolute">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif
        @endif

        @if(Session::has('message'))
            @if(session('message') != '')
                @if (!(isset($paddingTopExists) and $paddingTopExists))
                    <div class="h-spacer"></div>
                @endif
                <?php $paddingTopExists = true;?>
                <div class="container no-padding no-margin">
                    <div class="row">
                        <div class="alert alert-danger home-message position-absolute">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            {{ session('message') }}
                        </div>
                    </div>
                </div>
            @endif   
        @endif

        @if(Session::has('flash_notification'))
            @if(session('flash_notification') != '')
                @if (!(isset($paddingTopExists) and $paddingTopExists))
                    <div class="h-spacer"></div>
                @endif
                <?php $paddingTopExists = true;?>
                <div class="container no-padding no-margin">
                    <div class="row">
                        <div class="home-message position-absolute">
                            @include('flash::message')
                        </div>
                    </div>
                </div>
            @endif    
        @endif