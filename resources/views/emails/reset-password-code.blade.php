<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset Code</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f2ef; font-family: Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f2ef; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.08);">

                    <tr>
                        <td style="background-color:#16A249; padding:24px 32px;">
                            <span style="color:#ffffff; font-size:18px; font-weight:600; letter-spacing:0.5px;">
                                A We Green Enterprise
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:32px;">
                            <h2 style="margin:0 0 12px; color:#212529; font-size:20px;">Reset your password</h2>
                            <p style="margin:0 0 24px; color:#495057; font-size:14px; line-height:1.6;">
                                We received a request to reset the password for your account. Use the code below to continue. This code expires in 15 minutes.
                            </p>

                            <div style="text-align:center; margin:24px 0;">
                                <span style="display:inline-block; padding:14px 28px; background-color:#f0faf4; border:1px solid #16A249; border-radius:10px; font-size:28px; font-weight:600; letter-spacing:6px; color:#128a3d;">
                                    {{ $code }}
                                </span>
                            </div>

                            <p style="margin:24px 0 0; color:#6c757d; font-size:13px; line-height:1.6;">
                                If you didn't request a password reset, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:20px 32px; background-color:#f8f9fa; border-top:1px solid #dee2e6;">
                            <p style="margin:0; color:#6c757d; font-size:12px;">
                                © {{ date('Y') }} A We Green Enterprise. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>