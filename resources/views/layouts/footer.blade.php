<footer>
    <?php /*
    <!-- <div class="follow-us">
        <div class="inner">
            <h2>{{ trans('frontPage.lbl_follow_us') }}</h2>
            <ul>
                <li><a target="_blank" href="{{ config('app.go_model_facebook') }}" class="facebook">Facebook</a></li>
                <li><a target="_blank" href="{{ config('app.go_model_instagram') }}" class="instagram">Instagram</a></li>
                <li><a target="_blank" href="{{ config('app.go_model_twiiter') }}" class="twitter">Twitter</a></li>
                <li><a target="_blank" href="{{ config('app.go_model_youtube') }}" class="youtube">Youtube</a></li>
            </ul>
        </div>
    </div> -->
    */ ?>

    <?php 
        $show_follow_us = true;
        if(isset($is_footer_showing)){
            
            if($is_footer_showing == false){
                
                $show_follow_us = false;
            }
        }
        if($show_follow_us == true){
    ?>
    @include('childs.follow-us')
    <?php } ?>
    @include('childs.process_loader')
    
    <?php if($show_follow_us == true){ ?>
        @include('childs.footer')
    <?php } ?>
</footer>