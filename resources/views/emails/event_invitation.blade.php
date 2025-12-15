<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TMN Event Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f9fafb; padding:30px;">
    <div style="max-width:600px;margin:auto;background:white;padding:25px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.1)">
        <h2 style="color:#C62828;">You're Invited to a TMN Chapter Event 🎉</h2>

        <p>Dear {{ $invitation->guest_name }},</p>

        <p>You have been invited to attend the following TMN Chapter event:</p>

        <table style="width:100%;margin-top:15px;margin-bottom:15px">
            <tr>
                <td><strong>Event:</strong></td>
                <td>{{ $invitation->event->title }}</td>
            </tr>
            <tr>
                <td><strong>Date:</strong></td>
                <td>{{ \Carbon\Carbon::parse($invitation->event->event_date)->format('l, d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Venue:</strong></td>
                <td>{{ $invitation->event->venue_name ?? 'To be announced' }}</td>
            </tr>
            <tr>
                <td><strong>City:</strong></td>
                <td>{{ $invitation->event->city ?? '—' }}</td>
            </tr>
        </table>

        <p><strong>Invited By:</strong> {{ $invitation->inviter->name ?? 'TMN Member' }}</p>

        <p style="margin-top:20px;">We would be delighted to have you join us. Please confirm your attendance.</p>

        <p style="margin-top:25px;">
            <a href="#" style="background:#E53935;color:white;padding:10px 18px;border-radius:6px;text-decoration:none;">Confirm Attendance</a>
        </p>

        <hr style="margin:25px 0;border:none;border-top:1px solid #eee;">
        <p style="font-size:12px;color:#999;">This invitation was sent by TMN. Please do not reply to this automated email.</p>
    </div>
</body>
</html>
