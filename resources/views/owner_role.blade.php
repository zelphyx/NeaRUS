<!DOCTYPE html>
<html>
<head>
    <title>Owners</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Owners</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Owner ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
        </tr>
        </thead>
        <tbody>
        @foreach($owners as $owner)
            <tr>
                <td>{{ $owner->ownerId }}</td>
                <td>{{ $owner->name }}</td>
                <td>{{ $owner->email }}</td>
                <td>{{ $owner->phonenumber }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
