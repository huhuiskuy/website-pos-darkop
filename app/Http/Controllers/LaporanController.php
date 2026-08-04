<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\BahanBaku;
use App\Models\StokOpname;
use Illuminate\Support\Facades\Response;

class LaporanController extends Controller
{
    // Halaman Laporan Penjualan (Ringkasan)
    public function index(Request $request)
    {
        $startDate = $request->start_date ?? now()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');

        // Ambil semua transaksi
        $transaksisAll = Transaksi::with('detail_transaksis.menu.kategori')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        $transaksis = $transaksisAll->where('status', '!=', 'Batal');
        $transaksisBatal = $transaksisAll->where('status', '===', 'Batal');

        if ($request->has('export')) {
            return $this->exportPenjualan($transaksis, $startDate, $endDate);
        }

        // Agregasi
        $totalPenjualanBersih = $transaksis->sum('total_harga'); 
        $totalPesananBatal = $transaksisBatal->sum('total_harga');
        $totalPenjualanKotor = $totalPenjualanBersih + $totalPesananBatal;
        $totalTransaksi = $transaksis->count();

        // Metode Pembayaran
        $metodePembayaran = $transaksis->groupBy('metode_pembayaran')->map(function($row) {
            return [
                'metode' => $row->first()->metode_pembayaran,
                'jumlah_transaksi' => $row->count(),
                'total_pendapatan' => $row->sum('total_harga')
            ];
        });

        // Jenis Penjualan (Tipe Pesanan)
        $jenisPenjualan = $transaksis->groupBy('tipe_pesanan')->map(function($row) {
            return [
                'jenis' => $row->first()->tipe_pesanan,
                'jumlah_transaksi' => $row->count(),
                'total_pendapatan' => $row->sum('total_harga')
            ];
        });

        // Penjualan Menu
        $menuSales = [];
        $kategoriSales = [];

        foreach ($transaksisAll as $trx) {
            $isBatal = $trx->status === 'Batal';
            foreach ($trx->detail_transaksis as $detail) {
                $menu = $detail->menu;
                if (!$menu) continue;

                $menuName = $menu->nama_menu;
                $kategoriName = $menu->kategori ? $menu->kategori->nama_kategori : 'Lainnya';
                $subtotal = $detail->subtotal;
                $qty = $detail->qty;

                // Hitung Menu
                if (!isset($menuSales[$menuName])) {
                    $menuSales[$menuName] = [
                        'menu' => $menuName,
                        'kategori' => $kategoriName,
                        'terjual' => 0,
                        'pendapatan' => 0,
                        'terjual_batal' => 0,
                        'pendapatan_batal' => 0
                    ];
                }

                // Hitung Kategori
                if (!isset($kategoriSales[$kategoriName])) {
                    $kategoriSales[$kategoriName] = [
                        'kategori' => $kategoriName,
                        'terjual' => 0,
                        'pendapatan' => 0,
                        'terjual_batal' => 0,
                        'pendapatan_batal' => 0
                    ];
                }

                if ($isBatal) {
                    $menuSales[$menuName]['terjual_batal'] += $qty;
                    $menuSales[$menuName]['pendapatan_batal'] += $subtotal;
                    
                    $kategoriSales[$kategoriName]['terjual_batal'] += $qty;
                    $kategoriSales[$kategoriName]['pendapatan_batal'] += $subtotal;
                } else {
                    $menuSales[$menuName]['terjual'] += $qty;
                    $menuSales[$menuName]['pendapatan'] += $subtotal;
                    
                    $kategoriSales[$kategoriName]['terjual'] += $qty;
                    $kategoriSales[$kategoriName]['pendapatan'] += $subtotal;
                }
            }
        }

        // Urutkan Penjualan Menu (berdasarkan penjualan bersih/sukses)
        usort($menuSales, function($a, $b) {
            return $b['pendapatan'] <=> $a['pendapatan'];
        });

        return view('laporan.index', compact(
            'startDate', 'endDate', 'totalPenjualanKotor', 'totalPesananBatal', 'totalPenjualanBersih', 'totalTransaksi',
            'metodePembayaran', 'jenisPenjualan', 'menuSales', 'kategoriSales'
        ));
    }

    private function exportPenjualan($transaksis, $startDate, $endDate)
    {
        $fileName = 'Laporan_Penjualan_' . $startDate . '_sampai_' . $endDate . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($transaksis) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No. Struk', 'Tanggal Waktu', 'Metode Pembayaran', 'Tipe Pesanan', 'Total Harga']);

            foreach ($transaksis as $trx) {
                fputcsv($file, [
                    $trx->kode_transaksi,
                    $trx->created_at->format('Y-m-d H:i:s'),
                    $trx->metode_pembayaran,
                    $trx->tipe_pesanan,
                    $trx->total_harga
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    // Halaman Laporan Transaksi
    public function transaksi(Request $request)
    {
        $startDate = $request->start_date ?? now()->format('Y-m-d');
        $endDate = $request->end_date ?? now()->format('Y-m-d');
        $search = $request->search;
        $tab = $request->tab ?? 'sukses';

        $query = Transaksi::with('detail_transaksis.menu')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        if ($search) {
            $query->where('kode_transaksi', 'like', "%{$search}%");
        }

        if ($tab == 'sukses') {
            $query->where('status', '!=', 'Batal');
        } else {
            $query->where('status', 'Batal');
        }

        if ($request->has('export')) {
            return $this->exportTransaksi($query->get(), $startDate, $endDate, $tab);
        }

        // Untuk ringkasan, ambil semua transaksi di range tanggal (Sukses)
        $ringkasanSukses = Transaksi::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', '!=', 'Batal');
        $totalPendapatan = $ringkasanSukses->sum('total_harga');
        $totalTransaksi = $ringkasanSukses->count();

        // Untuk ringkasan Batal
        $ringkasanBatal = Transaksi::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('status', 'Batal');
        $totalNominalBatal = $ringkasanBatal->sum('total_harga');
        $totalTransaksiBatal = $ringkasanBatal->count();

        // Paginasi transaksi
        $transaksis = $query->latest()->paginate(10)->appends($request->query());

        return view('laporan.transaksi', compact('transaksis', 'startDate', 'endDate', 'search', 'tab', 'totalPendapatan', 'totalTransaksi', 'totalNominalBatal', 'totalTransaksiBatal'));
    }

    private function exportTransaksi($transaksis, $startDate, $endDate, $tab)
    {
        $fileName = 'Laporan_Transaksi_' . $tab . '_' . $startDate . '_sampai_' . $endDate . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($transaksis) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No. Struk', 'Tanggal Waktu', 'Metode Pembayaran', 'Tipe Pesanan', 'Status', 'Alasan Batal', 'Total Harga']);

            foreach ($transaksis as $trx) {
                fputcsv($file, [
                    $trx->kode_transaksi,
                    $trx->created_at->format('Y-m-d H:i:s'),
                    $trx->metode_pembayaran,
                    $trx->tipe_pesanan,
                    $trx->status ?? 'Sukses',
                    $trx->alasan_batal ?? '-',
                    $trx->total_harga
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


    // Halaman Laporan Opname
    public function opname(Request $request)
    {
        $date = $request->date ?? now()->format('Y-m-d');
        
        $query = BahanBaku::with(['kategori', 'riwayatOpname' => function($q) use ($date) {
            $q->where('tanggal', $date);
        }]); 

        if ($request->filled('search')) {
            $query->where('nama_item', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            if ($request->kategori === 'tak_berkategori') {
                $query->whereNull('kategori_bahan_id');
            } elseif (is_numeric($request->kategori)) {
                $query->where('kategori_bahan_id', $request->kategori);
            }
        }

        if ($request->has('export')) {
            return $this->exportOpname($query->get(), $date);
        }

        $items = $query->paginate(15)->appends($request->query());
        $kategoris = \App\Models\KategoriBahan::all(); 

        $opnamePagi = StokOpname::where('tanggal', $date)->whereNotNull('penginput_pagi')->first();
        $opnameSore = StokOpname::where('tanggal', $date)->whereNotNull('penginput_sore')->first();
        
        $picPagi = $opnamePagi ? $opnamePagi->penginput_pagi : '-';
        $picSore = $opnameSore ? $opnameSore->penginput_sore : '-';

        return view('laporan.opname', compact('items', 'kategoris', 'date', 'picPagi', 'picSore'));
    }

    private function exportOpname($items, $date)
    {
        $fileName = 'Laporan_Opname_' . $date . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($items, $date) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal: ' . $date]);
            fputcsv($file, ['Nama Item', 'Kategori', 'Unit Besar', 'Unit Kecil', 'Stok Pagi Besar', 'Stok Pagi Kecil', 'Stok Sore Besar', 'Stok Sore Kecil', 'Selisih (Unit Kecil)', 'PIC Pagi', 'PIC Sore']);

            foreach ($items as $item) {
                $riwayat = $item->riwayatOpname->first();
                $kategori = $item->kategori ? $item->kategori->nama_kategori : '-';
                
                $pagiBesar = $riwayat->stok_pagi_besar ?? 0;
                $pagiKecil = $riwayat->stok_pagi_kecil ?? 0;
                $soreBesar = $riwayat->stok_sore_besar ?? 0;
                $soreKecil = $riwayat->stok_sore_kecil ?? 0;
                
                $rasio = $item->konversi ?? 1000;
                $totalPagi = ($pagiBesar * $rasio) + $pagiKecil;
                $totalSore = ($soreBesar * $rasio) + $soreKecil;
                $selisih = $totalSore - $totalPagi;
                
                if (!$riwayat || (is_null($riwayat->stok_sore_besar) && is_null($riwayat->stok_sore_kecil))) {
                    $selisih = '-';
                }

                fputcsv($file, [
                    $item->nama_item,
                    $kategori,
                    $item->unit_besar,
                    $item->unit_kecil,
                    $pagiBesar,
                    $pagiKecil,
                    $soreBesar,
                    $soreKecil,
                    $selisih,
                    $riwayat->penginput_pagi ?? '-',
                    $riwayat->penginput_sore ?? '-'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}