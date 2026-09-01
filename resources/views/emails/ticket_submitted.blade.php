<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Successfully Submitted</title>

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
            font-size:26px;
            font-weight:700;
            color:#111827;
        }

        .sub{
            margin:0;
            color:#6b7280;
            font-size:15px;
            line-height:1.7;
        }

        .success-panel{
            margin:30px 0;
            background:#f1f5f9;
            border-radius:10px;
            padding:28px;
        }

        .ticket-card{
            background:#ffffff;
            border-radius:8px;
            padding:24px;
            box-shadow:0 2px 6px rgba(2,6,23,.06);
        }

        .ticket-label{
            font-size:12px;
            color:#6b7280;
            text-transform:uppercase;
            font-weight:700;
            letter-spacing:1px;
        }

        .ticket-id{
            margin-top:10px;
            font-size:30px;
            font-weight:800;
            color:#0d6efd;
            letter-spacing:2px;
            word-break:break-word;
        }

        .status{
            display:inline-block;
            margin-top:18px;
            padding:7px 15px;
            border-radius:999px;
            background:#fff3cd;
            border:1px solid #fde68a;
            color:#856404;
            font-size:12px;
            font-weight:700;
        }

        .timeline{
            margin-top:35px;
        }

        .timeline-title{
            margin:0 0 22px;
            font-size:20px;
            color:#111827;
            font-weight:700;
        }

        .timeline-item{
            display:flex;
            align-items:flex-start;
            margin-bottom:20px;
        }

        .timeline-icon{
            width:38px;
            height:38px;
            border-radius:50%;
            background:#eef4ff;
            color:#0d6efd;
            display:flex;
            align-items:center;
            justify-content:center;
            margin-right:15px;
            font-size:18px;
            flex-shrink:0;
        }

        .timeline-text strong{
            display:block;
            color:#111827;
            font-size:15px;
        }

        .timeline-text span{
            color:#6b7280;
            font-size:14px;
            line-height:1.6;
        }

        .notice{
            margin-top:30px;
            background:#fff9eb;
            padding:18px;
            border-radius:8px;
            color:#6b7280;
            font-size:14px;
            line-height:1.7;
        }

        .notice strong{
            display:block;
            color:#8a5a00;
            margin-bottom:8px;
        }

        .button-wrap{
            text-align:center;
            margin:35px 0 10px;
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

            .ticket-id{
                font-size:24px;
            }

            .btn{
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

            <p class="title">
                Request Successfully Submitted
            </p>

            <p class="sub">
                Your service request has been received by the
                Social Technology Bureau.
            </p>

        </div>


        <p style="font-size:15px;color:#374151;">
            Hello
            <strong>{{ $ticket->requestor_first_name }}</strong>,
        </p>


        <p style="font-size:15px;color:#4b5563;line-height:1.8;">

            Thank you for submitting your request through the
            <strong>iSTaksyon System</strong>.

            Your request has been successfully recorded and will be reviewed
            by our team. You will receive updates as your request progresses.

        </p>


        <div class="success-panel">

            <div class="ticket-card">

                <div class="ticket-label">
                    Ticket Reference Number
                </div>

                <div class="ticket-id">
                    {{ $ticket->ticket_id }}
                </div>


                <span class="status">
                    Under Initial Review
                </span>


            </div>

        </div>



        <div class="timeline">

            <p class="timeline-title">
                What happens next?
            </p>


            <div class="timeline-item">

                <div class="timeline-icon">
                    ✓
                </div>

                <div class="timeline-text">

                    <strong>
                        Request Received
                    </strong>

                    <span>
                        Your request has been successfully recorded in the system.
                    </span>

                </div>

            </div>


            <div class="timeline-item">

                <div class="timeline-icon">
                    ⚙
                </div>

                <div class="timeline-text">

                    <strong>
                        Processing
                    </strong>

                    <span>
                        Our team will review, evaluate, and work on your request.
                    </span>

                </div>

            </div>


            <div class="timeline-item">

                <div class="timeline-icon">
                    ✓
                </div>

                <div class="timeline-text">

                    <strong>
                        Completion
                    </strong>

                    <span>
                        You will receive another notification once your request
                        has been completed.
                    </span>

                </div>

            </div>


        </div>



        <div class="notice">

            <strong>
                Important Notice
            </strong>

            Please keep your ticket reference number for future tracking and
            communication regarding your request.

        </div>



        <div class="button-wrap">

            <a href="{{ $ticketUrl }}" class="btn">
                View Ticket #{{ $ticket->ticket_id }}
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