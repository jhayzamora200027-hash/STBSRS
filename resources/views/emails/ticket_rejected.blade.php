<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Rejected</title>
</head>
<body style="margin:0;padding:24px;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#374151;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
        <tr>
            <td style="padding:24px;background:#fff7ed;border-bottom:1px solid #fed7aa;">
                <h2 style="margin:0;color:#9a3412;font-size:24px;">Ticket Rejected</h2>
                <p style="margin:8px 0 0;color:#7c2d12;line-height:1.6;">
                    Your service request has been reviewed and rejected by our support team.
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding:24px;font-size:15px;line-height:1.8;">
                <p style="margin-top:0;">
                    Dear <strong>{{ $ticket->requestor_first_name }} {{ $ticket->requestor_last_name }}</strong>,
                </p>

                <p>
                    Ticket <strong>#{{ $ticket->ticket_id }}</strong> has been marked as rejected.
                </p>

                @if($resolution?->resolution_text)
                    <div style="margin:24px 0;padding:16px;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;">
                        <strong>Details</strong>
                        <p style="margin:8px 0 0;white-space:pre-line;">{{ $resolution->resolution_text }}</p>
                    </div>
                @endif

                <p>
                    For additional assistance, please contact the Social Technology Bureau or submit a new service request through the iSTAksyon System.
                </p>

                <div style="text-align:center;margin:30px 0 8px;">
                    <a href="{{ config('app.url') }}" style="display:inline-block;background:#9a3412;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:8px;font-weight:bold;">
                        Open iSTAksyon System
                    </a>
                </div>
            </td>
        </tr>
        <tr>
            <td style="background:#f8fafc;padding:20px;border-top:1px solid #e5e7eb;text-align:center;font-size:12px;color:#6b7280;line-height:1.6;">
                <strong>iSTAksyon System</strong><br>
                Social Technology Bureau<br>
                Department of Social Welfare and Development
            </td>
        </tr>
    </table>
</body>
</html>