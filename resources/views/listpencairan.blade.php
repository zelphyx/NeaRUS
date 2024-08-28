<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pencairan</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
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
        .sidebar ul li a i {
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
        .content {
            margin-top: 80px;
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
            height: calc(100vh - 80px);
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
    </style>
</head>
<body class="sidebar-visible">
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
            <button onclick="window.location.href='/pencairan'" class="flex gap-3 items-center rounded-lg px-6 py-3 cursor-pointer transition text-neutral-600 font-medium hover:bg-[#e2e8f0] hover:text-[#1a202c] focus:outline-none focus:ring-2 focus:ring-[#cbd5e0]">
                <i class="fas fa-money-bill w-5 h-5 text-neutral-500"></i>
                <span>Request Pencairan</span>
            </button>
        </div>
    </div>
</aside>

<div class="container content">
    <header class="header">
        <h1 class="h3">Data Pencairan</h1>
    </header>

    <form id="searchForm" class="mb-3">
        <div class="mb-3">
            <label for="name" class="form-label text-lg">Nama</label>
            <input type="text" class="form-control text-lg py-3 px-4 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                   id="name" name="name" placeholder="Enter Name">
        </div>
        <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            Search
        </button>
    </form>

    <div id="pencairanTable" class="mt-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-blue-200 bg-white shadow-lg rounded-lg border border-blue-300">
            <thead class="bg-blue-500 text-white">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">No HP</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Jumlah (Rp.)</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Aksi</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-200">
            @foreach($pencairan as $item)
                <tr class="border-b border-blue-200">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item->phonenumber }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $item->amount }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">
                        <form action="{{ route('approve.cair', $item->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        $('#searchForm').on('submit', function(e){
            e.preventDefault();

            var name = $('#name').val();

            $.ajax({
                url: '{{ route('searchpencairan') }}',
                method: 'POST',
                data: {
                    name: name,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        var pencairan = response.data;
                        var tbody = '';
                        pencairan.forEach(function(item) {
                            tbody += '<tr>';
                            tbody += '<td>' + item.id + '</td>';
                            tbody += '<td>' + item.name + '</td>';
                            tbody += '<td>' + item.phonenumber + '</td>';
                            tbody += '<td>' + item.amount + '</td>';
                            tbody += '<td><a href="/pencairan/approve/' + item.id + '" class="btn btn-success">Approve</a></td>';
                            tbody += '</tr>';
                        });
                        $('#pencairanTable tbody').html(tbody);
                    }
                }
            });
        });
    });
</script>
</body>
</html>
