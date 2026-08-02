<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Verify your sign-in</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f7f8fa; margin:0; padding:0; }
        .container { max-width:680px; margin:32px auto; background:#fff; border-radius:12px; padding:32px; box-shadow:0 6px 24px rgba(16,24,40,0.08); }
        .header { text-align:center; padding-bottom:18px; }
        .title { font-size:22px; font-weight:700; color:#111827; margin:0 0 8px; }
        .sub { color:#6b7280; font-size:14px; margin:0 0 18px; }
        .otp-wrap { background:#f1f5f9; padding:28px; border-radius:10px; text-align:center; }
        .otp-box { display:inline-block; background:#ffffff; padding:18px 36px; border-radius:8px; box-shadow:0 2px 6px rgba(2,6,23,0.06); font-size:40px; font-weight:700; letter-spacing:6px; color:#0f172a; }
        .meta { color:#6b7280; font-size:13px; margin-top:18px; }
        .footer { margin-top:26px; font-size:12px; color:#9ca3af; text-align:center; }
        .brand { color:#0b3ea9; font-weight:700; }
        @media (max-width:480px){ .otp-box{ font-size:32px; padding:14px 20px; } }
        .footer{
            background:#f9fafb;
            border-top:1px solid #e5e7eb;
            text-align:center;
            padding:25px;
            font-size:13px;
            color:#6b7280;
        }

        .footer strong{
            color:#374151;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <p class="title">Verify your sign-in</p>
            <p class="sub">We received a sign-in attempt for your account. Please enter the following code in the browser window where you started signing in.</p>
        </div>

        <div class="otp-wrap">
            <div class="otp-box">{{ $otp }}</div>
            <p class="meta">If you did not attempt to sign in but received this email, please disregard it. The code will remain active for {{ $minutes }} minutes.</p>
        </div>

        <div class="footer">

        <strong>Social Technology Bureau (STB)</strong><br>
        Department of Social Welfare and Development (DSWD)<br><br>

        <strong>This is an automated email notification.</strong><br>
        Please do not reply to this email, as this mailbox is not monitored.<br><br>

        © {{ date('Y') }} Department of Social Welfare and Development. All rights reserved.

    </div>
    </div>

</body>
</html>