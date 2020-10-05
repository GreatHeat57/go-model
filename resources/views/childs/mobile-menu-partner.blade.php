<div class="wrapper wrapper-left ">
    <div class="mobile-menu">
        <ul>
            <?php $attr = ['countryCode' => config('country.icode')];?>
            <div class="text-center d-sm-none mb-20">
                <a href="{{ lurl(trans('routes.post-create')) }}" class="btn btn-success add_new">{{ t('Post a new job') }}</a>
            </div>
            
            <li class="main">{{ t('menu') }}</li>
            
            <li>
                <a href="{{ lurl(trans('routes.partner-dashboard', $attr), $attr) }}">{{ t('Dashboard') }}</a>
            </li>
            
            <li>
                <a href="{{ lurl(trans('routes.social', $attr), $attr) }}">{{ t('Social') }}</a>
            </li>
            @if (!auth()->check() )
            <li>
                <a href="{{ lurl(trans('routes.user')) }}">{{t('Become a Model')}}</a>
            </li>
            @endif
            <li>
                <a href="{{ lurl(trans('routes.model-list', $attr), $attr) }}">{{ t('Find model') }}</a>
            </li>
            <li>
                <a href="{{ lurl(trans('routes.search', $attr), $attr) }}">{{ t('Jobs') }}</a>
            </li>
            <li>
                <a href="{{ lurl(trans('routes.magazine')) }}">{{t('magazine')}}</a>
            </li>
            <?php /*
           <!--  <li>
                <a href="{{ lurl('account/my-posts') }}">{{ ucWords(t('Posted jobs')) }}</a>
            </li> -->
            
            <!-- <li><a href="#" class="position-relative">My jobs<span class="msg-num in-mobile-menu">23</span></a></li> --> */ ?>
            
            <li>
                
                <a href="{{ lurl(trans('routes.messages', $attr), $attr) }}" class="position-relative message-lbl" title="{{t('Messages')}}">{{ t('Messages') }}
                    @if(isset($unreadMessages) && $unreadMessages > 0)

                        <?php /* if( $unreadMessages > config('app.num_counter') ){ ?>
                            <span class="msg-num in-mobile-menu">{{ config('app.num_counter').'+' }}</span>
                        <?php } else { ?>
                            <span class="msg-num in-mobile-menu">{{ $unreadMessages }}</span>
                        <?php } */ ?>

                    @endif
                </a>

            </li>
            <li>
                <a href="{{ lurl(trans('routes.notifications', $attr), $attr) }}" class="f-15 position-relative inviation-lbl">{{ t('Invitations') }}
                    @if(isset($totalInvitations) && $totalInvitations > 0)

                        <?php /* if( $totalInvitations > config('app.num_counter') ){ ?>
                            <span class="msg-num in-mobile-menu num-invited">{{ config('app.num_counter').'+' }}</span>
                        <?php } else { ?>
                            <span class="msg-num in-mobile-menu num-invited">{{ $totalInvitations }}</span>
                        <?php } */ ?>

                    @endif
                </a>

            </li>
            <?php /*
            
            <li class="main">{{ ucWords(t('My account')) }}</li>
            
            <?php //$partner_url = lurl(trans('routes.user').'/'.Auth::user()->username); ?>
            
            <li>
                <a href="{{ lurl(trans('routes.user')) }}">{{ t('My profile') }}</a>
            </li>
             
            
            <li>
                <a href="{{ lurl(trans('routes.account-album', $attr), $attr) }}">{{ ucWords(t('My albums')) }}</a>
            </li>
             
            <li>
                <a href="{{ lurl(trans('routes.account-companies', $attr), $attr) }}">{{ ucWords(t('My companies')) }}</a>
            </li>

             

            <li>
                <a href="{{ lurl('account/my-posts') }}">{{ ucWords(t('My ads')) }}</a>
            </li>
             
            <li>
                <a href="{{ lurl('account/archived') }}">{{ ucWords(t('Archived ads')) }} </a>
            </li>

            <li>
                <a href="{{ lurl(trans('routes.job-applied', $attr), $attr) }}">{{ t('Jobs Applied') }} </a>
            </li>

            <li>
                <a href="{{ lurl(trans('routes.search').'/favourites') }}">{{ t('Favorite jobs') }}</a>
            </li>

            <li>
                <a href="{{ lurl(trans('routes.model-list').'/favourites') }}">{{ t('Favorite models') }}</a>
            </li>

            <li>
                <a href="{{ lurl(trans('routes.change-password', $attr), $attr) }}">{{ t('Change Password') }}</a>
            </li>
            
            
            <li class="log-out">
                <a href="{{ lurl(trans('routes.logout', $attr), $attr) }}">{{ ucWords(t('Log out')) }}</a>
            </li>
            <?php */ ?>
        </ul>
    </div>
</div>