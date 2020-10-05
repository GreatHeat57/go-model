@extends('emails.layouts.master_new')

@section('title', 'Maxmind DB udpate')

@section('content')
 <table border="0" cellpadding="0" cellspacing="0" class="container" style="width: 50%;">
    <tr>
        <td align="center" height="35"></td>
    </tr>

    <tr>
        <td align="center" valign="top" class="bodyContent" bgcolor="#ffffff">
            <div style="    color: #1f2b33; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 14px; line-height: 24px; letter-spacing: 0.3px;text-align: left;">

                <h2 style="display:block; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 18px; font-weight: bold;           line-height: 28px; padding-bottom: 0; margin-top:0; margin-right:0; margin-bottom: 0; margin-left:0; text-align:left;            color:#171717;">Go-Models</h2>
                <span class="divider" style="color: #b8c7f1; font-family: 'Trebuchet MS','Arial','Verdana'; font-weight: 700 !important;
            display: block;">―</span>


                <p style="margin: 0 0 20px; padding: 0; font-family: 'Trebuchet MS','Arial','Verdana';font-weight: 700 !important; display: block;">
                   <?php echo $subject; ?>
                </p>

            </div>
        </td>
    </tr>

    <tr>
        <td align="center" height="20"></td>
    </tr>
</table>
@endsection