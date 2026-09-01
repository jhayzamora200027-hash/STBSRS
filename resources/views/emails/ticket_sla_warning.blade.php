<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Deadline Warning</title>
</head>
<body style="margin:0;padding:0;background:#f7f8fa;font-family:Arial,sans-serif;color:#111827;">
    <div style="max-width:680px;margin:32px auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
        <div style="padding:32px;">
            <h1 style="margin:0 0 10px;font-size:24px;color:#92400e;">Ticket deadline warning</h1>
            <p style="margin:0 0 24px;color:#6b7280;line-height:1.6;">
                Your service request has not been resolved and is approaching the 21-day resolution deadline.
            </p>
            <div style="padding:22px;background:#fffbeb;border:1px solid #fde68a;border-radius:8px;">
                <p style="margin:0 0 8px;color:#6b7280;font-size:13px;">Ticket Number</p>
                <p style="margin:0;font-size:22px;font-weight:700;color:#b45309;">#{{ $ticket->ticket_id }}</p>
            </div>
            <p style="margin:24px 0 0;color:#4b5563;line-height:1.7;">
                The ticket has been open for 19 days. Our team is continuing to work on it. Please use the button below to view its latest status.
            </p>
            <div style="margin:28px 0 0;text-align:center;">
                <a href="{{ $ticketUrl }}" style="display:inline-block;padding:13px 24px;background:#b45309;color:#ffffff;text-decoration:none;border-radius:6px;font-size:14px;font-weight:700;">
                    View Ticket #{{ $ticket->ticket_id }}
                </a>
            </div>
        </div>
        <div style="padding:22px;background:#f9fafb;border-top:1px solid #e5e7eb;text-align:center;color:#6b7280;font-size:13px;">
            This is an automated email notification from the iSTaksyon System.
        </div>
    </div>
</body>
</html>
