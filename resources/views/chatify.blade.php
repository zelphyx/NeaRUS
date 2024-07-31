<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatify</title>
    <link href="{{ asset('css/chatify.css') }}" rel="stylesheet">
    <script src="{{ asset('js/chatify.js') }}" defer></script>
</head>
<body>
<div id="app">
    @include('vendor.Chatify.pages.app')
</div>
</body>
</html>
