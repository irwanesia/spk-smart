<?php

namespace App\Controllers;

use App\Models\MobilModel;
use App\Models\PembelianModel;
use App\Models\RiwayatPembelianModel;
use App\Models\PenilaianModel;

class Sales extends BaseController
{
    protected $mobil;
    protected $pembelian;
    protected $riwayatPembelian;
    protected $penilaian;

    public function __construct()
    {
        $this->mobil = new mobilModel();
        $this->pembelian = new PembelianModel();
        $this->riwayatPembelian = new RiwayatPembelianModel();
        $this->penilaian = new PenilaianModel();
    }

    public function index()
    {
        // Verifikasi role tambahan di controller
        // if (session('role') != 'pelanggan') {
        //     return redirect()->back()->with('error', 'Akses terbatas untuk pelanggan');
        // }

        $id_sales = session()->get('id_user');

        // Ambil pelanggan yang membeli dari sales ini
        $pelanggan = $this->pembelian
            ->select('users.nama, users.email, pembelian.tanggal_pembelian, mobil.nama_mobil, users.id_user')
            ->join('users', 'users.id_user = pembelian.id_user')
            ->join('mobil', 'mobil.id_mobil = pembelian.id_mobil')
            ->where('pembelian.id_sales', $id_sales)
            ->findAll();

        // Hitung total pelanggan & total penilaian
        $totalPelanggan = count($pelanggan);
        // $totalPenilaian = 0;

        // foreach ($pelanggan as &$p) {
        //     // Cek apakah user sudah dinilai
        //     $cek = $this->penilaian
        //         ->where('id_user', $p['id_user'])
        //         ->countAllResults();

        //     $p['status_penilaian'] = ($cek > 0) ? 'Sudah' : 'Belum';
        //     if ($cek > 0) $totalPenilaian++;
        // }

        return view('laporan/sales', [
            'title' => 'Laporan Penilaian Pelanggan',
            'pelanggan' => $pelanggan,
            'totalPelanggan' => $totalPelanggan,
            // 'totalPenilaian' => $totalPenilaian ?? null
        ]);
    }
}
