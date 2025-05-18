<?php

namespace App\Controllers;

use App\Models\PenilaianModel;
use App\Models\MobilModel;
use App\Models\BahanBakuModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;

class Penilaian extends BaseController
{
    protected $penilaian;
    protected $mobil;
    protected $bahanBaku;
    protected $kriteria;
    protected $subKriteria;

    public function __construct()
    {
        $this->penilaian = new PenilaianModel();
        $this->mobil = new MobilModel();
        $this->kriteria = new KriteriaModel();
        $this->subKriteria = new SubKriteriaModel();
    }

    public function index()
    {
        // 1. Ambil data penilaian yang sudah ada (jika diperlukan)
        $dataPenilaian = $this->penilaian->findAllPenilaian();

        // 2. Ambil semua data mobil (untuk daftar yang akan dinilai)
        $mobilList = $this->mobil->findAll();

        // 3. Ambil data kriteria beserta subkriteria (untuk form modal)
        $kriteriaModel = $this->kriteria->findAll();
        $kriteriaData = [];

        foreach ($kriteriaModel as $kriteria) {
            $subkriteria = $this->subKriteria->where('id_kriteria', $kriteria['id_kriteria'])->findAll();

            $kriteriaData[] = [
                'kriteria' => $kriteria,
                'subkriteria' => $subkriteria
            ];
        }

        // 4. Cek apakah mobil sudah dinilai (seperti sebelumnya)
        foreach ($mobilList as $key => $mobil) {
            $isPenilaianExists = $this->penilaian
                ->where('id_mobil', $mobil['id_mobil'])
                ->countAllResults() > 0;

            $mobilList[$key]['isPenilaianExists'] = $isPenilaianExists;
        }

        // 5. Siapkan data untuk dikirim ke view
        $data = [
            'title' => 'Penilaian mobil',
            'dataPenilaian' => $dataPenilaian,
            'mobil' => $mobilList,  // Daftar mobil untuk tabel utama
            'kriteriaData' => $kriteriaData,  // Data kriteria & subkriteria untuk form modal
        ];

        return view('Penilaian/index', $data);
    }

    public function simpan($id_mobil)
    {
        // Validasi input
        $validationRules = [
            'id_kriteria' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Minimal satu kriteria harus dipilih'
                ]
            ],
            'id_kriteria.*' => [
                'rules' => 'numeric',
                'errors' => [
                    'numeric' => 'ID Kriteria harus berupa angka'
                ]
            ],
            'nilai.*' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'Nilai harus berupa angka'
                ]
            ],
            'id_subkriteria.*' => [
                'rules' => 'permit_empty|numeric',
                'errors' => [
                    'numeric' => 'Subkriteria tidak valid'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('show_modal', 'edit')  // Identifier universal
                ->with('edit_id', $id_mobil);      // ID spesifik data yang diedit
        }

        // Ambil data dari form
        $data = $this->request->getPost();

        // Simpan ke database
        try {
            foreach ($data['id_kriteria'] as $id_kriteria => $value) {
                $isSubkriteria = ($this->kriteria->find($id_kriteria)['pilih_inputan'] == 'subkriteria');

                $this->penilaian->insert([
                    'id_mobil'      => $id_mobil,
                    'id_kriteria'   => $id_kriteria,
                    'nilai'         => $isSubkriteria ? null : ($data['nilai'][$id_kriteria] ?? null),
                    'id_subkriteria' => $isSubkriteria ? ($data['id_subkriteria'][$id_kriteria] ?? null) : null
                ]);
            }

            return redirect()->to('/penilaian')
                ->with('success', 'Data penilaian berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update($id_mobil)
    {
        // Validasi input
        $rules = [
            'id_kriteria' => 'required',
            'id_kriteria.*' => 'numeric',
            'nilai.*' => 'permit_empty|numeric',
            'id_subkriteria.*' => 'permit_empty|numeric'
        ];

        // if (!$this->validate($rules)) {
        //     return redirect()->back()
        //         ->withInput()
        //         ->with('errors', $this->validator->getErrors());
        // }

        // Jalankan validasi
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('show_modal', 'edit')
                ->with('edit_id', $id_mobil);
        }

        $data = $this->request->getPost();

        // Hapus data penilaian lama untuk mobil ini
        $this->penilaian->where('id_mobil', $id_mobil)->delete();

        // Simpan data baru
        foreach ($data['id_kriteria'] as $id_kriteria => $value) {
            $kriteria = $this->kriteria->find($id_kriteria);
            $isSubkriteria = ($kriteria['pilih_inputan'] == 'subkriteria');

            $this->penilaian->insert([
                'id_mobil' => $id_mobil,
                'id_kriteria' => $id_kriteria,
                'nilai' => $isSubkriteria ? null : ($data['nilai'][$id_kriteria] ?? null),
                'id_subkriteria' => $isSubkriteria ? ($data['id_subkriteria'][$id_kriteria] ?? null) : null
            ]);
        }

        return redirect()->to('/penilaian')
            ->with('success', 'Data penilaian berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->penilaian->where('id_mobil', $id)->delete();

        // pesan berhasil didelete
        session()->setFlashdata('success', 'Penilaian berhasil dihapus!');
        return redirect()->to('/penilaian');
    }
}
