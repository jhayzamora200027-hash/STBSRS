<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Completed</title>

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

        .completed-wrap{
            margin:30px 0;
            background:#f1f5f9;
            border-radius:10px;
            padding:28px;
        }

        .ticket-card{
            background:#ffffff;
            border-radius:8px;
            padding:22px;
            box-shadow:0 2px 6px rgba(2,6,23,.06);
        }

        .label{
            color:#6b7280;
            font-size:13px;
        }

        .ticket-id{
            margin-top:8px;
            color:#111827;
            font-size:24px;
            font-weight:700;
            letter-spacing:1px;
        }

        .badge{
            display:inline-block;
            margin-top:18px;
            padding:6px 14px;
            border-radius:999px;
            background:#ecfdf5;
            border:1px solid #bbf7d0;
            color:#166534;
            font-size:12px;
            font-weight:700;
        }

        .message{
            color:#4b5563;
            font-size:15px;
            line-height:1.8;
        }

        .note{
            margin-top:25px;
            background:#f8fafc;
            border-radius:8px;
            padding:18px;
            color:#4b5563;
            font-size:14px;
            line-height:1.7;
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

        }

    </style>

</head>

<body>

<div class="container">

    <div class="content">

        <div class="header">

            <p class="title">
                Ticket Completed
            </p>

            <p class="sub">
                Your service request has been successfully completed.
            </p>

        </div>


        <p style="font-size:15px;color:#374151;">
            Dear
            <strong>
                {{ $ticket->requestor_first_name }}
                {{ $ticket->requestor_last_name }}
            </strong>,
        </p>


        <p class="message">

            We are pleased to inform you that your service request has been
            marked as <strong>Completed</strong>.

            <br><br>

            Thank you for using the <strong>iSTaksyon System</strong>.
            We appreciate your cooperation and trust in our service.

        </p>



        <div class="completed-wrap">

            <div class="ticket-card">

                <div class="label">
                    Ticket Number
                </div>

                <div class="ticket-id">
                    #{{ $ticket->ticket_id }}
                </div>


                <span class="badge">
                    Completed
                </span>

            </div>

        </div>



        <div class="note">

            Your request has reached the end of its service workflow.
            If you require further assistance, you may submit a new request
            through the <strong>iSTaksyon System</strong>.

        </div>

        <div style="margin:30px 0 0;text-align:center;">
            <a href="{{ $ticketUrl }}"
               style="display:inline-block;padding:15px 34px;background:#0d6efd;color:#ffffff;text-decoration:none;font-size:15px;font-weight:700;border-radius:8px;box-shadow:0 3px 10px rgba(13,110,253,.25);">
                Open iSTaksyon
            </a>
            <p style="margin:12px 0 0;color:#6b7280;font-size:12px;">
                This secure link expires in 30 minutes.
            </p>
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