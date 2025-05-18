<?php

namespace App\Controllers;

use App\Models\KriteriaModel;
use App\Models\MobilModel;
use App\Models\SubKriteriaModel;

class Kriteria extends BaseController
{
    protected $kriteria;
    protected $mobil;
    protected $subkriteria;

    public function __construct()
    {
        $this->kriteria = new KriteriaModel();
        $this->mobil = new MobilModel();
        $this->subkriteria = new SubKriteriaModel();
    }

    public function index()
    {
        $kriteriaData = $this->kriteria->findAll();
        $allSubkriteria = [];

        foreach ($kriteriaData as $k) {
            // Asumsi Anda memiliki model subkriteria yang terpisah
            $subkriteriaData = $this->subkriteria->where('id_kriteria', $k['id_kriteria'])->findAll();
            $allSubkriteria[$k['id_kriteria']] = $subkriteriaData;
        }

        // Kirim data ke view
        return view('Kriteria/index', [
            'title' => 'Kriteria',
            'kode' => $this->kriteria->generateCode(),
            'kriteria' => $kriteriaData,
            'subkriteria' => $allSubkriteria // Sekarang berbentuk array dengan id_kriteria sebagai key
        ]);
    }

    public function simpan()
    {
        $validation = \Config\Services::validation();
        // Validasi input
        $validationRules = [
            'kode_kriteria' => [
                'rules' => 'required|is_unique[kriteria.kode_kriteria]',
                'errors' => [
                    'required' => 'Kode kriteria harus diisi',
                    'is_unique' => 'Kode kriteria sudah digunakan'
                ]
            ],
            'nama_kriteria' => [
                'rules' => 'required|is_unique[kriteria.nama_kriteria]',
                'errors' => [
                    'required' => 'Nama kriteria harus diisi',
                    'is_unique' => 'Nama kriteria sudah ada'
                ]
            ],
            'tipe' => [
                'rules' => 'required|in_list[benefit,cost]',
                'errors' => [
                    'required' => 'Tipe kriteria harus dipilih',
                    'in_list' => 'Tipe kriteria tidak valid'
                ]
            ],
            'bobot' => [
                'rules' => 'required|decimal|greater_than[0]',
                'errors' => [
                    'required' => 'Bobot kriteria harus diisi',
                    'decimal' => 'Bobot harus berupa angka desimal',
                    'greater_than' => 'Bobot harus lebih besar dari 0'
                ]
            ],
            'pilih_inputan' => [
                'rules' => 'required|in_list[input_langsung,subkriteria]',
                'errors' => [
                    'required' => 'Metode penilaian harus dipilih',
                    'in_list' => 'Metode penilaian tidak valid'
                ]
            ]
        ];

        // if (!$this->validate($validationRules)) {
        //     return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        // }

        if (!$this->validate($validationRules)) {
            // Jika error validasi:
            return redirect()->to('/kriteria')
                ->withInput()
                ->with('errors', $validation->getErrors()) // Menggunakan 'errors' (bisa diakses via session('errors'))
                ->with('show_modal', 'add');
        }

        try {
            $this->kriteria->save([
                'kode_kriteria' => $this->request->getVar('kode_kriteria'),
                'nama_kriteria' => $this->request->getVar('nama_kriteria'),
                'tipe' => $this->request->getVar('tipe'),
                'bobot' => $this->request->getVar('bobot'),
                'pilih_inputan' => $this->request->getVar('pilih_inputan'),
            ]);

            session()->setFlashdata('success', 'Kriteria berhasil ditambahkan!');
            return redirect()->to('/kriteria');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan kriteria. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function update($id)
    {
        // Validasi input
        $validation = \Config\Services::validation();
        $validationRules = [
            'nama_kriteria' => [
                'rules' => "required|is_unique[kriteria.nama_kriteria,id_kriteria,{$id}]",
                'errors' => [
                    'required' => 'Nama kriteria harus diisi',
                    'is_unique' => 'Nama kriteria sudah ada'
                ]
            ],
            'tipe' => [
                'rules' => 'required|in_list[benefit,cost]',
                'errors' => [
                    'required' => 'Tipe kriteria harus dipilih',
                    'in_list' => 'Tipe kriteria tidak valid'
                ]
            ],
            'bobot' => [
                'rules' => 'required|decimal|greater_than[0]',
                'errors' => [
                    'required' => 'Bobot kriteria harus diisi',
                    'decimal' => 'Bobot harus berupa angka desimal',
                    'greater_than' => 'Bobot harus lebih besar dari 0'
                ]
            ],
            'pilih_inputan' => [
                'rules' => 'required|in_list[input_langsung,subkriteria]',
                'errors' => [
                    'required' => 'Metode penilaian harus dipilih',
                    'in_list' => 'Metode penilaian tidak valid'
                ]
            ]
        ];

        // if (!$this->validate($validationRules)) {
        //     return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        // }

        // Contoh di controller (update):
        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors())
                ->with('show_modal', 'edit')  // Identifier universal
                ->with('edit_id', $id);      // ID spesifik data yang diedit
        }

        try {
            $this->kriteria->update($id, [
                'nama_kriteria' => $this->request->getVar('nama_kriteria'),
                'tipe' => $this->request->getVar('tipe'),
                'bobot' => $this->request->getVar('bobot'),
                'pilih_inputan' => $this->request->getVar('pilih_inputan'),
            ]);

            session()->setFlashdata('success', 'Kriteria berhasil diperbarui!');
            return redirect()->to('/kriteria');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal memperbarui kriteria. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id)
    {
        $this->kriteria->delete($id);
        $this->subkriteria->delete($id);

        // pesan berhasil didelete
        session()->setFlashdata('success', 'Kriteria berhasil dihapus!');
        return redirect()->to('/kriteria');
    }
}
