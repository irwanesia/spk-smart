<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Perbandingan extends BaseController
{
    protected $mobil;
    protected $kriteria;
    protected $penilaian;
    protected $user;
    protected $perbandingan;
    protected $perbandinganDetail;
    protected $perbandinganHasil;
    protected $hasilPerhitungan;

    public function __construct()
    {
        $this->mobil = new \App\Models\MobilModel();
        $this->kriteria = new \App\Models\KriteriaModel();
        $this->penilaian = new \App\Models\PenilaianModel();
        $this->user = new \App\Models\UsersModel();
        $this->perbandingan = new \App\Models\perbandinganModel();
        $this->perbandinganDetail = new \App\Models\perbandinganDetailModel();
        $this->perbandinganHasil = new \App\Models\perbandinganHasilModel();
        $this->hasilPerhitungan = new \App\Models\HasilPerhitunganModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Beranda',
            'dataMobil' => $this->mobil->findAll(),
            'dataUsers' => $this->user->find($_SESSION['id_user'] ?? null),
            'salesList' => $this->user->where('role', 'sales')->findAll(),
            'kriteria' => $this->kriteria->findAll()
        ];
        return view('perbandingan/index', $data);
    }

    public function proses_perbandingan()
    {
        $carIds = $this->request->getGet('cars');
        // Konversi string ke array
        $carIdsArray = explode(',', $carIds);
        if (count($carIdsArray) < 2) {
            return redirect()->to('/mobil')->with('error', 'Pilih minimal 2 mobil untuk dibandingkan');
        }

        // Pastikan semua ID adalah numerik
        $carIdsArray = array_filter($carIdsArray, 'is_numeric');

        // Ambil data kriteria
        $dataKriteria = $this->kriteria->findAll();

        // Ambil data mobil beserta nilai kriterianya
        $mobil = [];
        foreach (explode(',', $carIds) as $id) {
            $mobilData = $this->mobil->find($id);
            $nilaiKriteria = $this->penilaian->getNilaiMobil($id);
            $mobil[$id] = [
                'nama' => $mobilData['nama_mobil'],
                'data' => []
            ];

            foreach ($nilaiKriteria as $nilai) {
                $mobil[$id]['data'][$nilai['id_kriteria']] = [
                    'nilai' => $nilai['nilai'],
                    'tipe' => $nilai['tipe'],
                    'bobot' => $nilai['bobot']
                ];
            }
        }

        // Ambil data
        $dataPenilaian = $this->penilaian->getPenilaianByMobil($carIdsArray);
        $kriteria = $this->penilaian->getKriteriaByMobil($carIdsArray);
        $nilaiMaxMin = $this->penilaian->getNilaiMaxMinByMobil($carIdsArray);
        // dd($dataPenilaian, $kriteria, $nilaiMaxMin);

        // Susun data penilaian
        $data = [];
        $data_id = [];
        foreach ($dataPenilaian as $penilaian) {
            $data[$penilaian['nama_mobil']][$penilaian['id_kriteria']] = $penilaian['nilai_akhir'];
            $data_id[$penilaian['id_mobil']][$penilaian['id_kriteria']] = $penilaian['nilai_akhir'];
        }

        // Inisialisasi nilai Max dan Min per kriteria
        $nilaiMax = [];
        $nilaiMin = [];
        foreach ($nilaiMaxMin as $n) {
            $id_kriteria = $n['id_kriteria'];
            $nilaiMax[$id_kriteria] = ($n['nilaiMax'] == 0) ? 1 : $n['nilaiMax'];
            $nilaiMin[$id_kriteria] = ($n['nilaiMin'] == 0) ? 1 : $n['nilaiMin'];
        }

        // Matriks keputusan
        $dataMatrik = [];
        foreach ($data as $nama_mobil => $nilaiKriteria) {
            $matrik = [];
            foreach ($kriteria as $k) {
                $id_kriteria = $k['id_kriteria'];
                $matrik[$id_kriteria] = $nilaiKriteria[$id_kriteria] ?? '-';
            }
            $dataMatrik[$nama_mobil] = $matrik;
        }

        // Matriks normalisasi
        $normalisasi = [];
        foreach ($dataMatrik as $nama_mobil => $matrik) {
            $normalisasi[$nama_mobil] = [];
            foreach ($kriteria as $k) {
                $id_kriteria = $k['id_kriteria'];
                $nilai = $matrik[$id_kriteria];

                if ($nilai === '-' || $nilai == 0) {
                    $normalisasi[$nama_mobil][$id_kriteria] = 0;
                    continue;
                }

                if ($k['tipe'] == 'benefit') {
                    $normalisasi[$nama_mobil][$id_kriteria] = $nilai / $nilaiMax[$id_kriteria];
                } else {
                    $normalisasi[$nama_mobil][$id_kriteria] = $nilaiMin[$id_kriteria] / $nilai;
                }
            }
        }

        // Ambil bobot (sudah dalam desimal atau masih %)
        $bobot = [];
        foreach ($dataKriteria as $k) {
            $bobot[$k['id_kriteria']] = $k['bobot']; // diasumsikan desimal, jika bukan: bagi 100
        }

        // Hitung nilai preferensi
        $nilaiPreferensi = [];
        foreach ($normalisasi as $nama_mobil => $nilaiKriteria) {
            $total = 0;
            foreach ($nilaiKriteria as $id_kriteria => $nilaiNorm) {
                $total += $nilaiNorm * $bobot[$id_kriteria];
            }
            $nilaiPreferensi[$nama_mobil] = $total;
        }

        // Urutkan ranking
        arsort($nilaiPreferensi);
        // dd($dataMatrik);

        // ===================== SIMPAN HASIL ===========================
        // 1. Simpan ke tabel perbandingan
        $idUser = $_SESSION['id_user'] ?? null;
        if (!$idUser) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $this->perbandingan->insert([
            'id_user' => $idUser,
            'tanggal' => date('Y-m-d H:i:s'),
            'keterangan' => 'Perbandingan mobil oleh user ID ' . $idUser
        ]);
        $idPerbandingan = $this->perbandingan->getInsertID();

        // 2. Simpan ke tabel perbandingan_detail
        foreach ($carIdsArray as $id_mobil) {
            $this->perbandinganDetail->insert([
                'id_perbandingan' => $idPerbandingan,
                'id_mobil' => $id_mobil
            ]);
        }

        // 3. Simpan hasil ranking ke tabel perbandingan_hasil
        $rank = 1;
        foreach ($nilaiPreferensi as $nama_mobil => $nilai) {
            $id_mobil = array_search($nama_mobil, array_column($this->mobil->findAll(), 'nama_mobil'));
            $this->perbandinganHasil->insert([
                'id_perbandingan' => $idPerbandingan,
                'id_mobil' => $carIdsArray[$rank - 1],
                'nilai_preferensi' => $nilai,
                'rank' => $rank++
            ]);
        }

        // 4. simpan hasil rangking ke table hasil perhitungan
        // sebelum simpan hasil perhitungan atau ranking, hapus terdahulu jika ada data dengan iduser
        $this->hasilPerhitungan->where('id_user', $idUser)->delete();

        // setelah itu simpan ke table hasil perhitungan
        $ranking = 1;
        foreach ($nilaiPreferensi as $nama_mobil => $nilai) {
            $id_mobil = array_search($nama_mobil, array_column($this->mobil->findAll(), 'nama_mobil'));
            $this->hasilPerhitungan->insert([
                'id_user' => $idUser,
                'id_mobil' => $carIdsArray[$ranking - 1],
                'skor' => $nilai,
                'ranking' => $ranking++
            ]);
        }


        $data = [
            'title' => 'Hasil Perbandingan Mobil',
            'mobil' => $mobil,
            'dataMobil' => $this->mobil->findAll(),
            'kriteria' => $kriteria,
            'comparedCarIds' => $carIdsArray,
            'dataKriteria' => $dataKriteria,
            'dataUsers' => $this->user->find($_SESSION['id_user'] ?? null),
            'bobot' => $bobot,
            'data' => $data,
            'data_id' => $data_id,
            'salesList' => $this->user->where('role', 'sales')->findAll(),
            'dataMatrik' => $dataMatrik,
            'normalisasi' => $normalisasi,
            'nilaiPreferensi' => $nilaiPreferensi,
            'nilaiMax' => $nilaiMax,
            'nilaiMin' => $nilaiMin,
            'id_perbandingan' => $idPerbandingan,
        ];

        return view('perbandingan/proses', $data);
    }

    // public function proses()
    // {
    //     $carIds = $this->request->getGet('cars');

    //     if (!$carIds || count(explode(',', $carIds)) < 2) {
    //         return redirect()->to('/perbandingan')->with('error', 'Pilih minimal 2 mobil untuk dibandingkan');
    //     }

    //     $data = [
    //         'title' => 'Hasil Perbandingan Mobil',
    //         'mobil' => $this->mobilModel->whereIn('id', explode(',', $carIds))->findAll(),
    //         'kriteria' => $this->kriteriaModel->findAll(), // Kirim data kriteria
    //     ];

    //     return view('perbandingan/hasil', $data);
    // }
}
