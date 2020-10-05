@extends('emails.layouts.master_new')

@section('title', trans('mail.contact_form_title', [
                    'country' => $msg->country,
                    'appName' => config('app.name')
                ]))

@section('content')
 <table border="0" cellpadding="0" cellspacing="0" class="container" style="width: 50%;">
    <tr>
        <td align="center" height="35"></td>
    </tr>

    <tr>
        <td align="center" valign="top" class="bodyContent" bgcolor="#ffffff">
            <div style=" color:#1f2b33;font-family:'Trebuchet MS', Arial, Verdana;font-size:14px;line-height:24px;letter-spacing:.3px;text-align:left;width: 650px;">

                <h2 style="display:block; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 18px; font-weight: bold; line-height: 28px; padding-bottom: 0; margin-top:0; margin-right:0; margin-bottom: 0; margin-left:0; text-align:left;color:#171717;"></h2>
                

                <p style="margin: 0 0 20px; padding: 0; font-family: 'Trebuchet MS','Arial','Verdana';font-weight: 700 !important; display: block;">
                  {{ t('Country') }}: <a href="{{ lurl('/?d=' . $msg->country_code) }}">{{ $msg->country }}</a>
                  <br />
                  {{ t('Name') }}: {{ $msg->first_name }}
                  <br />
                  {{ t('Email Address') }} : {{ $msg->email }}{!! (isset($msg->phone) and $msg->phone!='') ? '<br>' . t('Phone') . ' : ' . $msg->phone : '' !!}{!! (isset($msg->company_name) and $msg->company_name!='') ? '<br>' . t('Company Name') . ' : ' . $msg->company_name : '' !!}<br><br>{!! nl2br($msg->message) !!}
                </p>
               
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" height="20"></td>
    </tr>
</table>
@endsection