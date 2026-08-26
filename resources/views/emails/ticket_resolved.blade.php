<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Resolved</title>

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

        .status-wrap{
            margin:30px 0;
            background:#f1f5f9;
            border-radius:10px;
            padding:28px;
        }

        .status-card{
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
            border-bottom:1px solid #eef2f7;
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

        .badge{
            display:inline-block;
            padding:6px 14px;
            border-radius:999px;
            background:#ecfdf5;
            border:1px solid #bbf7d0;
            color:#166534;
            font-size:12px;
            font-weight:700;
        }

        .info{
            margin-top:24px;
            color:#4b5563;
            font-size:14px;
            line-height:1.8;
        }

        .button-wrap{
            text-align:center;
            margin-top:30px;
        }

        .btn{
            display:inline-block;
            padding:15px 34px;
            background:#0d6efd;
            color:#ffffff !important;
            text-decoration:none;
            font-size:15px;
            font-weight:700;
            border-radius:8px;
            box-shadow:0 3px 10px rgba(13,110,253,.25);
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

            .status-wrap{
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

            <p class="title">Ticket Resolved</p>

            <p class="sub">
                Your service request has been successfully resolved by our
                support team.
            </p>

        </div>

        <p style="font-size:15px;color:#374151;">
            Dear
            <strong>
                {{ data_get($ticket, 'requestor_first_name') }}
                {{ data_get($ticket, 'requestor_last_name') }}
            </strong>,
        </p>

        <p style="font-size:15px;color:#4b5563;line-height:1.8;">
            We are pleased to inform you that your service request has been
            completed. Please review the details below and verify whether the
            provided resolution fully addresses your concern.
        </p>

        <div class="status-wrap">

            <div class="status-card">

                <table class="ticket-table">

                    <tr>
                        <td class="label">Ticket Number</td>
                        <td class="value">
                            #{{ $ticket->ticket_id }}
                        </td>
                    </tr>

                    <tr>
                        <td class="label">Status</td>
                        <td class="value">
                            <span class="badge">Resolved</span>
                        </td>
                    </tr>

                </table>

            </div>

        </div>

        <div class="info">

            Please review and validate the resolution provided.

            <br><br>

            If your request has been fully addressed, no further action is
            required. Your ticket will automatically be marked as
            <strong>Completed</strong> after <strong>3 calendar days</strong>
            if no response or additional action is received.

            <br><br>

            If the resolution does not fully address your concern, you may
            return the ticket with additional comments or feedback so our team
            can continue assisting you.

            <br><br>

            Should you require further assistance, please contact the
            <strong>Social Technology Bureau</strong> or submit a new service
            request through the <strong>iSTaksyon System</strong>, referencing
            your ticket number.

        </div>

        <div class="button-wrap">

            <a href="{{ config('app.url') }}" class="btn">
                Open iSTaksyon
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