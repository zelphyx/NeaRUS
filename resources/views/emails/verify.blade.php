<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
<h1>Email Verification</h1>
<p>Dear {{ $user->name }},</p>
<p>Please click the following link to verify your email address:</p>
<a href="{{ route('verify.email', $user->email_verification_token) }}">Verify Email</a>
<p>If you didn't request this verification, you can ignore this email.</p>
</body>
</html>
