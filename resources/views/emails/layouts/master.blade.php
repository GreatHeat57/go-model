<!-- Inliner Build Version 4380b7741bb759d6cb997545f3add21ad48f010b -->
<!DOCTYPE html>
<html style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0;">
<head>
@include('emails.layouts.inc.header')
</head>
<body bgcolor="#f6f6f6" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; -webkit-font-smoothing: antialiased; height: 100%; -webkit-text-size-adjust: none; width: 100% !important; margin: 0; padding: 0;">
<div dir="ltr" id="wrapper" style="background-color: #d2dff3; margin: 0; padding: 0; -webkit-text-size-adjust: none !important; width: 100%;">
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="padding-top: 50px; padding-bottom: 50px;">
    <tbody>
        <tr>
            <td align="center" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" id="template_container" style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; background-color: #fdfdfd; border: 1px solid #dcdcdc; border-radius: 3px !important; width: 100%; max-width: 600px;">
                <tbody>
                    <tr>
                        <td align="center" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background: #fff">
                    <tr>
                        <td align="center" height="50">
                            <img src="https://static.go-models.com/newsletter/images/go-models-logo.png"
                                 srcset="https://static.go-models.com/newsletter/images/go-models-logo@2x.png 2x,
                                         https://static.go-models.com/newsletter/images/email/go-models-logo@3x.png 3x"
                                 alt="{{ trans('metaTags.Go-Models') }}" />
                        </td>
                    </tr>

                    
                </table>

                        <table border="0" cellpadding="0" cellspacing="0" id="template_header" style="background-color: #121428; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: Verdana, Geneva, sans-serif; max-width: 600px; width: 100%;">
                            <tbody>
                                <tr>
                                    <td id="header_wrapper" style="padding: 10px 48px; display: block; background-color: #a38446;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- body -->
                        @yield('content')
                        <!-- /body -->

                        <!-- footer -->
                        @include('emails.layouts.inc.footer')
                        <!-- /footer -->

                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>
</div>
</body>
</html>