<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your iSTaksyon Password</title>

    <style>
        body{
            margin:0;
            padding:0;
            background:#f7f8fa;
            font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;
        }

        .container{
            max-width:680px;
            margin:32px auto;
            background:#ffffff;
            border-radius:12px;
            overflow:hidden;
            box-shadow:0 6px 24px rgba(16,24,40,.08);
        }

        .content{
            padding:36px;
            border: 1px solid #dbdbdb;
        }

        .header{
            text-align:center;
            padding-bottom:20px;
        }

        .title{
            font-size:24px;
            font-weight:700;
            color:#111827;
            margin:0 0 10px;
        }

        .sub{
            color:#6b7280;
            font-size:15px;
            line-height:1.7;
            margin:0;
        }

        .action-wrap{
            background:#f1f5f9;
            padding:34px;
            border-radius:10px;
            text-align:center;
            margin:30px 0;
        }

        .btn{
            display:inline-block;
            padding:15px 36px;
            background:#0d6efd;
            color:#ffffff !important;
            text-decoration:none;
            font-size:16px;
            font-weight:700;
            border-radius:8px;
            box-shadow:0 3px 10px rgba(13,110,253,.25);
        }

        .note{
            margin-top:20px;
            font-size:13px;
            color:#6b7280;
            line-height:1.7;
        }

        .info-box{
            margin-top:25px;
            background:#f8fafc;
            border-left:4px solid #0d6efd;
            padding:18px;
            border-radius:6px;
            font-size:14px;
            color:#4b5563;
            line-height:1.7;
        }

        .url-box{
            margin-top:24px;
            background:#ffffff;
            border:1px solid #e5e7eb;
            border-radius:8px;
            padding:16px;
            font-size:13px;
            word-break:break-all;
        }

        .url-box a{
            color:#0d6efd;
            text-decoration:none;
        }

        .footer{
            background:#f9fafb;
            border-top:1px solid #e5e7eb;
            text-align:center;
            padding:25px;
            font-size:13px;
            color:#6b7280;
            line-height:1.7;
        }

        .footer strong{
            color:#374151;
        }

        @media (max-width:480px){

            .content{
                padding:24px;
            }

            .action-wrap{
                padding:24px;
            }

            .btn{
                display:block;
                width:100%;
                box-sizing:border-box;
            }

        }
    </style>
</head>

<body>

<div class="container">

    <div class="content">

        <div class="header">

            <p class="title">Reset your password</p>

            <p class="sub">
                We received a request to reset the password for your
                <strong>iSTaksyon</strong> account.
                Click the button below to securely create a new password.
            </p>

        </div>

        <p style="font-size:15px;color:#374151;">
            Hello{{ $user->first_name ? ' ' . $user->first_name : '' }},
        </p>

        <div class="action-wrap">

            <a href="{{ $resetUrl }}" class="btn">
                Reset Password
            </a>

            <p class="note">
                This password reset link will remain active for
                <strong>{{ $expireMinutes }} minutes</strong>.
            </p>

        </div>

        <div class="info-box">
            If you did not request a password reset, you may safely ignore
            this email. Your password will remain unchanged and no further
            action is required.
        </div>

        <div class="url-box">
            <strong>Button not working?</strong><br><br>

            Copy and paste the following link into your browser:<br><br>

            <a href="{{ $resetUrl }}">
                {{ $resetUrl }}
            </a>
        </div>

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