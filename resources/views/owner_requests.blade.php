<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Requests</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <button onclick="window.location.href='/orders'" class="flex gap-3 items-center rounded-lg px-6 py-3 cursor-pointer transition text-neutral-600 font-medium hover:bg-[#e2e8f0] hover:text-[#1a202c] focus:outline-none focus:ring-2 focus:ring-[#cbd5e0]">
                <i class="fas fa-calendar-check w-5 h-5 text-neutral-500"></i>
                <span>Booking Data</span>
            </button>
        </div>
    </div>
</aside>

<div class="content p-6">
    <header class="header">
        <h1 class="h3">Owner Requests</h1>
    </header>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 mb-6 rounded border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <!-- Card Background -->
        <div class="content-card">
            <!-- Title Section -->
            <div class="mb-4">
                <h2 class="text-2xl font-bold text-gray-800">List Of Owners</h2>
            </div>

            <!-- Table Section -->
            <table class="min-w-full divide-y divide-blue-200 bg-white rounded-lg border border-blue-300">
                <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Owner ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Bukti</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Phone Number</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-blue-200">
                @foreach($users as $user)
                    <tr class="border-b border-blue-200">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->ownerId }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($user->buktiimage)
                                <img src="{{ $user->buktiimage }}" alt="Bukti Image" class="max-w-xs max-h-24 object-cover">
                            @else
                                No image
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $user->phonenumber }}</td>
                        <td class="px-6 py-4 text-sm">
                            <form id="approveForm{{ $user->ownerId }}" action="{{ route('owner.approve', $user->ownerId) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to approve this owner?');">
                                @csrf
                                @method('POST')
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">Approve</button>
                            </form>
                            <form id="deleteForm{{ $user->ownerId }}" action="{{ route('owner.delete', $user->ownerId) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this owner?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Custom Script -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
