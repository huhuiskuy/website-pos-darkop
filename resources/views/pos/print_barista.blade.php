<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Barista - {{ $transaksi->kode_transaksi }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px; /* Huruf sedikit lebih besar untuk barista */
            color: #000;
            margin: 0;
            padding: 20px;
            width: 80mm;
        }
        
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        .fw-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mt-2 { margin-top: 8px; }
        
        .divider {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 4px 0;
            vertical-align: top;
        }

        .header h1 {
            font-size: 22px;
            margin: 0 0 5px 0;
        }
        
        /* Auto print ketika halaman diload */
        @media print {
            body {
                width: 100%;
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print(); setTimeout(window.close, 500);">

    <!-- HEADER BARISTA -->
    <div class="header text-center mb-2">
        <h1>STRUK BARISTA</h1>
    </div>

    <div class="divider"></div>

    <!-- INFO PESANAN -->
    <table class="mb-2">
        <tr>
            <td class="text-left" style="width: 35%;">No. TRX</td>
            <td class="text-left fw-bold">: {{ $transaksi->kode_transaksi }}</td>
        </tr>
        <tr>
            <td class="text-left">Waktu</td>
            <td class="text-left">: {{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="text-left">Tipe</td>
            <td class="text-left fw-bold" style="font-size: 16px;">: {{ strtoupper($transaksi->tipe_pesanan) }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- DAFTAR ITEM (Hanya QTY dan Nama) -->
    <table class="mb-2">
        <tr>
            <td class="fw-bold" style="width: 20%; border-bottom: 1px solid #000; padding-bottom: 5px;">QTY</td>
            <td class="fw-bold" style="border-bottom: 1px solid #000; padding-bottom: 5px;">MENU</td>
        </tr>
        @foreach($transaksi->detail_transaksis as $detail)
        <tr>
            <td class="text-left fw-bold" style="font-size: 16px;">{{ $detail->qty }}x</td>
            <td class="text-left fw-bold">{{ $detail->menu->nama_menu }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>
    <div class="text-center mt-2">
        <p class="mb-1">--- Akhir Struk Barista ---</p>
    </div>

</body>
</html>
