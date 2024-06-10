<!DOCTYPE html>
<html>
<head>
    <title>Owners</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            display: flex;
            overflow-x: hidden;
        }
        .content {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
            width: calc(100% - 250px);
        }
        .sidebar-hidden .content {
            margin-left: 0;
            width: 100%;
        }
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                width: 100%;
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
</head>
<body class="sidebar-visible">
<aside id="default-sidebar" class="fixed top-0 left-0 z-40 h-full transition-transform bg-gray-50 dark:bg-gray-800" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <img class="sidebar-image mb-3" src="{{ asset('images/nearus.png') }}" alt="Nearus Logo" />
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/owner-requests" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ml-3">Owner Requests</span>
                </a>
                <a href="/owners" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ml-3">Owners</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
<div class="container content">
    <header class="header">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Owner Management</h1>

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
            <th>Phone Number</th>
        </tr>
        </thead>
        <tbody id="ownerTableBody">
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
