<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
<h2>Confirm Password</h2>
<p>Please confirm your new password below:</p>
<form method="POST" action="{{ url('/reset-password') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <label for="password">New Password:</label>
    <input type="password" name="password" id="password" required>
    <label for="password_confirmation">Confirm New Password:</label>
    <input type="password" name="password_confirmation" id="password_confirmation" required>
    <button type="submit">Reset Password</button>
</form>
</body>
</html>
