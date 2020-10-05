@extends('emails.layouts.master_new')
@section('title', $msg->message)
@section('content')

<?php 
    $messageDetaiils = t('Error').' '.strtolower(t('Details'));
 ?>
<table border="0" cellpadding="0" cellspacing="0" class="container" style="width: 50%;">
    <tr>
        <td align="center" height="35"></td>
    </tr>
    <!-- content -->
    <tr>
        <td align="center" valign="top" class="bodyContent" bgcolor="#ffffff">
            <div style="color: #1f2b33; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 14px; line-height: 24px; letter-spacing: 0.3px;text-align: left;">
                <p style="margin: 0 0 10px; padding: 0;"> {{ t('Username') }}: {{ $msg->username }}</p>
                <p style="margin: 0 0 10px; padding: 0;"> {{ t('email') }}: {{ $msg->email }} </p>
                <p style="margin: 0 0 10px; padding: 0;"> {{ t('go-code') }}: {{ $msg->gocode }} </p>
                <?php  if(isset($msg->payment_method)){ ?>

                    <p style="margin: 0 0 10px; padding: 0;"> {{ t('Payment Method') }}: {{ $msg->payment_method }} </p>
                <?php } ?>
                
                <p style="margin: 0 0 10px; padding: 0;"> {{ $messageDetaiils }}: {{ $msg->messageDetails }}</p> 
            </div>
        </td>
    </tr>
</table>
@endsection
