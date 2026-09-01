<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Ticket Created</title>
</head>
<body style="margin:0;padding:0;background:#f7f8fa;font-family:Arial,sans-serif;color:#111827;">
    <div style="max-width:680px;margin:32px auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
        <div style="padding:32px;">
            <h1 style="margin:0 0 10px;font-size:24px;">New ticket created</h1>
            <p style="margin:0 0 24px;color:#6b7280;line-height:1.6;">
                A new service request has been submitted through the iSTaksyon System and is ready for review.
            </p>

            <div style="padding:22px;background:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;">
                <p style="margin:0 0 12px;color:#6b7280;font-size:13px;">Ticket Number</p>
                <p style="margin:0 0 20px;font-size:22px;font-weight:700;color:#0d6efd;word-break:break-word;">
                    {{ $ticket->ticket_id }}
                </p>

                <table style="width:100%;border-collapse:collapse;font-size:14px;">
                    <tr>
                        <td style="padding:9px 0;color:#6b7280;border-top:1px solid #e5e7eb;">Requester</td>
                        <td style="padding:9px 0;text-align:right;font-weight:600;border-top:1px solid #e5e7eb;">
                            {{ trim($ticket->requestor_first_name . ' ' . $ticket->requestor_last_name) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:9px 0;color:#6b7280;border-top:1px solid #e5e7eb;">Category</td>
                        <td style="padding:9px 0;text-align:right;font-weight:600;border-top:1px solid #e5e7eb;">
                            {{ ucfirst($ticket->ticket_category) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:9px 0;color:#6b7280;border-top:1px solid #e5e7eb;">Priority</td>
                        <td style="padding:9px 0;text-align:right;font-weight:600;border-top:1px solid #e5e7eb;">
                            {{ ucfirst($ticket->ticket_priority ?? 'Not specified') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:9px 0;color:#6b7280;border-top:1px solid #e5e7eb;">Submitted</td>
                        <td style="padding:9px 0;text-align:right;font-weight:600;border-top:1px solid #e5e7eb;">
                            {{ $ticket->created_at->format('F d, Y h:i A') }}
                        </td>
                    </tr>
                </table>
            </div>

            <div style="margin:28px 0 0;text-align:center;">
                <a href="{{ $ticketUrl }}"
                   style="display:inline-block;padding:13px 24px;background:#0d6efd;color:#ffffff;text-decoration:none;border-radius:6px;font-size:14px;font-weight:700;">
                    View Ticket #{{ $ticket->ticket_id }}
                </a>
            </div>

            <p style="margin:24px 0 0;color:#4b5563;line-height:1.7;">
                Please sign in to the admin portal to review and acknowledge this ticket.
            </p>
        </div>
        <div style="padding:22px;background:#f9fafb;border-top:1px solid #e5e7eb;text-align:center;color:#6b7280;font-size:13px;line-height:1.6;">
            This is an automated email notification from the iSTaksyon System.
        </div>
    </div>
</body>
</html>
