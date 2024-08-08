<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <!-- Include Bootstrap for styling (optional) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Orders</h1>

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

<!-- Include jQuery and Bootstrap JS (optional) -->
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
                            {{--<td>{{ $order->phonenumber }}</td>--}}
                            {{--<td>{{ $order->detail }}</td>--}}
                            {{--<td>{{ $order->duration }}</td>--}}
                            {{--<td>{{ $order->price }}</td>--}}
                            {{--<td>{{ $order->status }}</td>--}}

                            tbody += '<td>' + order.name + '</td>'; // Adjust based on your actual field names
                            tbody += '<td>' + order.phonenumber + '</td>'; // Adjust based on your actual field names
                            tbody += '<td>' + order.detail + '</td>'; // Adjust based on your actual field names
                            tbody += '<td>' + order.duration + '</td>'; // Adjust based on your actual field names
                            tbody += '<td>' + order.price + '</td>'; // Adjust based on your actual field names
                            tbody += '<td>' + order.status + '</td>'; // Adjust based on your actual field names
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
