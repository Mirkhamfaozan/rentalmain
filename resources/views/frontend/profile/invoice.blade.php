<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            color: #333;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 24pt;
        }
        .header p {
            margin: 5px 0;
            font-size: 12pt;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            color: #007bff;
            font-size: 16pt;
            margin-bottom: 10px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }
        .company-info, .invoice-info {
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
        .invoice-info {
            text-align: right;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }
        .col-md-6 {
            width: 48%;
            margin-right: 2%;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        .table .fw-bold {
            font-weight: bold;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 10pt;
            color: white;
        }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: #333; }
        .bg-danger { background-color: #dc3545; }
        .bg-secondary { background-color: #6c757d; }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 10px;
        }
        .product-details {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        ul {
            padding-left: 20px;
            margin: 0;
        }
        hr {
            border: 0;
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 10pt;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Invoice Transaksi</h1>
            <p>Rincian Pesanan #{{ $order->id }}</p>
        </div>

        <!-- Company and Invoice Info -->
        <div class="section">
            <div class="company-info">
                <h4>{{ $order->product->user->rentalBiodata->nama_rental ?? 'PT. Motor Rental Indonesia' }}</h4>
                <p>{{ $order->product->user->rentalBiodata->getFullAddress() ?? 'Jl. Contoh No. 123, Jakarta, Indonesia' }}</p>
                <p>Email: {{ $order->product->user->rentalBiodata->email_perusahaan ?? 'info@motorrental.id' }}</p>
                <p>WhatsApp: {{ $order->product->user->rentalBiodata->no_wa ?? '+62 812-3456-7890' }}</p>
            </div>
            <div class="invoice-info">
                <h4>INVOICE</h4>
                <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }}</p>
                <p>Nomor Pesanan: #{{ $order->id }}</p>
            </div>
        </div>

        <hr>

        <!-- Customer Information -->
        <div class="section">
            <h2>Informasi Pelanggan</h2>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> {{ $order->name }}</p>
                    <p><strong>Email:</strong> {{ $order->email }}</p>
                    <p><strong>No. Telepon:</strong> {{ $order->phone_number }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Alamat Pengambilan:</strong> {{ $order->lokasi_pengambilan }}</p>
                    <p><strong>Alamat Pengembalian:</strong> {{ $order->lokasi_pengembalian }}</p>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="section">
            <h2>Detail Pesanan</h2>
            <p><strong>Status Pesanan:</strong> <span class="badge {{ $order->status == 'confirmed' ? 'bg-success' : ($order->status == 'pending' ? 'bg-warning text-dark' : ($order->status == 'ditolak' ? 'bg-danger' : 'bg-secondary')) }}">{{ $order->getStatusLabelAttribute() }}</span></p>
            <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->translatedFormat('d F Y, H:i') }}</p>
            <p><strong>Catatan:</strong> {{ $order->catatan ?? 'Tidak ada catatan' }}</p>
            @if ($order->status == 'ditolak')
                <p><strong>Alasan Penolakan:</strong> {{ $order->catatan_ditolak ?? 'Tidak ada catatan tambahan' }}</p>
            @endif
        </div>

        <!-- Product Details -->
        <div class="section">
            <h2>Detail Produk</h2>
            <div class="product-details">
                @if ($order->product->gambar_utama)
                    <img src="{{ asset(Storage::url($order->product->gambar_utama)) }}" class="product-image" alt="Product Image">
                @else
                    <img src="{{ asset('/images/placeholder.jpg') }}" class="product-image" alt="Placeholder Image">
                @endif
                <div>
                    <h4>{{ $order->product->nama_motor }}</h4>
                    <p>{{ $order->product->brand->name ?? '-' }}</p>
                </div>
            </div>
            <p><strong>Tipe Sewa:</strong> {{ ucfirst($order->tipe_sewa) }}</p>
            <p><strong>Durasi Sewa:</strong> {{ $order->durasi_hari }} hari</p>
            <p><strong>Tanggal Mulai:</strong> {{ $order->tanggal_mulai->translatedFormat('d F Y') }} {{ $order->waktu_mulai ? $order->waktu_mulai->format('H:i') : '00:00' }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ $order->tanggal_selesai->translatedFormat('d F Y') }} {{ $order->waktu_selesai ? $order->waktu_selesai->format('H:i') : '00:00' }}</p>
            <p><strong>Harga Harian:</strong> Rp {{ number_format($order->product->harga_harian, 0, ',', '.') }}</p>
            @if ($order->tipe_sewa == 'mingguan')
                <p><strong>Harga Mingguan:</strong> Rp {{ number_format($order->product->harga_mingguan, 0, ',', '.') }}</p>
            @elseif ($order->tipe_sewa == 'bulanan')
                <p><strong>Harga Bulanan:</strong> Rp {{ number_format($order->product->harga_bulanan, 0, ',', '.') }}</p>
            @endif
        </div>

        <!-- Cost Breakdown -->
        <div class="section">
            <h2>Rincian Biaya</h2>
            <table class="table">
                <tbody>
                    <tr>
                        <td>Subtotal (Harga Sewa)</td>
                        <td class="text-end">Rp {{ number_format($order->product->calculatePrice($order->durasi_hari, $order->tipe_sewa), 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Biaya Admin</td>
                        <td class="text-end">Rp {{ number_format($order->fee, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Ongkos Kirim</td>
                        <td class="text-end">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="fw-bold">
                        <td>Total Biaya</td>
                        <td class="text-end">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Payment Information -->
        <div class="section">
            <h2>Informasi Pembayaran</h2>
            @if ($order->hasPayment())
                <p><strong>ID Transaksi:</strong> {{ $order->payment->transaction_id }}</p>
                <p><strong>Jenis Pembayaran:</strong> {{ ucfirst($order->payment->payment_type) }}</p>
                <p><strong>Status Pembayaran:</strong> <span class="badge {{ $order->payment->status == 'success' ? 'bg-success' : ($order->payment->status == 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">{{ $order->payment->getStatusLabelAttribute() }}</span></p>
                <p><strong>Waktu Transaksi:</strong> {{ $order->payment->transaction_time ? $order->payment->transaction_time->translatedFormat('d F Y, H:i') : '-' }}</p>
                @if ($order->payment->expiry_time)
                    <p><strong>Batas Waktu Pembayaran:</strong> {{ $order->payment->expiry_time->translatedFormat('d F Y, H:i') }}</p>
                @endif
                @if ($order->payment->bank)
                    <p><strong>Bank:</strong> {{ strtoupper($order->payment->bank) }}</p>
                @endif
                @if ($order->payment->va_number)
                    <p><strong>Nomor VA:</strong> {{ $order->payment->va_number }}</p>
                @endif
                @if ($order->payment->payment_code)
                    <p><strong>Kode Pembayaran:</strong> {{ $order->payment->payment_code }}</p>
                @endif
            @else
                <p><strong>Status Pembayaran:</strong> <span class="badge bg-warning text-dark">Belum dibayar</span></p>
            @endif
        </div>

        <!-- Policy and Notes -->
        <div class="section">
            <h2>Kebijakan dan Catatan</h2>
            <ul>
                <li>Pembayaran harus dilakukan sebelum batas waktu yang ditentukan untuk menghindari pembatalan pesanan.</li>
                <li>Pastikan motor dikembalikan sesuai jadwal untuk menghindari denda tambahan.</li>
                <li>Untuk pertanyaan atau bantuan, hubungi kami melalui WhatsApp atau email.</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah menggunakan layanan kami!</p>
            <p>{{ $order->product->user->rentalBiodata->nama_rental ?? 'PT. Motor Rental Indonesia' }}</p>
        </div>
    </div>
</body>
</html>
