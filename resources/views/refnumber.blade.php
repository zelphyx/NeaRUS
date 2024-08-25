<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
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
        </div>
    </div>
</aside>

<div class="container content">
    <header class="header">
        <h1 class="h3">Orders</h1>
    </header>


    <form id="searchForm" class="mb-3">
        <div class="mb-3">
            <label for="refnumber" class="form-label text-lg">Reference Number</label>
            <input type="text" class="form-control text-lg py-3 px-4 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500"
                   id="refnumber" name="refnumber" placeholder="Enter Reference Number">
        </div>
        <button type="submit" class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg text-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            Search
        </button>
    </form>


    <div id="ordersTable" class="mt-4 overflow-x-auto">
        <table class="min-w-full divide-y divide-blue-200 bg-white shadow-lg rounded-lg border border-blue-300">
            <thead class="bg-blue-500 text-white">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Reference Number</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Nama Penyewa</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">No HP</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Detail</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Tanggal Sewa</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Status</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-blue-200">
            @foreach($refnumbers as $order)
                <tr class="border-b border-blue-200">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->id }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->refnumber }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->phonenumber }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->detail }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->duration }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->price }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $order->status }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function(){
        $('#searchForm').on('submit', function(e){
            e.preventDefault();

            var refnumber = $('#refnumber').val();

            $.ajax({
                url: '{{ route('searchrefnumber') }}',
                method: 'POST',
                data: {
                    refnumber: refnumber,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if(response.success) {
                        var orders = response.data;
                        var tbody = '';
                        orders.forEach(function(order) {
                            tbody += '<tr>';
                            tbody += '<td>' + order.id + '</td>';
                            tbody += '<td>' + order.refnumber + '</td>';
                            tbody += '<td>' + order.name + '</td>';
                            tbody += '<td>' + order.phonenumber + '</td>';
                            tbody += '<td>' + order.detail + '</td>';
                            tbody += '<td>' + order.duration + '</td>';
                            tbody += '<td>' + order.price + '</td>';
                            tbody += '<td>' + order.status + '</td>';
                            tbody += '</tr>';
                        });
                        $('tbody').html(tbody);
                    }
                }
            });
        });
    });
</script>
</body>
</html>
