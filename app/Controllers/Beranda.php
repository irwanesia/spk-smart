<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\MobilModel;
use App\Models\PembelianModel;
use App\Models\PenilaianModel;
use App\Models\KriteriaModel;
use App\Models\PerbandinganHasilModel;
use App\Models\PerhitunganTempModel;
use App\Models\RiwayatPembelianModel;

class Beranda extends BaseController
{
    protected $mobil;
    protected $penilaian;
    protected $user;
    protected $perbandinganHasil;
    protected $perhitunganTemp;
    protected $pembelian;
    protected $riwayatPembelian;
    protected $kriteria;

    public function __construct()
    {
        $this->mobil = new MobilModel();
        $this->user = new usersModel();
        $this->penilaian = new PenilaianModel();
        $this->perbandinganHasil = new PerbandinganHasilModel();
        $this->perhitunganTemp = new PerhitunganTempModel();
        $this->pembelian = new PembelianModel();
        $this->riwayatPembelian = new RiwayatPembelianModel();
        $this->kriteria = new KriteriaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda',
            'mobil_terbaru' => $this->mobil->getMobilTerbaru(6),
            'dataMobil' => $this->mobil->findAll(),
            'dataUsers' => $this->user->find($_SESSION['id_user'] ?? null),
            'salesList' => $this->user->where('role', 'sales')->findAll(),
        ];
        return view('Beranda/index', $data);
    }
}
