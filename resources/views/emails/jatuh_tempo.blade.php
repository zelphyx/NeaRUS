<!DOCTYPE html>
<html lang="id">
<head>
    <title>Peringatan Jatuh Tempo Pembayaran</title>
</head>
<body>
<h1>Peringatan Jatuh Tempo Pembayaran</h1>

<p>Halo {{ $order->name }},</p>

<p>Kami ingin mengingatkan Anda bahwa durasi sewa untuk kamar <strong>{{ $order->detail }}</strong> akan berakhir dalam 7 hari.</p>

<p><strong>Tanggal jatuh tempo:</strong> {{ \Carbon\Carbon::parse($order->duration)->format('d M Y') }}</p>

<p>Segera lakukan pembayaran untuk memperpanjang durasi sewa.</p>

<p>Terima kasih atas kepercayaan Anda.</p>

<p>Salam hormat,<br>
    {{ config('app.name') }}</p>
</body>
</html>
