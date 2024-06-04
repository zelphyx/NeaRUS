<!DOCTYPE html>
<html>
<head>
    <title>Owners</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    @vite('resources/css/app.css')

</head>
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
</style>
<body>
<aside id="default-sidebar" class="fixed top-0 left-0 z-40 h-screen transition-transform sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-gray-50 dark:bg-gray-800">
        <img class="sidebar-image mb-5" src="{{ asset('images/nearus.png') }}" alt="Nearus Logo" />
        <ul class="space-y-2 font-medium">
            <li class="flex flex-col gap-4">
                <a href="/owner-requests" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Owner Request</span>
                </a>
                <a href="/owner-details" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Owner Details</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<div class="container content">
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
            <th>Role</th>
            <th>Phone Number</th>
        </tr>
        </thead>
        <tbody>
        @foreach($owners as $owner)
            <tr>
                <td>{{ $owner->ownerId }}</td>
                <td>{{ $owner->name }}</td>
                <td>{{ $owner->email }}</td>
                <td>{{ $owner->websiterole }}</td>
                <td>{{ $owner->phonenumber }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
