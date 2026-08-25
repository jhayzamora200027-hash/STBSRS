
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>iSTAksyon System Notification</title>
</head>

<body style="margin:0;padding:30px;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#333333;">

<table role="presentation" width="100%" cellspacing="0" cellpadding="0">
<tr>
<td align="center">

<table role="presentation" width="650" cellspacing="0" cellpadding="0"
       style="background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">

    <tr>
        <td style="background:#0d6efd;padding:24px;text-align:center;">
            <h2 style="margin:0;color:#ffffff;font-size:24px;">
                iSTaksyon System
            </h2>
            <p style="margin:8px 0 0;color:#dbeafe;font-size:14px;">
                Automated Service Request Notification
            </p>
        </td>
    </tr>

    <tr>
        <td style="padding:35px;">

            <p style="margin-top:0;font-size:16px;">
                Dear
                <strong>{{ data_get($ticket, 'requestor_first_name') }}
                {{ data_get($ticket, 'requestor_last_name') }}</strong>,
            </p>

            <!-- Status Card -->
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding:18px 20px;">
                        <div style="font-size:14px;color:#198754;font-weight:bold;text-transform:uppercase;">
                            Ticket Status
                        </div>

                        <div style="font-size:22px;font-weight:bold;color:#14532d;margin-top:6px;">
                            RESOLVED
                        </div>

                        <div style="margin-top:12px;font-size:15px;color:#374151;">
                            Your service request
                            <strong>#{{ $ticket->ticket_id }}</strong>
                            has been successfully resolved by the assigned support team.
                        </div>
                    </td>
                </tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="padding:18px;line-height:1.7;">
                        <br>

                        Please review and validate the resolution provided.

                        If your request has been fully addressed, no further action is required. The ticket will be considered completed after your confirmation or will be automatically marked as completed after 3 calendar days if no response or further action is received.

                        If the provided resolution does not fully address your request, please return the ticket with additional details or feedback so the assigned personnel can further assist you.

                        For additional assistance regarding this request, please contact the Social Technology Bureau or submit a new service request through the iSTAksyon System, referencing your ticket number.
                    </td>
                </tr>
            </table>

            <!-- System Button -->
            <div style="text-align:center;margin:35px 0;">
                <a href="{{ config('app.url') }}"
                   style="display:inline-block;background:#0d6efd;color:#ffffff;text-decoration:none;padding:14px 32px;border-radius:8px;font-weight:bold;">
                    Open iSTAksyon System
                </a>
            </div>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f8fafc;padding:20px;border-top:1px solid #e5e7eb;text-align:center;font-size:12px;color:#6b7280;line-height:1.6;">
            <strong>iSTAksyon System</strong><br>
            Social Technology Bureau<br>
            Department of Social Welfare and Development
            <br><br>
            This is an automated system-generated notification.
            Please do not reply to this email.
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
```
