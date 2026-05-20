<!DOCTYPE html>
<html>
<head>
    <title>Leave Status Update</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Hello {{ $leaveRequest->student->user->name }},</h2>
    
    <p>Your leave request has been updated.</p>
    
    <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #6c5ce7; margin: 20px 0;">
        <p><strong>Reason:</strong> {{ $leaveRequest->reason }}</p>
        <p><strong>Status:</strong> <span style="text-transform: uppercase; font-weight: bold; color: {{ $leaveRequest->status == 'approved' ? 'green' : 'red' }};">{{ $leaveRequest->status }}</span></p>
    </div>

    <p>Please login to your dashboard for more details.</p>
    
    <br>
    <p>Best Regards,<br>Ali Academy Administration</p>
</body>
</html>
