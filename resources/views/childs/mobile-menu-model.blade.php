<div class="wrapper wrapper-left">
    <div class="mobile-menu">
        <ul>
            <?php $attr = ['countryCode' => config('country.icode')];?>
            
            <li class="main">{{ t('menu') }}</li>
            
            <li>
                <a href="{{ lurl(trans('routes.model-dashboard', $attr), $attr) }}">{{ t('Dashboard') }}</a>
            </li>
            
            <li>
                <a href="{{ lurl(trans('routes.social', $attr), $attr) }}">{{t('Social')}}</a>
            </li>
            @if (!auth()->check() )
            <li>
                <a href="{{ lurl(trans('routes.user')) }}">{{t('Become a Model')}}</a>
            </li>
            @endif
            <li>
                <?php /*<a href="{{ lurl(trans('routes.search', $attr), $attr) }}">{{ t('Jobs') }}</a> */ ?>
                {!! App\Helpers\CommonHelper::createLink('list_jobs', t('Jobs'), lurl(trans('routes.search', $attr), $attr), '', '','','') !!}
            </li>
            <li>
               <a href="{{ lurl(trans('routes.magazine')) }}">{{ t('magazine') }}</a>
            </li>

            <?php /* <li><a href="{{ URL('account/my-posts') }}">My jobs</a></li> */ ?>
            
            <li>
                <?php $titlemsg = t('Messages'); ?> 
                <?php 
                    // if(isset($unreadMessages) && $unreadMessages > 0){
                    //     if( $unreadMessages > config('app.num_counter') ){
                    //         $titlemsg .= " <span class='msg-num in-mobile-menu'>".config('app.num_counter').'+'."</span>";
                    //     } else {
                    //         $titlemsg .= " <span class='msg-num in-mobile-menu'>$unreadMessages</span>";
                    //     }
                    // }
                ?>
                

                <?php /*             
                <a href="{{ lurl(trans('routes.messages', $attr), $attr) }}" class="position-relative">{{ t('Messages') }}
                    @if(isset($unreadMessages) && $unreadMessages > 0)
                        <?php if( $unreadMessages > config('app.num_counter') ){ ?>
                            <span class="msg-num in-mobile-menu">{{ config('app.num_counter').'+' }}</span>
                        <?php } else { ?>
                            <span class="msg-num in-mobile-menu">{{ $unreadMessages }}</span>
                        <?php } ?>
                    @endif
                </a> */?>

                {!! App\Helpers\CommonHelper::createLink('list_messages', $titlemsg, lurl(trans('routes.messages', $attr), $attr), 'position-relative message-lbl', '','','') !!}

            </li>

            <li>

                <?php $titleIvt = t('Invitations'); ?> 
                <?php 
                    // if(isset($totalInvitations) && $totalInvitations > 0){
                    //     if( $totalInvitations > config('app.num_counter') ){
                    //         $titleIvt .= " <span class='msg-num in-mobile-menu num-invited'>".config('app.num_counter').'+'."</span>";
                    //     } else {
                    //         $titleIvt .= " <span class='msg-num in-mobile-menu num-invited'>$totalInvitations</span>";
                    //     }
                    // }
                ?>
                
                <?php /*             
                <a href="{{ lurl(trans('routes.notifications', $attr), $attr) }}" class="f-15 position-relative">{{ t('Invitations') }}
                    @if(isset($totalInvitations) && $totalInvitations > 0)

                        <?php if( $totalInvitations > config('app.num_counter') ){ ?>
                            <span class="msg-num in-mobile-menu num-invited">{{ config('app.num_counter').'+' }}</span>
                        <?php } else { ?>
                            <span class="msg-num in-mobile-menu num-invited">{{ $totalInvitations }}</span>
                        <?php } ?>

                    @endif
                </a> */?>

                {!! App\Helpers\CommonHelper::createLink('list_invitations', $titleIvt, lurl(trans('routes.notifications', $attr), $attr), 'f-15 position-relative inviation-lbl', '','','') !!}

            </li>
            
            @if(Gate::check('show_premium_button', \Auth::user()))
            <div class="justify-content-center align-items-center container px-0 pt-20 mt-10 btn">
                <a data-toggle="modal" data-target="#go-premium" class="btn btn-white star-bk go-premium-button mobile-pre" title="{{ t('premium_btn') }}"> {{t('premium_btn')}} </a>
            </div>
            @endif
            


            <?php /* <li><a href="{{ lurl(trans('routes.notifications', $attr), $attr) }}" class="position-relative">{{t('news')}}<span class="msg-num in-mobile-menu">23</span></a></li> */ ?>
            <?php /*
            <!-- Start comment code 26/08/2019 model profile menu -->
            <li class="main">{{ ucWords(t('My account')) }}</li>
            
            <li>
                <a href="{{ lurl(trans('routes.user')) }}">{{ t('My profile') }}</a>
            </li>
             
            
            <li>
                <a href="{{ lurl(trans('routes.model-sedcard-edit', $attr), $attr) }}">{{ t('My Sedcard') }}</a>
            </li>
            
            <li>
                <a href="{{ lurl(trans('routes.model-portfolio-edit', $attr), $attr) }}">{{ t('My Model Book') }}</a>
            </li>
            
            
            <li>
                <a href="{{ lurl(trans('routes.my-data', $attr), $attr) }}">{{ t('My Data') }}</a>
            </li>
            <li>
                <a href="{{ lurl(trans('routes.work-settings', $attr), $attr) }}">{{ t('Work Settings') }}</a>
            </li>
            
            <li>
                <a href="{{ lurl(trans('routes.job-applied', $attr), $attr) }}">{{ t('Jobs Applied') }} </a>
            </li>

            <li>
                <a href="{{ lurl(trans('routes.search').'/favourites') }}">{{ t('Favorite jobs') }} </a>
            </li>

            <li>
                <a href="{{ lurl(trans('routes.partner-list-favourites', $attr), $attr) }}">{{ t('Favorite partner') }} </a>
            </li>

            <li>
                <a href="{{ lurl(trans('routes.change-password', $attr), $attr) }}">{{ t('Change Password') }}</a>
            </li>
            
            <!-- <li><a href="#">Help center</a></li> -->
            <li class="log-out">
                <a href="{{ lurl(trans('routes.logout')) }}">{{ ucWords(t('Log out')) }}</a>
            </li>

            <!-- End comment code 26/08/2019 model profile menu -->
            <?php */ ?>
        </ul>
    </div>
</div>