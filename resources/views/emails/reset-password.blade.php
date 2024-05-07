<!DOCTYPE html>
<html>
<head>
    <title>Reset Password Notification</title>
</head>
<body>
<h2>Reset Password Notification</h2>
<p>Hello {{ $user->name }},</p>
<p>You are receiving this email because we received a password reset request for your account.</p>
<p>Please click the following link to reset your password:</p>
<p><a href="{{ $resetLink }}">Reset Password</a></p>
<p>If you did not request a password reset, no further action is required.</p>
</body>
</html>
