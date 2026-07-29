<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\KategoriMenu;
use App\Models\Menu;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Default range: hari ini s.d hari ini
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : now()->startOfDay();
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        $transaksiSukses = Transaksi::with('detail_transaksis.menu.kategori')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'Batal')
            ->get();

        // 1. RINGKASAN ATAS
        $pendapatan = $transaksiSukses->sum('total_harga');
        $jumlahTransaksi = $transaksiSukses->count();
        
        $menuTerjual = 0;
        $menuSales = [];
        
        foreach ($transaksiSukses as $trx) {
            foreach ($trx->detail_transaksis as $detail) {
                $qty = $detail->qty;
                $menuTerjual += $qty;
                
                $menuId = $detail->menu_id;
                if (!isset($menuSales[$menuId])) {
                    $menuSales[$menuId] = [
                        'menu' => $detail->menu,
                        'terjual' => 0,
                        'pendapatan' => 0
                    ];
                }
                $menuSales[$menuId]['terjual'] += $qty;
                $menuSales[$menuId]['pendapatan'] += $detail->subtotal;
            }
        }
        
        // Urutkan untuk mencari Menu Terlaris
        usort($menuSales, function($a, $b) {
            return $b['terjual'] <=> $a['terjual'];
        });

        $menuTerlaris = count($menuSales) > 0 ? $menuSales[0]['menu']->nama_menu : '-';
        $menuTerlarisJml = count($menuSales) > 0 ? $menuSales[0]['terjual'] : 0;

        // Trend VS Kemarin (hanya membandingkan 1 hari mundur dari start_date)
        $kemarinStart = $startDate->copy()->subDay()->startOfDay();
        $kemarinEnd = $startDate->copy()->subDay()->endOfDay();
        $transaksiKemarin = Transaksi::whereBetween('created_at', [$kemarinStart, $kemarinEnd])
            ->where('status', '!=', 'Batal')
            ->get();
        $pendapatanKemarin = $transaksiKemarin->sum('total_harga');
        
        $trendPersen = 0;
        if ($pendapatanKemarin > 0) {
            $trendPersen = (($pendapatan - $pendapatanKemarin) / $pendapatanKemarin) * 100;
        } else if ($pendapatan > 0) {
            $trendPersen = 100; // Kemarin 0, hari ini ada, naik 100%
        }

        // 2. GRAFIK MINGGUAN (7 Hari Terakhir dari endDate)
        $labelMingguan = [];
        $pendapatanMingguan = [];
        $transaksiMingguan = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $hari = $endDate->copy()->subDays($i);
            $namaHari = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'][$hari->dayOfWeek];
            
            $trxHariIni = Transaksi::whereDate('created_at', $hari->toDateString())
                ->where('status', '!=', 'Batal')
                ->get();
            
            $labelMingguan[] = $namaHari;
            $pendapatanMingguan[] = round($trxHariIni->sum('total_harga') / 1000, 1); // Dalam k
            $transaksiMingguan[] = $trxHariIni->count();
        }

        // 3. GRAFIK PER JAM
        $labelPerJam = [];
        $pendapatanPerJam = [];
        $transaksiPerJam = [];
        
        // Kita hitung per jam dari transaksiSukses (yang ada di range waktu)
        // Note: Jika range > 1 hari, ini akan menjumlahkan jam yang sama di hari berbeda
        for ($i = 0; $i < 24; $i++) {
            $labelPerJam[] = (string)$i;
            $pendapatanPerJam[$i] = 0;
            $transaksiPerJam[$i] = 0;
        }

        foreach ($transaksiSukses as $trx) {
            $jam = $trx->created_at->format('G'); // 0-23
            $pendapatanPerJam[(int)$jam] += $trx->total_harga;
            $transaksiPerJam[(int)$jam] += 1;
        }
        
        // Convert pendapatan ke 'k'
        foreach ($pendapatanPerJam as $k => $v) {
            $pendapatanPerJam[$k] = round($v / 1000, 1);
        }

        // 4. RINGKASAN MENU (Top 3)
        $top3Menu = array_slice($menuSales, 0, 3);

        // 5. DONUT KATEGORI
        $kategoriSales = [];
        $kategoris = KategoriMenu::all();
        foreach ($kategoris as $k) {
            $kategoriSales[$k->id] = [
                'nama' => $k->nama_kategori,
                'volume' => 0,
                'pendapatan' => 0
            ];
        }
        $kategoriSales['lainnya'] = [ // Fallback
            'nama' => 'Lainnya',
            'volume' => 0,
            'pendapatan' => 0
        ];

        foreach ($transaksiSukses as $trx) {
            foreach ($trx->detail_transaksis as $detail) {
                if ($detail->menu) {
                    $katId = $detail->menu->kategori_menu_id ?? 'lainnya';
                    if (isset($kategoriSales[$katId])) {
                        $kategoriSales[$katId]['volume'] += $detail->qty;
                        $kategoriSales[$katId]['pendapatan'] += $detail->subtotal;
                    }
                }
            }
        }
        
        // Bersihkan kategori yang 0 agar grafik rapi
        $kategoriSales = array_filter($kategoriSales, function($v) {
            return $v['volume'] > 0 || $v['pendapatan'] > 0;
        });

        $labelKategori = [];
        $volumeKategori = [];
        $persenVolume = [];
        $pendapatanKategori = [];
        $persenPendapatan = [];
        
        $totalVol = array_sum(array_column($kategoriSales, 'volume'));
        $totalPend = array_sum(array_column($kategoriSales, 'pendapatan'));

        foreach ($kategoriSales as $kat) {
            $labelKategori[] = $kat['nama'];
            $volumeKategori[] = $kat['volume'];
            $persenVolume[] = $totalVol > 0 ? round(($kat['volume'] / $totalVol) * 100, 1) : 0;
            
            $pendapatanKategori[] = "Rp" . number_format($kat['pendapatan'], 0, ',', '.');
            $persenPendapatan[] = $totalPend > 0 ? round(($kat['pendapatan'] / $totalPend) * 100, 1) : 0;
        }

        // 6. BAR KATEGORI
        // Tampilkan top 5 menu untuk tiap kategori
        $topMenuPerKategori = [];
        foreach ($kategoriSales as $katId => $katData) {
            $menusInKat = [];
            foreach ($menuSales as $ms) {
                if ($ms['menu'] && $ms['menu']->kategori_menu_id == $katId) {
                    $menusInKat[] = [
                        'nama' => $ms['menu']->nama_menu,
                        'volume' => $ms['terjual']
                    ];
                }
            }
            
            // Urutkan menu di kategori ini dari terjual terbanyak
            usort($menusInKat, function($a, $b) {
                return $b['volume'] <=> $a['volume'];
            });
            
            // Ambil top 5 saja agar grafik tidak kepenuhan
            $menusInKat = array_slice($menusInKat, 0, 5);
            
            if (count($menusInKat) > 0) {
                $labels = array_column($menusInKat, 'nama');
                $volumes = array_column($menusInKat, 'volume');
                
                $topMenuPerKategori[] = [
                    'kategori' => $katData['nama'],
                    'menus' => $menusInKat,
                    'labels' => $labels,
                    'volumes' => $volumes
                ];
            }
        }
        
        // Batasi 3 kategori terlaris untuk grid
        usort($topMenuPerKategori, function($a, $b) {
            $sumA = array_sum($a['volumes']);
            $sumB = array_sum($b['volumes']);
            return $sumB <=> $sumA;
        });
        $topMenuPerKategori = array_slice($topMenuPerKategori, 0, 3);

        return view('dashboard.index', compact(
            'startDate', 'endDate',
            'pendapatan', 'jumlahTransaksi', 'menuTerjual', 'menuTerlaris', 'menuTerlarisJml', 'trendPersen',
            'labelMingguan', 'pendapatanMingguan', 'transaksiMingguan',
            'labelPerJam', 'pendapatanPerJam', 'transaksiPerJam',
            'top3Menu',
            'labelKategori', 'volumeKategori', 'persenVolume', 'pendapatanKategori', 'persenPendapatan',
            'topMenuPerKategori'
        ));
    }
}