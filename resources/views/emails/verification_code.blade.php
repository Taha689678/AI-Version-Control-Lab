<!DOCTYPE html>
<html>
<head>
    <title>Verification Code</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;">
        <h2 style="color: #6c757d; text-align: center;">Welcome to Ali Academy!</h2>
        <p>Dear {{ $user->name }},</p>
        <p>Thank you for registering. Please use the following verification code to verify your email address:</p>
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #0d6efd; background-color: #f8f9fa; padding: 10px 20px; border-radius: 5px; border: 1px dashed #0d6efd;">
                {{ $code }}
            </span>
        </div>
        <p>If you did not create an account, no further action is required.</p>
        <p>Best regards,<br>The Ali Academy Team</p>
    </div>
</body>
</html>
