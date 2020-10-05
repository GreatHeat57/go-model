@extends('emails.layouts.master_new')
@section('title', trans('mail.post_report_sent_title', ['appName' => config('app.name'), 'countryCode' => config('country.code')]))

@section('content')
<table border="0" cellpadding="0" cellspacing="0" class="container" style="width: 50%;">
    <tr>
        <td align="center" height="35"></td>
    </tr>

    <tr>
        <td align="center" valign="top" class="bodyContent" bgcolor="#ffffff">
            <div style="    color: #1f2b33; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 14px; line-height: 24px; letter-spacing: 0.3px;text-align: left;">

                <p style="margin: 0 0 20px; padding: 0;">{{ trans('mail.Post URL') }} :
                    <a style="display: inline-block; text-decoration: none; font-weight: 700; padding: 8px 10px;" href="{{ lurl($post->uri) }}" class="btn">{{ lurl($post->uri) }}</a>
                </p>

                <p style="margin: 0 0 20px; padding: 0;">{!! nl2br($report->message) !!}</p>

            </div>
        </td>
    </tr>

    <tr>
        <td align="center" height="20"></td>
    </tr>
</table>
@endsection
