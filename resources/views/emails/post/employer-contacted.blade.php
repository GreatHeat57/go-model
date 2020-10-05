@extends('emails.layouts.master_new')

@section('title', trans('mail.post_employer_contacted_title', ['title' => $post->title, 'appName' => config('app.name')]))


@section('content')
 <table border="0" cellpadding="0" cellspacing="0" class="container" style="width: 50%;">
    <tr>
        <td align="center" height="35"></td>
    </tr>

    <tr>
        <td align="center" valign="top" class="bodyContent" bgcolor="#ffffff">
            <div style=" color:#1f2b33;font-family:'Trebuchet MS', Arial, Verdana;font-size:14px;line-height:24px;letter-spacing:.3px;text-align:left;width: 650px;">
                <h2 style="display:block; font-family: 'Trebuchet MS','Arial','Verdana'; font-size: 18px; font-weight: bold; line-height: 28px; padding-bottom: 0; margin-top:0; margin-right:0; margin-bottom: 0; margin-left:0; text-align:left;color:#171717;"></h2>
                
                @lang('mail.post_employer_contacted_content_7', [ 'title' => mb_ucfirst($post->title)])


                <p>@lang('mail.post_employer_contacted_intro', ['client' => $msg->to_name]) {!! nl2br($msg->message) !!}</p>

                @if($msg->filename != '')
                <p>@lang('mail.post_employer_contacted_content_image', [
                        'imageUrl'  => lurl($msg->filename)
                    ])</p>
                @endif

               
                @lang('mail.post_employer_contacted_content_1', [
                    'name'      => $msg->from_name,
                    'email'     => $msg->from_email,
                    'phone'     => $msg->from_phone,
                    'title'     => mb_ucfirst($post->title),
                    'postUrl'   => lurl($post->uri),
                    'appUrl'    => lurl('/'),
                    'appName'   => config('app.name')
                ])

                @if($user->user_type_id == config('constant.model_type_id'))
                    @lang('mail.post_employer_contacted_content_3', [
                        'postUrl'   => lurl($post->uri),
                        'profileUrl'  => lurl(trans('routes.user').'/'.$user->username),
                        
                    ])
                @else
                    @lang('mail.post_employer_contacted_content_8', [
                        'postUrl'   => lurl($post->uri),
                        'profileUrl'  => lurl(trans('routes.user').'/'.$user->username),
                        
                    ])
                @endif

                @lang('mail.post_employer_contacted_content_reply', [
                    'msgUrl'  => lurl('account/conversations/' . $msg->parent_id . '/messages')
                ])

                @lang('mail.post_employer_contacted_content_2')

                @lang('mail.post_employer_contacted_content_4')
                
                @lang('mail.post_employer_contacted_content_5', [
                        'appUrl'  => lurl('/'),
                        'appName' => config('app.name')
                    ])
                
                @lang('mail.post_employer_contacted_content_6')
               
            </div>
        </td>
    </tr>

    <tr>
        <td align="center" height="20"></td>
    </tr>
</table>
@endsection