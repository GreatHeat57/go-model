<?php $attr = ['countryCode' => config('country.icode')];?>
<div class="wrapper wrapper-right">
    <div class="mobile-menu">
        <ul>
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
                <?php /* <a href="{{ lurl(trans('routes.job-applied', $attr), $attr) }}">{{ t('Jobs Applied') }} </a> */ ?>
                {!! App\Helpers\CommonHelper::createLink('applied_jobs', t('Jobs Applied'), lurl(trans('routes.job-applied', $attr), $attr), '', '','','') !!}
            </li>

            <li>
                <?php /* <a href="{{ lurl(trans('routes.search').'/favourites') }}">{{ t('Favorite jobs') }} </a> */ ?>
                {!! App\Helpers\CommonHelper::createLink('list_jobs', t('Favorite jobs'), lurl(trans('routes.search').'/favourites'), '', '','','') !!}
            </li>

            <li>
                <?php /* <a href="{{ lurl(trans('routes.partner-list', $attr), $attr) }}">{{ t('Partners List') }}</a> */ ?>
                {!! App\Helpers\CommonHelper::createLink('list_partner', t('Partners List'), lurl(trans('routes.partner-list', $attr), $attr), '', '','','') !!}
            </li>

            <li>
                <?php /* <a href="{{ lurl(trans('routes.partner-list-favourites', $attr), $attr) }}">{{ t('Favorite partner') }} </a> */ ?>
                {!! App\Helpers\CommonHelper::createLink('list_partner', t('Favorite partner'), lurl(trans('routes.partner-list-favourites', $attr), $attr), '', '','','') !!}
            </li>

            <li>
                <a href="{{ lurl(trans('routes.change-password', $attr), $attr) }}">{{ t('Change Password') }}</a>
            </li>
            
            <li class="log-out">
                <a href="{{ lurl(trans('routes.logout')) }}">{{ ucWords(t('Log out')) }}</a>
            </li>
        </ul>
    </div>
</div>
