<?php $attr = ['countryCode' => config('country.icode')];?>
<div class="wrapper wrapper-right">
    <div class="mobile-menu">
        <ul>
        	<li class="main">{{ ucWords(t('My account')) }}</li>
            
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
        </ul>
    </div>
</div>