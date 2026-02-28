<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <!-- Card -->
                <table width="500" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px; padding:40px; box-shadow:0 5px 15px rgba(0,0,0,0.05);">

                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <h2 style="margin:0; color:#333;">Reset Your Password</h2>
                        </td>
                    </tr>

                    <tr>
                        <td style="color:#555; font-size:15px; line-height:1.6;">
                            Hello,<br><br>
                            We received a request to reset your password.
                            Click the button below to create a new password.
                            This link will expire in 60 minutes.
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:30px 0;">
                            <a href="{{ $url }}"
                               style="background-color:#4f46e5;
                                      color:#ffffff;
                                      padding:12px 25px;
                                      text-decoration:none;
                                      border-radius:5px;
                                      font-size:15px;
                                      display:inline-block;">
                                Reset Password
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td style="color:#888; font-size:13px;">
                            If you did not request a password reset, no further action is required.
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:30px; font-size:12px; color:#aaa;">
                            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>

                </table>
                <!-- End Card -->

            </td>
        </tr>
    </table>

</body>
</html>