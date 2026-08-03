<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran - {{ $transaksi->kode_transaksi }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 20px;
            width: 80mm; /* Standar thermal printer 80mm */
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        
        .fw-bold { font-weight: bold; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
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
            padding: 2px 0;
            vertical-align: top;
        }

        .header h1 {
            font-size: 20px;
            margin: 0 0 5px 0;
        }
        .header p {
            margin: 0;
        }

        /* Auto print ketika halaman diload */
        @media print {
            body {
                width: 100%; /* Biar otomatis ngikutin kertas printer */
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print(); setTimeout(window.close, 500);">

    <!-- HEADER STRUK -->
    <div class="header text-center mb-3">
        <h1>DariKopi</h1>
        <p>Jalan Mindi No.63 RT 003 RW 007, Koja, Jakarta Utara, Jakarta, Indonesia</p>
    </div>

    <div class="divider"></div>

    <!-- INFO TRANSAKSI -->
    <table class="mb-2">
        <tr>
            <td class="text-left">Waktu</td>
            <td class="text-right">{{ $transaksi->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td class="text-left">No. TRX</td>
            <td class="text-right">{{ $transaksi->kode_transaksi }}</td>
        </tr>
        <tr>
            <td class="text-left">Pesanan</td>
            <td class="text-right">{{ $transaksi->tipe_pesanan }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- DAFTAR ITEM -->
    <table class="mb-2">
        @foreach($transaksi->detail_transaksis as $detail)
        <tr>
            <td colspan="3" class="text-left fw-bold">{{ $detail->menu->nama_menu }}</td>
        </tr>
        <tr>
            <td class="text-left" style="width: 25%;">{{ $detail->qty }} x</td>
            <td class="text-left" style="width: 45%;">{{ number_format($detail->menu->harga, 0, ',', '.') }}</td>
            <td class="text-right" style="width: 30%;">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <!-- TOTAL DAN PEMBAYARAN -->
    <table>
        <tr>
            <td class="text-left fw-bold">TOTAL</td>
            <td class="text-right fw-bold">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-left">Metode</td>
            <td class="text-right">{{ $transaksi->metode_pembayaran }}</td>
        </tr>
        <tr>
            <td class="text-left">Bayar</td>
            <td class="text-right">Rp{{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="text-left">Kembalian</td>
            <td class="text-right">Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <!-- FOOTER -->
    <div class="text-center mt-2">
        <p class="mb-1 fw-bold">Terima Kasih!</p>
        <p class="mb-1">Silakan berkunjung kembali</p>
        <p class="fw-bold">#Darikopihariankamu</p>
    </div>

</body>
</html>
