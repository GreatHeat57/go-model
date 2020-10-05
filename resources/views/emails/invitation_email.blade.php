@extends('emails.layouts.master_new')

@section('title', trans('mail.invitation'))

@section('content')
 <table border="0" cellpadding="0" cellspacing="0" class="container" style="width: 50%;">
    <tr>
        <td align="center" height="35"></td>
    </tr>

    <tr>
        <td align="center" valign="top" class="bodyContent" bgcolor="#ffffff">
            <div style=" color:#1f2b33;font-family:'Trebuchet MS', Arial, Verdana;font-size:14px;line-height:24px;letter-spacing:.3px;text-align:left;width: 650px;">

                <h2 style="display:block; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 18px; font-weight: bold; line-height: 28px; padding-bottom: 0; margin-top:0; margin-right:0; margin-bottom: 0; margin-left:0; text-align:left;color:#171717;">@lang('mail.Hello') {{ $data['model_name'] }},</h2>
                <span class="divider" style="color: #b8c7f1; font-family: 'Trebuchet MS','Arial','Verdana'; font-weight: 700 !important;
            display: block;">―</span>

                <p style="margin: 0 0 20px; padding: 0; font-family: 'Trebuchet MS','Arial','Verdana';font-weight: 700 !important; display: block;">
                  {{ $data['partner_name'] }}</b> @lang('mail.Invited to you for the job'): "<b>{{ $data['job_name'] }}<b>"
                </p>

                @php $message=$data['messageid']; @endphp

                <?php /*
                <p style="margin: 0 0 20px; padding: 0;">
                    <a style="display: inline-block; background: #06c67b; color: white; text-decoration: none; font-weight: 700; padding: 8px 10px;" href="{{ url('/account/conversations/'.$message.'/messages') }}" class="btn">@lang('mail.view message')</a>
                </p>
                <?php */ ?>

                <?php $attr = ['countryCode' => config('country.icode')];?>

                <p style="margin: 0 0 20px; padding: 0;">
                    <a style="display: inline-block; background: #06c67b; color: white; text-decoration: none; font-weight: 700; padding: 8px 10px;" href="{{ lurl(trans('routes.notifications', $attr), $attr) }}" class="btn">{{ t('invitations') }}</a>
                </p>

                <p style="margin: 0 0 20px; padding: 0;">
                    @lang('mail.Click here to :accept or :reject the invitation', ['accept' => $data['accept_url'], 'reject' => $data['reject_url']])
                </p>
               
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" height="20"></td>
    </tr>
</table>
@endsection