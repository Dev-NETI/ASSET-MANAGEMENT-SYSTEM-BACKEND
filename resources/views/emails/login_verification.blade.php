<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Verification Code</title>
</head>
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9;padding:40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="padding-bottom:24px;">
                            <div style="background:linear-gradient(135deg,#6366f1,#7c3aed);display:inline-block;border-radius:14px;padding:14px;margin-bottom:12px;">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 9L12 2L21 9V20C21 20.5304 20.7893 21.0391 20.4142 21.4142C20.0391 21.7893 19.5304 22 19 22H5C4.46957 22 3.96086 21.7893 3.58579 21.4142C3.21071 21.0391 3 20.5304 3 20V9Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div style="font-size:20px;font-weight:700;color:#1e293b;line-height:1.2;">Inventory Management System</div>
                        </td>
                    </tr>

                    <!-- Card -->
                    <tr>
                        <td>
                            <div style="background:#ffffff;border-radius:16px;padding:40px 36px;border:1px solid #e2e8f0;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);">

                                <p style="margin:0 0 8px;font-size:16px;color:#475569;">Hello, <strong style="color:#1e293b;">{{ $userName }}</strong></p>
                                <p style="margin:0 0 28px;font-size:15px;color:#64748b;line-height:1.6;">
                                    We received a login request for your account. Use the verification code below to complete your sign-in.
                                </p>

                                <!-- Code box -->
                                <div style="text-align:center;margin-bottom:28px;">
                                    <div style="display:inline-block;background:#eef2ff;border:2px solid #c7d2fe;border-radius:14px;padding:24px 40px;">
                                        <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:2px;color:#6366f1;margin-bottom:8px;">Verification Code</div>
                                        <div style="font-size:44px;font-weight:800;letter-spacing:14px;color:#4338ca;font-family:'Courier New',Courier,monospace;">{{ $code }}</div>
                                    </div>
                                </div>

                                <p style="margin:0 0 6px;font-size:13px;color:#64748b;text-align:center;">
                                    This code expires in <strong style="color:#1e293b;">10 minutes</strong>.
                                </p>
                                <p style="margin:0;font-size:13px;color:#94a3b8;text-align:center;">
                                    Do not share this code with anyone.
                                </p>

                                <hr style="border:none;border-top:1px solid #f1f5f9;margin:28px 0;">

                                <p style="margin:0;font-size:12px;color:#94a3b8;text-align:center;">
                                    If you did not attempt to log in, you can safely ignore this email. Your account remains secure.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding-top:20px;">
                            <p style="margin:0;font-size:12px;color:#94a3b8;">&copy; {{ date('Y') }} Inventory Management System. All rights reserved.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
