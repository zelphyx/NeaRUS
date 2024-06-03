<!DOCTYPE html>
<html>
<head>
    <title>Owner Requests</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Owner Requests</h1>
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
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->ownerId }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phonenumber }}</td>
                <td>
                    <form action="{{ route('owner.approve', $user->ownerId) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to approve this owner?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                    <form action="{{ route('owner.delete', $user->ownerId) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this owner?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    window.Echo.channel('owner-request')
        .listen('OwnerRequestUpdated', (e) => {
            let user = e.user;
            location.reload();
        });
</script>

<!-- Bootstrap JS  -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
