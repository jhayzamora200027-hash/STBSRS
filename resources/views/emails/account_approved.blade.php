<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your iSTaksyon Account Has Been Approved</title>

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

        .account-wrap{
            background:#f1f5f9;
            padding:28px;
            border-radius:10px;
            margin:30px 0;
        }

        .account-box{
            background:#ffffff;
            padding:22px;
            border-radius:8px;
            box-shadow:0 2px 6px rgba(2,6,23,.06);
        }

        .status{
            text-align:center;
            margin-bottom:20px;
        }

        .status span{
            display:inline-block;
            padding:7px 16px;
            background:#ecfdf5;
            border:1px solid #bbf7d0;
            color:#166534;
            border-radius:999px;
            font-size:12px;
            font-weight:700;
        }

        .credential{
            background:#f8fafc;
            border-radius:8px;
            padding:18px;
        }

        .credential p{
            margin:8px 0;
            color:#374151;
            font-size:14px;
        }

        .credential strong{
            color:#111827;
        }

        .notice{
            background:#fff9eb;
            border-left:4px solid #f4b400;
            padding:16px 18px;
            border-radius:6px;
            color:#6b7280;
            font-size:13px;
            line-height:1.7;
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

<div class="container">

    <div class="header">

        <p class="title">
            Your Account Has Been Approved
        </p>

        <p class="sub">
            Your iSTaksyon account registration has been reviewed and approved.
            You may now access the system.
        </p>

    </div>


    <div class="content">

        <p>
            Hello <strong>{{ $name }}</strong>,
        </p>


        <p>
            Your account for the
            <strong>iSTaksyon System</strong> has been successfully approved.
            You can now sign in using the credentials provided below.
        </p>


        <div class="account-wrap">

            <div class="account-box">

                <div class="status">
                    <span>
                        Account Approved
                    </span>
                </div>


                <div class="credential">

                    <p>
                        <strong>Email Address</strong><br>
                        {{ $email }}
                    </p>

                    <p>
                        <strong>Temporary Password</strong><br>
                        {{ $password }}
                    </p>

                </div>

            </div>

        </div>


        <div class="notice">

            <strong>Security Reminder</strong><br>

            Please change your temporary password immediately after signing in.
            You may also continue using Google Sign-In for easier and secure access.

        </div>


        <p style="margin-top:25px;">
            Thank you for joining the
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

</body>
</html>