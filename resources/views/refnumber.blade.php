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
            <h1 class="h3">Orders</h1>
        </div>
    </header>

    <form id="searchForm">
        <div class="mb-3">
            <label for="refnumber" class="form-label">Reference Number</label>
            <input type="text" class="form-control" id="refnumber" name="refnumber" placeholder="Enter Reference Number">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div id="ordersTable" class="mt-4">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Reference Number</th>
                <th>Nama Penyewa</th>
                <th>No HP</th>
                <th>Detail</th>
                <th>Tanggal Sewa</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            @foreach($refnumbers as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->refnumber }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->phonenumber }}</td>
                    <td>{{ $order->detail }}</td>
                    <td>{{ $order->duration }}</td>
                    <td>{{ $order->price }}</td>
                    <td>{{ $order->status }}</td>
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
