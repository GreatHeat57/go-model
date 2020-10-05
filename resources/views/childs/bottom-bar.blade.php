<div class="bg-white box-shadow bottom-bar">
    <div class="d-flex justify-content-between justify-content-lg-center container px-0">

        @if(Auth::user()->user_type_id == config('constant.partner_type_id'))

        	<?php /* <a href="{{ lurl('account/my-posts') }}" class="btn btn-white jobs mini-mobile position-relative mr-20">{{ t('My ads') }}
                @if(isset($countMyPosts) && $countMyPosts > 0)
                    <?php if( $countMyPosts > config('app.num_counter') ){ ?>
                        <span class="msg-num">{{ config('app.num_counter').'+' }}</span>
                    <?php } else { ?>
                        <span class="msg-num">{{ $countMyPosts }}</span>
                    <?php } ?>
                @endif
            </a> */ ?>

            <?php $titleMyJob = t('My ads');
                if(isset($countMyPosts) && $countMyPosts > 0){
                   if( $countMyPosts > config('app.num_counter') ){
                        $titleMyJob .= "<span class='msg-num'>".config('app.num_counter').'+'."</span>";
                    } else {
                        $titleMyJob .= "<span class='msg-num'>$countMyPosts</span>";
                    }
                }
            ?>
            {!! App\Helpers\CommonHelper::createLink('my_jobs', $titleMyJob, lurl('account/my-posts'), 'btn btn-white jobs mini-mobile position-relative mr-20', '','','') !!}

		@endif
        
        @if(Auth::user()->user_type_id == config('constant.model_type_id'))

            <?php /*
            <a href="{{ lurl(trans('routes.job-applied')) }}" class="btn btn-white jobs mini-mobile position-relative mr-20">{{ t('Jobs Applied') }}
                @if(isset($appliedJobs) && $appliedJobs > 0)
                   <?php if( $appliedJobs > config('app.num_counter') ){ ?>
                        <span class="msg-num">{{ config('app.num_counter').'+' }}</span>
                    <?php } else { ?>
                        <span class="msg-num">{{ $appliedJobs }}</span>
                    <?php } ?>
                @endif
            </a>
            */ ?>
            
            <?php $titleJobAp = t('Jobs Applied');
                if(isset($appliedJobs) && $appliedJobs > 0){
                   if( $appliedJobs > config('app.num_counter') ){
                        $titleJobAp .= "<span class='msg-num'>".config('app.num_counter').'+'."</span>";
                    } else {
                        $titleJobAp .= "<span class='msg-num'>$appliedJobs</span>";
                    }
                }
            ?>
            {!! App\Helpers\CommonHelper::createLink('view_jobs', $titleJobAp, lurl(trans('routes.job-applied')), 'btn btn-white jobs mini-mobile position-relative mr-20', '','','') !!}

        @endif

            <?php /*
            <a href="{{ lurl(trans('routes.messages')) }}" class="btn btn-white message mini-mobile position-relative mr-20">{{ t('Messages') }}
            	@if(auth()->check())
                    @if(isset($unreadMessages) && $unreadMessages > 0 )
                        <?php if( $unreadMessages > config('app.num_counter') ){ ?>
                            <span class="msg-num">{{ config('app.num_counter').'+' }}</span>
                        <?php } else { ?>
                            <span class="msg-num">{{ $unreadMessages }}</span>
                        <?php } ?>
                    @endif
            	@endif
           	</a>
            */ ?>

            <?php $titleMsg = t('Messages');
                if(isset($unreadMessages) && $unreadMessages > 0){
                    if( $unreadMessages > config('app.num_counter') ){
                        $titleMsg .= "<span class='msg-num'>".config('app.num_counter').'+'."</span>";
                    } else {
                        $titleMsg .= "<span class='msg-num'>$unreadMessages</span>";
                    }
                }
            ?>
            {!! App\Helpers\CommonHelper::createLink('list_messages', $titleMsg, lurl(trans('routes.messages')), 'btn btn-white message mini-mobile position-relative mr-20', '','','') !!}

       

       <?php /*
        <a href="{{ lurl(trans('routes.notifications', ['countryCode' => config('country.icode')])) }}" class="btn btn-white notifications mini-mobile position-relative ">{{ t('Invitations') }}
            @if(isset($totalInvitations) && $totalInvitations > 0)
                <?php if( $totalInvitations > config('app.num_counter') ){ ?>
                    <span class="msg-num num-invited">{{ config('app.num_counter').'+' }}</span>
                <?php } else { ?>
                    <span class="msg-num num-invited">{{ $totalInvitations }}</span>
                <?php } ?>
            @endif
        </a> */ ?>

        <?php $titleInt = t('Invitations');
                if(isset($totalInvitations) && $totalInvitations > 0){
                    if($totalInvitations > config('app.num_counter') ){
                        $titleInt .= "<span class='msg-num num-invited'>".config('app.num_counter').'+'."</span>";
                    } else {
                        $titleInt .= "<span class='msg-num num-invited'>$totalInvitations</span>";
                    }
                }
            ?>
        {!! App\Helpers\CommonHelper::createLink('list_invitations', $titleInt, lurl(trans('routes.notifications', ['countryCode' => config('country.icode')])), 'btn btn-white notifications mini-mobile position-relative', '','','') !!}

       
    </div>
</div>
