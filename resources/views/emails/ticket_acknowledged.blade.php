<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Acknowledged</title>

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
            font-size:15px;
            color:#6b7280;
            line-height:1.7;
        }

        .ticket-wrap{
            margin:30px 0;
            background:#f1f5f9;
            border-radius:10px;
            padding:28px;
        }

        .ticket-card{
            background:#ffffff;
            border-radius:8px;
            box-shadow:0 2px 6px rgba(2,6,23,.06);
            padding:22px;
        }

        .ticket-table{
            width:100%;
            border-collapse:collapse;
            font-size:14px;
        }

        .ticket-table td{
            padding:12px 0;
            border-bottom:1px solid #f1f5f9;
        }

        .ticket-table tr:last-child td{
            border-bottom:none;
        }

        .label{
            color:#6b7280;
        }

        .value{
            text-align:right;
            font-weight:600;
            color:#111827;
        }

        .status{
            display:inline-block;
            padding:6px 14px;
            border-radius:999px;
            background:#ecfdf5;
            border:1px solid #bbf7d0;
            color:#166534;
            font-size:12px;
            font-weight:700;
        }

        .message{
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

            .ticket-wrap{
                padding:20px;
            }

            .ticket-table td{
                display:block;
                width:100%;
                text-align:left;
                padding:8px 0;
            }

            .value{
                text-align:left;
            }

        }

    </style>

</head>

<body>

<div class="container">

    <div class="content">

        <div class="header">

            <p class="title">Ticket Acknowledged</p>

            <p class="sub">
                Your service request has been successfully received and
                acknowledged by the Social Technology Bureau.
            </p>

        </div>

        <p style="font-size:15px;color:#374151;">
            Dear
            <strong>{{ $ticket->requestor_first_name }} {{ $ticket->requestor_last_name }}</strong>,
        </p>

        <p style="font-size:15px;color:#4b5563;line-height:1.8;">
            Thank you for submitting your request through
            <strong>iSTaksyon</strong>. Your ticket has been
            <strong>acknowledged</strong> and is now under review by our
            technical team. We will notify you as soon as there are updates
            regarding its progress or resolution.
        </p>

        <div class="ticket-wrap">

            <div class="ticket-card">

                <table class="ticket-table">

                    <tr>
                        <td class="label">Ticket Number</td>
                        <td class="value">#{{ $ticket->ticket_id }}</td>
                    </tr>

                    <tr>
                        <td class="label">Status</td>
                        <td class="value">
                            <span class="status">Acknowledged</span>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Submitted On</td>
                        <td class="value">
                            {{ $ticket->created_at->format('F d, Y h:i A') }}
                        </td>
                    </tr>

                </table>

            </div>

        </div>

        <div style="margin:28px 0 0;text-align:center;">
            <a href="{{ $ticketUrl }}"
               style="display:inline-block;padding:13px 24px;background:#0d6efd;color:#ffffff;text-decoration:none;border-radius:6px;font-size:14px;font-weight:700;">
                View Ticket #{{ $ticket->ticket_id }}
            </a>
        </div>

        <div class="message">

            We appreciate your patience while we process your request.
            Our team is committed to providing timely technical assistance
            and will keep you informed throughout the ticket lifecycle.

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