<html>
<head>
    <title>Owner Requests</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            overflow-x: hidden;
        }
        #default-sidebar {
            width: 250px;
            transition: transform 0.3s ease;
        }
        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            width: calc(100% - 250px);
        }
        .sidebar-hidden #default-sidebar {
            transform: translateX(-250px);
        }
        .sidebar-hidden .content {
            margin-left: 0;
            width: 100%;
        }
        @media (max-width: 768px) {
            #default-sidebar {
                transform: translateX(-250px);
            }
            .content {
                margin-left: 0;
                width: 100%;
            }
            .sidebar-visible #default-sidebar {
                transform: translateX(0);
            }
            .sidebar-visible .content {
                margin-left: 250px;
                width: calc(100% - 250px);
            }
        }
        .sidebar-image {
            width: 100%;
            padding: 10px 0;
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body class="sidebar-visible">
<aside id="default-sidebar" class="fixed top-0 left-0 z-40 h-screen transition-transform sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <img class="sidebar-image mb-3" src="{{ asset('images/nearus.png') }}" alt="Nearus Logo" />
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/owner-requests" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Owner Requests</span>
                </a>
                <a href="/owners" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Owners</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<div class="container content">
    <header class="header">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Owner Requests</h1>

        </div>
    </header>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th>Owner ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Bukti</th>
            <th>Phone Number</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="ownerTableBody">
        @foreach($users as $user)
            <tr id="row{{ $user->ownerId }}">
                <td>{{ $user->ownerId }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->image }}</td>
                <td>{{ $user->phonenumber }}</td>
                <td>
                    <form id="approveForm{{ $user->ownerId }}" action="{{ route('owner.approve', $user->ownerId) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to approve this owner?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                    <form id="deleteForm{{ $user->ownerId }}" action="{{ route('owner.delete', $user->ownerId) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this owner?');">
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

<!-- Custom Script -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>

</script>

<!-- Bootstrap JS  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
