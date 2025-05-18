<?php

namespace App\Controllers;

use App\Models\MobilModel;
use App\Models\KriteriaModel;
use App\Models\PenilaianModel;
use App\Models\SubkriteriaModel;

class Perhitungan extends BaseController
{
    protected $penilaian;
    protected $mobil;
    protected $kriteria;
    protected $subkriteria;

    public function __construct()
    {
        $this->penilaian = new PenilaianModel();
        $this->mobil = new MobilModel();
        $this->kriteria = new KriteriaModel();
        $this->subkriteria = new SubkriteriaModel();
    }

    public function index()
    {
        // Ambil data
        $kriteria = $this->penilaian->getDistinctKriteria();
        $dataKriteria = $this->kriteria->findAll();
        $dataPenilaian = $this->penilaian->getAllPenilaian();
        $nilaiMaxMin = $this->penilaian->getNilaiMaxMin();
        $dataMobil = $this->mobil->findAll();

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

        // Kirim ke view
        return view('Perhitungan/index', [
            'title' => 'Seleksi Mobil',
            'kriteria' => $kriteria,
            'dataKriteria' => $dataKriteria,
            'bobot' => $bobot,
            'data' => $data,
            'data_id' => $data_id,
            'dataMatrik' => $dataMatrik,
            'normalisasi' => $normalisasi,
            'nilaiPreferensi' => $nilaiPreferensi,
            'nilaiMax' => $nilaiMax,
            'nilaiMin' => $nilaiMin,
            'mobil' => $dataMobil,
        ]);
    }


    public function simpan()
    {
        $mobil = $this->request->getVar('mobil[]');
        $nilai = $this->request->getVar('nilai[]');

        // Inisialisasi kode unik di sini, sehingga setiap baris data dalam proses ini akan memiliki kode yang sama
        $kodeUnik = uniqid('hasil-', true);

        for ($i = 0; $i < count($mobil); $i++) {
            // Cek apakah data sudah ada di database
            $existingData = $this->hasil->where([
                'id_mobil' => $mobil[$i],
            ])->first();

            $data = [
                'kode_hasil' => $kodeUnik,
                'id_mobil' => $mobil[$i],
                'nilai' => $nilai[$i],
            ];

            if ($existingData) {
                // Jika data sudah ada, lakukan update
                $this->hasil->update($existingData['id_hasil'], $data); // Pastikan 'id' adalah nama primary key dari tabel hasil
                session()->setFlashdata('pesan', 'Data perhitungan berhasil tersimpan di database!');
            } else {
                // Jika data belum ada, lakukan insert
                $this->hasil->save($data);
                session()->setFlashdata('pesan', 'Data perhitungan berhasil disimpan!');
            }
        }

        return redirect()->to('/perhitungan');
    }
}
