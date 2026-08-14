<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Acknowledged</title>
</head>
<body style="margin:0;padding:24px;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;">

<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">

    <!-- Header -->
    <tr>
        <td style="padding:24px;border-bottom:1px solid #e5e7eb;">
            <h2 style="margin:0;font-size:24px;font-weight:600;color:#111827;">
                Ticket Acknowledged
            </h2>
            <p style="margin:8px 0 0;font-size:14px;color:#6b7280;line-height:1.6;">
                Your request has been successfully received and acknowledged by our support team.
            </p>
        </td>
    </tr>

    <!-- Body -->
    <tr>
        <td style="padding:24px;color:#374151;font-size:15px;line-height:1.8;">

            <p style="margin-top:0;">
                Dear <strong>{{ $ticket->requestor_first_name }} {{ $ticket->requestor_last_name }}</strong>,
            </p>

            <p>
                This is an automated notification from the
                <strong>Social Technology Bureau's iSTaksyon System</strong>.
            </p>

            <p>
                Your ticket has been <strong>acknowledged</strong> and is now under review by our team.
                We are currently processing your request and will notify you whenever there are updates
                to its status or once it has been resolved.
            </p>

            <!-- Ticket Information -->
            <table width="100%" cellpadding="0" cellspacing="0"
                style="margin:28px 0;border:1px solid #e5e7eb;border-radius:10px;background:#f9fafb;">
                <tr>
                    <td style="padding:18px;">

                        <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px;">
                            <tr>
                                <td style="padding:8px 0;color:#6b7280;">Ticket ID</td>
                                <td align="right" style="font-weight:600;color:#111827;">
                                    #{{ $ticket->ticket_id }}
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:8px 0;color:#6b7280;">Status</td>
                                <td align="right">
                                    <span style="display:inline-block;padding:4px 12px;background:#ecfdf5;border:1px solid #bbf7d0;border-radius:999px;color:#166534;font-size:12px;font-weight:600;">
                                        Acknowledged
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding:8px 0;color:#6b7280;">Submitted On</td>
                                <td align="right" style="color:#111827;">
                                    {{ $ticket->created_at->format('F d, Y h:i A') }}
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

            <p style="margin-bottom:0;">
                Thank you for using the
                <strong>Social Technology Bureau's iSTaksyon System</strong>.
            </p>

        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f9fafb;padding:24px;border-top:1px solid #e5e7eb;text-align:center;font-family:Arial,Helvetica,sans-serif;">

            <div style="font-size:15px;font-weight:600;color:#111827;">
                iSTaksyon System
            </div>

            <div style="margin-top:4px;font-size:13px;color:#4b5563;line-height:1.6;">
                Social Technology Bureau<br>
                Department of Social Welfare and Development
            </div>

            <div style="width:48px;height:1px;background:#d1d5db;margin:18px auto;"></div>

            <div style="font-size:12px;color:#6b7280;line-height:1.7;">
                This is an automated system-generated notification.<br>
                Please do not reply to this email.
            </div>

        </td>
    </tr>

</table>

</body>
</html>