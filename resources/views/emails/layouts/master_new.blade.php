<!DOCTYPE html>
<html>
<head>
   @include('emails.layouts.inc.header_new')
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" bgcolor="#f0efef" color="#333" style="color: #4E4E4E; font-family: Arial, Tahoma, Verdana; font-size:13px; line-height:140%;">
<center>
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="backgroundTable" style="font-family: 'Trebuchet MS','Arial','Verdana';font-size: 14px;line-height: 24px; letter-spacing: 0.3px;background-color:#ffffff;color:#171717; height:100% !important;
            margin:0;padding:0;width:100% !important;" bgcolor="#f0efef">
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
                    <tr>
                        <td align="center" style="background: #f1f6fa;padding: 30px 10px;border-collapse: collapse">
                          <h1 style="color: #171717;display: block;font-family: &quot;Palatino Linotype&quot;, &quot;Book Antiqua&quot;, Palatino, serif;font-size: 20px;font-weight: 400;line-height: 110%;margin: 0 0 5px;padding: 0">@yield('title')
                          </h1>
                          <span class="divider" style="color: #b8c7f1;font-family: &quot;Trebuchet MS&quot;, &quot;Arial&quot;, &quot;Verdana&quot;;font-weight: 700 !important;display: block">―
                          </span>
                        </td>
                    </tr>
                    <!-- body -->
                    @yield('title-header')
                </table>
                <!-- body -->
                @yield('content')
                <!-- /body -->

                <!-- footer -->
                @include('emails.layouts.inc.footer_new')
                <!-- /footer -->
            </td>
        </tr>
    </table>
</center>
</body>
</html>