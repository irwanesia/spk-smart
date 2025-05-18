<?php

namespace App\Controllers;

use App\Models\MobilModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;
use App\Models\PembelianModel;
use App\Models\PenilaianModel;
use App\Models\UsersModel;
use App\Models\perbandinganHasilModel;
use App\Models\PerhitunganTempModel;
use App\Models\RiwayatPembelianModel;

class Dashboard extends BaseController
{
    protected $kriteria;
    protected $subKriteria;
    protected $mobil;
    protected $penilaian;
    protected $perbandinganHasil;
    protected $perhitunganTemp;
    protected $pembelian;
    protected $riwayatPembelian;
    protected $user;

    public function __construct()
    {

        $this->kriteria = new KriteriaModel();
        $this->subKriteria = new subKriteriaModel();
        $this->mobil = new MobilModel();
        $this->penilaian = new PenilaianModel();
        $this->perbandinganHasil = new perbandinganHasilModel();
        $this->perhitunganTemp = new PerhitunganTempModel();
        $this->pembelian = new PembelianModel();
        $this->riwayatPembelian = new RiwayatPembelianModel();
        $this->user = new UsersModel();

        // membuat range tahun untuk keperluan periode
        // $thnAwal = 2022;
        // $thnAkhir = intval(date('Y'));
        // $jumlahThn = $thnAkhir - $thnAwal;
        // $this->dataTahun = [];
        // for ($i = 0; $i <= $jumlahThn; $i++) {
        //     $this->dataTahun[] = $thnAwal + $i;
        // }
    }

    public function index()
    {
        // data statistik pembelian per bulan
        $statistik = $this->pembelian->getStatistikPembelianPerBulan();
        $bulanNama = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec'
        ];

        $labels = [];
        $values = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = $bulanNama[$i];
            $found = false;
            foreach ($statistik as $row) {
                if ((int)$row['bulan'] === $i) {
                    $values[] = (int)$row['total'];
                    $found = true;
                    break;
                }
            }
            if (!$found) $values[] = 0;
        }

        // presentase penilaian mobil
        $totalMobil = $this->mobil->getTotalMobil();
        $mobilDinilai = $this->penilaian->getJumlahMobilDinilai();

        $persentase = ($totalMobil > 0) ? round(($mobilDinilai / $totalMobil) * 100) : 0;

        // tampilan dashboard untuk login sales
        // Di Controller DashboardSales
        $id_sales = session()->get('id_user');
        $pelanggan = $this->user->getPelangganBySales($id_sales);
        $jumlah_pelanggan = count($pelanggan);

        // Cari tanggal pembelian terakhir
        $tanggal_terakhir = null;
        if (!empty($pelanggan)) {
            $tanggal_terakhir = max(array_column($pelanggan, 'tanggal_pembelian'));
        }

        $data = [
            'title' => 'Dashboard',
            'countKriteria' => $this->kriteria->countAllResults(),
            'countSubKriteria' => $this->subKriteria->countAllResults(),
            'countPembelian' => $this->pembelian->countAllResults(),
            'countMobil' => $this->mobil->countAllResults(),
            'countPenilaian' => $this->penilaian->countAllResults(),
            'countUser' => $this->user->countAllResults(),
            'topMobil' => $this->pembelian->getTopMobilPalingSeringDipilih(5),
            'chartLabels' => json_encode($labels),
            'chartData' => json_encode($values),
            'totalMobil' => $totalMobil,
            'mobilDinilai' => $mobilDinilai,
            'persentase' => $persentase,
            'pelanggan' => $pelanggan,
            'jumlah_pelanggan' => $jumlah_pelanggan,
            'tanggal_terakhir' => $tanggal_terakhir
        ];
        return view('index', $data);
    }

    // dashboard sales
    public function dashboardSales()
    {
        // $data = [
        //     'title' => 'Dashboard Sales',
        //     'countPembelian' => 
        // ]
    }
}
