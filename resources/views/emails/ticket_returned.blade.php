<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Returned</title>

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
            color:#b42318;
        }

        .sub{
            margin:0;
            color:#6b7280;
            font-size:15px;
            line-height:1.7;
        }

        .return-wrap{
            margin:30px 0;
            background:#fef2f2;
            border-radius:10px;
            padding:28px;
        }

        .return-card{
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
            background:#fff7ed;
            border:1px solid #fed7aa;
            color:#c2410c;
            font-size:12px;
            font-weight:700;
        }

        .reason-box{
            margin-top:22px;
            background:#f8fafc;
            border:1px solid #e5e7eb;
            border-radius:8px;
            padding:18px;
        }

        .reason-title{
            margin:0 0 10px;
            font-size:14px;
            font-weight:700;
            color:#111827;
        }

        .reason-text{
            margin:0;
            white-space:pre-line;
            font-size:14px;
            line-height:1.8;
            color:#4b5563;
        }

        .message{
            color:#4b5563;
            font-size:14px;
            line-height:1.8;
            margin-top:25px;
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

            .return-wrap{
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

            <p class="title">
                Ticket Returned
            </p>

            <p class="sub">
                A requester has returned a ticket for additional assistance
                and further review.
            </p>

        </div>


        <p style="font-size:15px;color:#374151;">
            Ticket
            <strong>#{{ $ticket->ticket_id }}</strong>
            requires additional attention from the assigned personnel.
        </p>


        <div class="return-wrap">

            <div class="return-card">

                <table class="ticket-table">

                    <tr>
                        <td class="label">
                            Requester
                        </td>

                        <td class="value">
                            {{ trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name) }}
                        </td>
                    </tr>


                    <tr>
                        <td class="label">
                            Priority
                        </td>

                        <td class="value">
                            {{ ucfirst($ticketReturn->urgency) }}
                        </td>
                    </tr>


                    <tr>
                        <td class="label">
                            Returned At
                        </td>

                        <td class="value">
                            {{ $ticketReturn->returned_at?->format('M d, Y h:i A') }}
                        </td>
                    </tr>


                    <tr>
                        <td class="label">
                            Status
                        </td>

                        <td class="value">

                            <span class="badge">
                                In Progress
                            </span>

                        </td>
                    </tr>

                </table>


                <div class="reason-box">

                    <p class="reason-title">
                        Return Reason
                    </p>

                    <p class="reason-text">
{{ $ticketReturn->return_reason }}
                    </p>

                </div>


            </div>

        </div>


        <div class="message">

            The ticket status has been updated to
            <strong>In Progress</strong>.

            <br><br>

            Please review the requester's feedback and provide the necessary
            assistance to address the remaining concerns.

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