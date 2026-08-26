<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isReply ? 'New Reply' : 'New Comment' }}</title>

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
            margin:0 0 10px;
            font-size:24px;
            font-weight:700;
            color:#111827;
        }

        .sub{
            margin:0;
            color:#6b7280;
            font-size:15px;
            line-height:1.7;
        }

        .comment-wrap{
            margin:30px 0;
            background:#f1f5f9;
            border-radius:10px;
            padding:28px;
        }

        .comment-card{
            background:#ffffff;
            border-radius:8px;
            box-shadow:0 2px 6px rgba(2,6,23,.06);
            padding:22px;
        }

        .meta{
            margin-bottom:18px;
            padding-bottom:16px;
            border-bottom:1px solid #eef2f7;
            font-size:14px;
        }

        .meta strong{
            color:#111827;
        }

        .label{
            color:#6b7280;
        }

        .message{
            white-space:pre-line;
            color:#374151;
            line-height:1.8;
            font-size:15px;
        }

        .note{
            margin-top:25px;
            color:#4b5563;
            font-size:14px;
            line-height:1.8;
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

        @media(max-width:480px){

            .content{
                padding:24px;
            }

            .comment-wrap{
                padding:20px;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="content">

        <div class="header">

            <p class="title">
                {{ $isReply ? 'New Reply' : 'New Comment' }}
            </p>

            <p class="sub">
                There is a new {{ strtolower($isReply ? 'reply' : 'comment') }}
                on your iSTaksyon service request.
            </p>

        </div>

        <p style="font-size:15px;color:#374151;">
            Hello
            <strong>{{ $ticket->requestor_first_name }} {{ $ticket->requestor_last_name }}</strong>,
        </p>

        <p style="font-size:15px;color:#4b5563;line-height:1.8;">
            A new
            <strong>{{ strtolower($isReply ? 'reply' : 'comment') }}</strong>
            has been posted to your ticket. Please review the message below.
        </p>

        <div class="comment-wrap">

            <div class="comment-card">

                <div class="meta">
                    <span class="label">Ticket Number</span><br>
                    <strong>#{{ $ticket->ticket_id }}</strong>
                </div>

                <div class="message">
{{ $comment->comment }}
                </div>

            </div>

        </div>

        <div class="note">
            Use the button below to view the complete discussion, reply to this
            conversation, and track your ticket's latest updates. This secure
            link will expire in 30 minutes.
        </div>

        <div style="margin:28px 0;text-align:center;">
            <a href="{{ $ticketUrl }}"
               style="display:inline-block;padding:13px 24px;border-radius:8px;background:#0d6efd;color:#ffffff;text-decoration:none;font-size:15px;font-weight:700;">
                View Ticket
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