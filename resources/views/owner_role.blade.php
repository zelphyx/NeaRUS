<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owners</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            display: flex;
            overflow-x: hidden;
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            border-right: 1px solid #e2e8f0;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar-image {
            width: 80%;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            flex-grow: 1;
        }
        .sidebar ul li {
            margin-bottom: 15px;
        }
        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: #2d3748;
            text-decoration: none;
            font-weight: 500;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar ul li a svg, .sidebar ul li a i {
            margin-right: 10px;
            font-size: 1.25rem;
        }
        .sidebar ul li a:hover {
            background-color: #e2e8f0;
            color: #1a202c;
        }
        .header {
            padding: 20px;
            background-color: #fff;
            border-bottom: 1px solid #e2e8f0;
            width: calc(100% - 250px);
            position: fixed;
            top: 0;
            left: 250px;
            z-index: 1000;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
            color: #2d3748;
        }
        .content {
            margin-top: 80px; /* Add margin to account for header height */
            padding: 20px;
            width: calc(100% - 250px);
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }
        .content-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            height: calc(100vh - 80px); /* Full height minus header */
            box-sizing: border-box;
        }
        @media (max-width: 768px) {
            .header {
                left: 0;
                width: 100%;
            }
            .content {
                margin-left: 0;
                width: 100%;
            }
            .sidebar {
                position: static;
                width: 100%;
                box-shadow: none;
            }
            .content-card {
                height: auto;
            }
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .sidebar-logo-bottom {
            margin-top: 20px;
            text-align: center;
        }
        .sidebar-logo-bottom img {
            width: 60%;
        }
        .logout-button {
            padding: 10px 15px;
            color: #2d3748;
            text-decoration: none;
            font-weight: 500;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s, color 0.3s;
        }
        .logout-button i {
            margin-right: 10px;
            font-size: 1.25rem;
        }
        .logout-button:hover {
            background-color: #e2e8f0;
            color: #1a202c;
        }
        button {
            background: none;
            border: none;
            font-size: 1rem;
            color: inherit;
            display: flex;
            align-items: center;
        }

        button:hover {
            background-color: #e2e8f0;
            color: #1a202c;
        }

        button:focus {
            outline: none;
            box-shadow: 0 0 0 2px #cbd5e0;
        }
    </style>
</head>
<body>
<aside class="sidebar">
    <div>
        <div class="p-4 text-2xl font-bold border-b-[0.5px]">
            <img class="w-[120px] h-auto mx-auto" src="{{ asset('images/nearus.png') }}" alt="Nearus Logo">
        </div>
        <p class="text-neutral-500 pl-16 mt-4 text-[16px]">Main Menu</p>
        <div class="flex flex-col mt-3">
            <button onclick="window.location.href='/owner-requests'" class="flex gap-3 items-center rounded-lg px-6 py-3 cursor-pointer transition text-neutral-600 font-medium hover:bg-[#e2e8f0] hover:text-[#1a202c] focus:outline-none focus:ring-2 focus:ring-[#cbd5e0]">
                <i class="fas fa-file-alt w-5 h-5 text-neutral-500"></i>
                <span>Owner Requests</span>
            </button>
            <button onclick="window.location.href='/owners'" class="flex gap-3 items-center rounded-lg px-6 py-3 cursor-pointer transition text-neutral-600 font-medium hover:bg-[#e2e8f0] hover:text-[#1a202c] focus:outline-none focus:ring-2 focus:ring-[#cbd5e0]">
                <i class="fas fa-users w-5 h-5 text-neutral-500"></i>
                <span>List Of Owners</span>
            </button>
        </div>
    </div>

    <div class="mb-6">
        <a href="{{ route('logout') }}" class="flex gap-3 items-center rounded-lg pl-6 py-2 cursor-pointer transition text-neutral-600 font-medium hover:bg-[#F5F5F5] hover:text-[#2D2D2D]">
            <i class="fas fa-door-open w-5 h-5 text-neutral-500"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>

<header class="header">
    <h1 class="h3">Owner Management</h1>
</header>

<div class="content">
    <div class="content-card">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <!-- Title Section -->
            <div class="mb-4">
                <h2 class="text-2xl font-bold text-gray-800">List Of Owners</h2>
            </div>

            <!-- Table Section -->
            <table class="min-w-full divide-y divide-blue-200 bg-white shadow-lg rounded-lg border border-blue-300 b">
                <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Owner ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Phone Number</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-blue-200">
                @foreach($owners as $owner)
                    <tr class="border-b border-blue-200">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $owner->ownerId }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $owner->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $owner->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $owner->phonenumber }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
