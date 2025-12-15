<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TMN Membership Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
        <div style="text-align: center; margin-bottom: 20px;">
            <!-- ✅ Use an absolute URL for Gmail compatibility -->
            <img src="{{ asset('images/logo.svg') }}" alt="TMN Logo" style="width:120px;">
            <!-- OR if hosted publicly (recommended for emails):
            <img src="https://yourdomain.com/images/logo.svg" alt="TMN Logo" style="width:120px;">
            -->
        </div>

        <h2 style="color: #CF2031; text-align:center;">Welcome to TMN, {{ $name }}!</h2>
        <p style="color: #333;">We’re thrilled to invite you to join The TMN Network! Please click the button below to complete your membership registration:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $link }}" style="background-color: #CF2031; color: #fff; padding: 12px 22px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                Complete Registration
            </a>
        </div>

        <p style="font-size: 14px; color: #555;">If the button doesn’t work, copy and paste this link into your browser:</p>
        <p style="font-size: 13px; color: #888; word-break: break-all;">{{ $link }}</p>

        <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
        <p style="text-align: center; font-size: 13px; color: #777;">
            © {{ date('Y') }} TMN. All rights reserved. <br>
            <a href="mailto:support@tmn.in" style="color: #CF2031;">Contact Support</a>
        </p>
    </div>
</body>
</html>
