<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Ticket Returned</title>
</head>
<body style="margin:0;padding:30px;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;color:#333333;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0">
<tr><td align="center">
<table role="presentation" width="650" cellspacing="0" cellpadding="0" style="background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e5e7eb;">
    <tr>
        <td style="background:#dc3545;padding:24px;text-align:center;">
            <h2 style="margin:0;color:#ffffff;font-size:24px;">iSTaksyon System</h2>
            <p style="margin:8px 0 0;color:#ffe3e6;font-size:14px;">Ticket Return Notification</p>
        </td>
    </tr>
    <tr>
        <td style="padding:35px;">
            <p style="margin-top:0;font-size:16px;">A requester has returned ticket <strong>#{{ $ticket->ticket_id }}</strong> for additional assistance.</p>
            <table width="100%" cellpadding="0" cellspacing="0" style="background:#fff8f0;border:1px solid #f3dfc5;border-radius:8px;">
                <tr>
                    <td style="padding:18px 20px;line-height:1.7;">
                        <strong>Requester:</strong> {{ trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name) }}<br>
                        <strong>Urgency:</strong> {{ ucfirst($ticketReturn->urgency) }}<br>
                        <strong>Returned at:</strong> {{ $ticketReturn->returned_at?->format('M d, Y h:i A') }}<br>
                        <strong>Reason:</strong><br>
                        <span style="white-space:pre-line;">{{ $ticketReturn->return_reason }}</span>
                    </td>
                </tr>
            </table>
            <p style="margin-bottom:0;margin-top:28px;">The ticket status has been changed to <strong>In Progress</strong>. Please review the request and follow up with the requester.</p>
        </td>
    </tr>
    <tr>
        <td style="background:#f8fafc;padding:20px;border-top:1px solid #e5e7eb;text-align:center;font-size:12px;color:#6b7280;line-height:1.6;">
            <strong>iSTaksyon System</strong><br>
            This is an automated system-generated notification.
        </td>
    </tr>
</table>
</td></tr>
</table>
</body>
</html>
