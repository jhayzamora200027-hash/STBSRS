<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STBSRS Request Submission Confirmation</title>

    <style>
        body{
    margin:0;
    padding:0;
    background:#f4f7fb;
    font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Helvetica,Arial,sans-serif;
    color:#2c3e50;
    line-height:1.6;
}

table{
    border-spacing:0;
    border-collapse:collapse;
}

img{
    border:0;
    display:block;
    max-width:100%;
}

a{
    text-decoration:none;
}


.email-wrapper{
    width:100%;
    background:#f4f7fb;
    padding:40px 20px;
}

.email-card{
    max-width:650px;
    margin:auto;
    background:#ffffff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 12px 40px rgba(15,23,42,.08);
}


.header{
    background:linear-gradient(135deg,#0d6efd,#084298);
    color:#ffffff;
    text-align:center;
    padding:50px 40px;
}

.success-icon{
    width:82px;
    height:82px;
    margin:0 auto 25px;
    border-radius:50%;
    background:rgba(255,255,255,.18);
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:42px;
    font-weight:700;
    color:#ffffff;
}

.header h1{
    margin:0;
    font-size:30px;
    font-weight:700;
    letter-spacing:-.5px;
}

.header p{
    margin-top:12px;
    opacity:.9;
    font-size:15px;
}


.content{
    padding:45px;
}

.greeting{
    margin:0;
    font-size:24px;
    font-weight:700;
    color:#1f2937;
}

.content p{
    color:#5b6472;
    font-size:15px;
    line-height:28px;
    margin:18px 0;
}


.ticket-card{
    margin:35px 0;
    background:#f8fbff;
    border:1px solid #dbeafe;
    border-radius:16px;
    padding:30px;
}

.ticket-label{
    font-size:12px;
    text-transform:uppercase;
    color:#6b7280;
    font-weight:700;
    letter-spacing:1px;
}

.ticket-id{
    margin-top:12px;
    font-size:34px;
    font-weight:800;
    color:#0d6efd;
    letter-spacing:3px;
    word-break:break-word;
}

.status-badge{
    display:inline-block;
    margin-top:20px;
    background:#fff3cd;
    color:#856404;
    padding:10px 18px;
    border-radius:50px;
    font-size:13px;
    font-weight:600;
}


.timeline{
    margin-top:40px;
}

.timeline-title{
    margin-bottom:25px;
    font-size:20px;
    font-weight:700;
    color:#1f2937;
}

.timeline-item{
    display:flex;
    align-items:flex-start;
    margin-bottom:22px;
}

.timeline-icon{
    width:38px;
    height:38px;
    border-radius:50%;
    background:#eef4ff;
    color:#0d6efd;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:18px;
    margin-right:18px;
    flex-shrink:0;
}

.timeline-text strong{
    display:block;
    color:#1f2937;
    font-size:15px;
}

.timeline-text span{
    color:#6b7280;
    font-size:14px;
}


.button{
    text-align:center;
    margin:40px 0;
}

.button a{
    display:inline-block;
    background:#0d6efd;
    color:#ffffff;
    padding:16px 36px;
    border-radius:10px;
    font-size:15px;
    font-weight:600;
}

.button a:hover{
    background:#084298;
}

.notice{
    background:#fff9eb;
    border-left:5px solid #f4b400;
    border-radius:10px;
    padding:20px;
    margin-top:35px;
}

.notice strong{
    display:block;
    color:#8a5a00;
    margin-bottom:8px;
}

.notice p{
    margin:0;
    color:#6b7280;
}


.footer{
    background:#f8fafc;
    border-top:1px solid #e5e7eb;
    padding:35px;
    text-align:center;
    color:#6b7280;
    font-size:13px;
    line-height:24px;
}

.footer strong{
    color:#374151;
}


@media only screen and (max-width:600px){

    .header{
        padding:40px 25px;
    }

    .content{
        padding:30px 25px;
    }

    .footer{
        padding:30px 25px;
    }

    .header h1{
        font-size:24px;
    }

    .greeting{
        font-size:22px;
    }

    .ticket-id{
        font-size:26px;
        letter-spacing:1px;
    }

    .button a{
        width:100%;
        box-sizing:border-box;
    }

}

    </style>
</head>

<body style="margin:0;padding:0;background:#f5f7fb;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f5f7fb;padding:40px 20px;">
<tr>
<td align="center">

<table role="presentation" width="640" cellspacing="0" cellpadding="0" style="background:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 10px 35px rgba(0,0,0,.08);">

    <!-- Header -->
    <tr>
        <td style="background:linear-gradient(135deg,#0d6efd,#0a4db3);padding:45px;text-align:center;color:#fff;">

            <h1 style="margin:25px 0 10px;font-size:30px;font-weight:700;">
                Request Successfully Submitted
            </h1>

            <p style="margin:0;font-size:16px;opacity:.95;">
                Social Technology Bureau Service Request System
            </p>

        </td>
    </tr>

    <!-- Greeting -->
    <tr>
        <td style="padding:40px;">

            <h2 style="margin:0;color:#222;">
                Hello {{ $ticket->requestor_first_name }},
            </h2>

            <p style="margin:20px 0 0;color:#5c6675;font-size:16px;line-height:28px;">

                Thank you for submitting your request.

                Your request has been successfully received by the
                <strong>Social Technology Bureau Service Request System (STBSRS)</strong>.

                Our team will review and process it as soon as possible.

            </p>

        </td>
    </tr>

    <!-- Ticket Card -->
    <tr>
        <td style="padding:0 40px;">

            <table width="100%" cellspacing="0" cellpadding="0" style="background:#f8fbff;border:1px solid #dce8ff;border-radius:14px;padding:30px;">

                <tr>

                    <td>

                        <div style="font-size:13px;color:#6c757d;text-transform:uppercase;font-weight:600;letter-spacing:1px;">
                            Ticket Reference Number
                        </div>

                        <div style="margin-top:12px;font-size:20px;font-weight:700;color:#0d6efd;letter-spacing:2px;">
                            {{ $ticket->ticket_id }}
                        </div>

                    </td>

                    <td align="right">

                        <span style="background:#fff3cd;color:#8a6d3b;padding:10px 18px;border-radius:50px;font-weight:600;">
                            Under Initial Review
                        </span>

                    </td>

                </tr>

            </table>

        </td>
    </tr>

    <!-- What's Next -->
    <tr>
        <td style="padding:40px;">

            <h3 style="margin:0 0 25px;color:#222;">
                What happens next?
            </h3>

            <table width="100%" cellspacing="0">

                <tr>

                    <td width="42" valign="top">
                        🟢
                    </td>

                    <td style="padding-bottom:18px;">
                        <strong>Request Received</strong><br>
                        <span style="color:#666;">Your request has been successfully recorded.</span>
                    </td>

                </tr>


                <tr>

                    <td valign="top">
                        ⚙️
                    </td>

                    <td style="padding-bottom:18px;">
                        <strong>Processing</strong><br>
                        <span style="color:#666;">Our team will evaluate and work on your request.</span>
                    </td>

                </tr>

                <tr>

                    <td valign="top">
                        ✅
                    </td>

                    <td>

                        <strong>Completion</strong><br>
                        <span style="color:#666;">You'll receive another email once your request has been completed.</span>

                    </td>

                </tr>

            </table>

        </td>
    </tr>

    <!-- CTA -->
    <tr>
        <td align="center" style="padding:0 40px 40px;">

            <a href="{{ url('/') }}"
               style="display:inline-block;background:#0d6efd;color:#fff;text-decoration:none;padding:16px 34px;border-radius:10px;font-weight:600;font-size:16px;">

                Track My Request

            </a>

        </td>
    </tr>

    <!-- Footer -->
    <tr>

        <td style="background:#f8f9fb;padding:35px;text-align:center;font-size:13px;color:#777;line-height:24px;">

            <strong style="font-size:15px;color:#222;">
                Social Technology Bureau (STB)
            </strong>

            <br>

            Department of Social Welfare and Development

            <br><br>

            This is an automated email generated by the
            <strong>Social Technology Bureau Service Request System (STBSRS)</strong>.

            Please do not reply to this email.

            <br><br>

            © {{ date('Y') }} Department of Social Welfare and Development.
            All rights reserved.

        </td>

    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>