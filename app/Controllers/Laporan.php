<?php

namespace App\Controllers;

use App\Models\KriteriaModel;
use App\Models\PenilaianModel;
use App\Models\SubKriteriaModel;
use App\Models\HasilPerhitunganModel;
use App\Models\UsersModel;
use App\Models\mobilModel;
use App\Models\PerhitunganTempModel;

class Laporan extends BaseController
{
    protected $penilaian;
    protected $kriteria;
    protected $subKriteria;
    protected $hasilPerhitungan;
    protected $users;
    protected $mobil;
    protected $perhitunganTemp;

    public function __construct()
    {
        $this->penilaian = new PenilaianModel();
        $this->kriteria = new KriteriaModel();
        $this->subKriteria = new SubKriteriaModel();
        $this->hasilPerhitungan = new HasilPerhitunganModel();
        $this->users = new UsersModel();
        $this->mobil = new MobilModel();
        $this->perhitunganTemp = new PerhitunganTempModel();
    }

    public function index()
    {
        $pelanggan = $this->users->where('role', 'pelanggan')->findAll();
        $allRankings = [];

        foreach ($pelanggan as $user) {
            $allRankings[$user['id_user']] = $this->hasilPerhitungan->getHasilPerhitungan($user['id_user']);
        }

        return view('Laporan/hasil-ranking', [
            'title' => 'Laporan Hasil Perangkingan',
            'pelanggan' => $pelanggan,
            'ranking' => $allRankings
        ]);
    }

    // public function detail_penilaian()
    // {

    //     return view('Laporan/detail-penilaian', [
    //         'title' => 'Laporan Detail Penilaian',
    //         'pelanggan' => $this->users->where('role', 'pelanggan')->findAll()
    //     ]);
    // }

    // public function detailPenilaianUser()
    public function detail_penilaian()
    {
        // Ambil data pelanggan
        $users = $this->users->where('role', 'pelanggan')->findAll();

        // Susun data penilaian per user
        $userPenilaian = [];
        foreach ($users as $user) {
            // Ambil hasil perhitungan untuk user ini
            $hasilPerhitungan = $this->hasilPerhitungan->getHasilPerhitungan($user['id_user']);

            // Kumpulkan id_mobil untuk user ini
            $mobilIds = [];
            foreach ($hasilPerhitungan as $hasil) {
                $mobilIds[] = $hasil['id_mobil'];
            }

            // Jika user memiliki penilaian
            if (!empty($mobilIds)) {
                // Ambil data penilaian untuk mobil-mobil ini
                $dataPenilaian = $this->penilaian->getPenilaianByMobil($mobilIds);
                $kriteria = $this->penilaian->getKriteriaByMobil($mobilIds);

                // Susun data penilaian untuk user ini
                $penilaianUser = [];
                foreach ($dataPenilaian as $penilaian) {
                    $penilaianUser[$penilaian['nama_mobil']][$penilaian['nama_kriteria']] = $penilaian['nilai_akhir'];
                }

                $userPenilaian[$user['id_user']] = [
                    'user' => $user,
                    'kriteria' => $kriteria,
                    'penilaian' => $penilaianUser
                ];
            } else {
                $userPenilaian[$user['id_user']] = [
                    'user' => $user,
                    'kriteria' => [],
                    'penilaian' => []
                ];
            }
        }

        return view('laporan/detail-penilaian', [
            'title' => "Laporan Detail Penilaian",
            'userPenilaian' => $userPenilaian
        ]);
    }


    public function riwayat_penilaian()
    {

        return view('Laporan/riwayat-penilaian', [
            'title' => 'Riwayat Penilaian',
            'riwayat' => $this->hasilPerhitungan->getRiwayatHasil()
        ]);
    }

    public function cetak()
    {
        // $data = [
        //     'title' => 'Cetak',
        //     'hasil' => $this->hasil->getDataHasil(),
        //     'supplier' => $this->supplier->findAll(),
        // ];
        // return view('Hasil/cetak', $data);
    }

    public function cetak_laporan($id_user)
    {
        // Ambil data user
        $user = $this->users->where('id_user', $id_user)->findAll();

        // Ambil hasil perhitungan berdasarkan user
        $hasil = $this->hasilPerhitungan->getHasilPerhitungan($id_user);

        return view('laporan/cetak-hasil-ranking', [
            'user' => $user,
            'hasil' => $hasil
        ]);
    }
}
