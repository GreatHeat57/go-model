@extends('emails.layouts.master_new')
@section('title', trans('offlinepayment::mail.payment_sent_title'))

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
                    {!! trans('offlinepayment::mail.payment_sent_content_1', ['title' => $post->title]) !!}
                    {!! trans('offlinepayment::mail.payment_sent_content_2') !!}
                    {!! trans('offlinepayment::mail.payment_sent_content_3', [
                        'adId'                     => $post->id,
                        'packageName'              => (!empty($package->short_name)) ? $package->short_name : $package->name,
                        'amount'                   => $package->price,
                        'currency'                 => $package->currency_code,
                        'paymentMethodDescription' => $paymentMethod->description
                        ]) !!}

                    @if($paymentMethod->id == '5')
                        {!! trans('offlinepayment::mail.payment_offline_account_details', [
                        'app_name'                     => config('app.app_name'),
                        'IBAN_NUMBER' => config('constant.IBAN_NUMBER'),
                        'BIC_NUMBER' =>  config('constant.BIC_NUMBER'),
                        'GO_CODE' => $post->user->profile->go_code
                        ]) !!}
                    @endif
                    {!! trans('offlinepayment::mail.payment_sent_content_4', ['appName' => config('app.name')]) !!}
                </p>
               
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" height="20"></td>
    </tr>
</table>
@endsection