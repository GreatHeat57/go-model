@extends('emails.layouts.master_new')

@section('title', trans('mail.error_subject', ['appName' => config('app.name')]))

@section('content')
 <table border="0" cellpadding="0" cellspacing="0" class="container" style="width: 100%;">
    <tr>
        <td align="center" height="35"></td>
    </tr>
    <?php $defaultErrorMessage = t('Meanwhile, you may :url return to homepage', ['url' => url('/')]); ?>
    <tr>
        <td align="center" valign="top" class="bodyContent" bgcolor="#ffffff">
            <div style="  color: #1f2b33; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 14px; line-height: 24px; letter-spacing: 0.3px;text-align: center;">

                <p style="margin: 0 0 20px; padding: 0; font-family: 'Trebuchet MS','Arial','Verdana';font-weight: 700 !important; display: block; color: #e40909; font-size: 30px;">
                   {{  isset($ErrorCode) ? $ErrorCode : "" }}
                </p>

                <p style="margin: 0 0 20px; padding: 0; font-family: 'Trebuchet MS','Arial','Verdana';font-weight: 700 !important; display: block; color: #e40909; font-size: 20px;">
                   {{ $error }}
                </p>
               
                <p style="margin: 0 0 20px; padding: 0; font-family: 'Trebuchet MS','Arial','Verdana';font-weight: 700 !important; display: block; text-align: center;  font-size: 20px; color: #e40909;">{!! isset($url) ? $url : "" !!}</p>
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" height="20"></td>
    </tr>
</table>
@endsection