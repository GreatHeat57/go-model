@extends('emails.layouts.master_new')

@section('title', trans('mail.reset_password_title'))

@section('content')
 <table border="0" cellpadding="0" cellspacing="0" class="container" style="width: 50%;">
    <tr>
        <td align="center" height="35"></td>
    </tr>

    <tr>
        <td align="center" valign="top" class="bodyContent" bgcolor="#ffffff">
            <div style="    color: #1f2b33; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 14px; line-height: 24px; letter-spacing: 0.3px;text-align: left;">

                <h2 style="display:block; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 18px; font-weight: bold;           line-height: 28px; padding-bottom: 0; margin-top:0; margin-right:0; margin-bottom: 0; margin-left:0; text-align:left;            color:#171717;">@lang('mail.reset_password_content_1')</h2>
                <span class="divider" style="color: #b8c7f1; font-family: 'Trebuchet MS','Arial','Verdana'; font-weight: 700 !important;
            display: block;">―</span>


                <p style="margin: 0 0 20px; padding: 0; font-family: 'Trebuchet MS','Arial','Verdana';font-weight: 700 !important; display: block;">
                   @lang('mail.reset_password_content_3')
                </p>

                <p style="margin: 0 0 10px; padding: 0;">
                    <a style="display: inline-block; background: #06c67b; color: white; text-decoration: none; font-weight: 700; padding: 8px 10px;" href="{{ lurl(trans('routes.password-reset').'/'.$token) }}" class="btn" rel="nofollow">
                    @lang('mail.reset_password_action')</a>
                </p>

                @lang('mail.reset_password_content_5', ['link' => lurl(trans('routes.password-reset').'/'.$token)])
                @lang('mail.reset_password_content_4', ['appName' => config('app.name')])
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" height="20"></td>
    </tr>
</table>
@endsection