<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Attempt Notification</title>

    <style>
        body{
            font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;
            background:#f7f8fa;
            margin:0;
            padding:0;
        }

        .container{
            max-width:680px;
            margin:32px auto;
            background:#ffffff;
            border-radius:12px;
            padding:32px;
            box-shadow:0 6px 24px rgba(16,24,40,.08);
        }

        .header{
            text-align:center;
            padding-bottom:18px;
        }

        .title{
            font-size:24px;
            font-weight:700;
            color:#111827;
            margin:0 0 8px;
        }

        .sub{
            color:#6b7280;
            font-size:14px;
            line-height:1.7;
            margin:0;
        }

        .content{
            margin-top:25px;
            color:#374151;
            font-size:15px;
            line-height:1.8;
            border: 1px solid #dbdbdb;

        }

        .notice-wrap{
            background:#f1f5f9;
            padding:28px;
            border-radius:10px;
            margin:30px 0;
        }

        .notice-box{
            background:#ffffff;
            padding:22px;
            border-radius:8px;
            box-shadow:0 2px 6px rgba(2,6,23,.06);
            text-align:center;
        }

        .warning-badge{
            display:inline-block;
            padding:7px 16px;
            background:#fff7ed;
            border:1px solid #fed7aa;
            color:#9a3412;
            border-radius:999px;
            font-size:12px;
            font-weight:700;
        }

        .message{
            margin-top:18px;
            color:#4b5563;
            font-size:14px;
            line-height:1.7;
        }

        .security{
            background:#fff9eb;
            padding:16px 18px;
            border-radius:6px;
            color:#6b7280;
            font-size:13px;
            line-height:1.7;
        }

        .security strong{
            display:block;
            color:#8a5a00;
            margin-bottom:5px;
        }

        .footer{
            margin-top:26px;
            background:#f9fafb;
            border-top:1px solid #e5e7eb;
            text-align:center;
            padding:25px;
            margin-left:-32px;
            margin-right:-32px;
            margin-bottom:-32px;
            font-size:13px;
            color:#6b7280;
            line-height:1.7;
        }

        .footer strong{
            color:#374151;
        }


        @media(max-width:480px){

            .container{
                margin:20px;
                padding:24px;
            }

            .footer{
                margin-left:-24px;
                margin-right:-24px;
                margin-bottom:-24px;
            }

        }

    </style>

</head>

<body>
<div class="p-2">
    <div class="container" style="border: 1px solid #dbdbdb#">
    
    
        <div class="header">
    
            <p class="title">
                Registration Attempt Detected
            </p>
    
            <p class="sub">
                Someone attempted to create an iSTaksyon account using this email address.
            </p>
    
        </div>
    
    
    
        <div class="content p-2">
    
    
            <p>
                Hello <strong>{{ $name }}</strong>,
            </p>
    
    
            <p>
                We received a request to register an account for the
                <strong>iSTaksyon System</strong> using this email address.
            </p>
    
    
    
            <div class="notice-wrap">
    
                <div class="notice-box">
    
                    <span class="warning-badge">
                        Registration Attempt
                    </span>
    
    
                    <p class="message">
    
                        If this was you, no further action is required.
                        You may continue with the account registration process.
    
                    </p>
    
                </div>
    
            </div>
    
    
    
            <div class="security">
    
                <strong>Security Notice</strong>
    
                If you did not make this request, please disregard this email.
                Your existing account, password, and account information have not
                been changed.
    
            </div>
    
    
    
            <p style="margin-top:25px;">
                Thank you for using the
                <strong>iSTaksyon System</strong>.
            </p>
    
    
        </div>
    
    
    
    
        <div class="footer">
    
            <strong>Social Technology Bureau (STB)</strong><br>
            Department of Social Welfare and Development (DSWD)<br><br>
    
            <strong>This is an automated email notification.</strong><br>
            Please do not reply to this email, as this mailbox is not monitored.<br><br>
    
            © {{ date('Y') }} Department of Social Welfare and Development. All rights reserved.
    
        </div>
    
    
    </div>
</div>


</body>
</html>