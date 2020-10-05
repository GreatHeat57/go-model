@extends('emails.layouts.master_new')

@section('title', trans('mail.email_verification_title', ['appName' => config('app.name')]))

@section('content')
 <table border="0" cellpadding="0" cellspacing="0" class="container" style="width: 50%;">
    <tr>
        <td align="center" height="35"></td>
    </tr>

    <tr>
        <td align="center" valign="top" class="bodyContent" bgcolor="#ffffff">
            <div style="    color: #1f2b33; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 14px; line-height: 24px; letter-spacing: 0.3px;text-align: left;">

                <h2 style="display:block; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 18px; font-weight: bold;           line-height: 28px; padding-bottom: 0; margin-top:0; margin-right:0; margin-bottom: 0; margin-left:0; text-align:left;            color:#171717;">@lang('mail.email_verification_content_1', ['userName' => $entity->{$entityRef['name']}])</h2>
                <span class="divider" style="color: #b8c7f1; font-family: 'Trebuchet MS','Arial','Verdana'; font-weight: 700 !important;
            display: block;">―</span>

                <p style="margin: 0 0 20px; padding: 0; font-family: 'Trebuchet MS','Arial','Verdana';font-weight: 700 !important; display: block;">
                   @lang('mail.email_verification_content_2')
                </p>

                <?php $url =  config('app.url').'/'.config('app.locale').'/verify/'.$entityRef['slug'].'/email/'.$entity->email_token; ?>

                <p style="margin: 0 0 20px; padding: 0;">
                    <a style="display: inline-block; background: #06c67b; color: white; text-decoration: none; font-weight: 700; padding: 8px 10px;" href="{{ $url }}" class="btn">@lang('mail.email_verification_action')</a>
                </p>

                <p style="margin: 0 0 20px; padding: 0;">
                    @lang('mail.email_verification_content_3', ['verificationLink' => $url])
                </p>
                
                <p style="margin: 0 0 20px; padding: 0;">@lang('mail.email_verification_content_4', ['appName' => config('app.name')])</p>
                <p style="margin: 0 0 20px; padding: 0;">@lang('mail.email_verification_content_5', ['appName' => config('app.name')])</p>
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" height="20"></td>
    </tr>
</table>
@endsection