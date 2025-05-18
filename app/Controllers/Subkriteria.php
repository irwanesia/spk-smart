<?php

namespace App\Controllers;

use App\Models\SubKriteriaModel;
use App\Models\KriteriaModel;

class Subkriteria extends BaseController
{
    protected $kriteria;
    protected $subKriteria;

    public function __construct()
    {
        $this->kriteria = new KriteriaModel();
        $this->subKriteria = new SubKriteriaModel();
    }

    public function simpan($id = null)
    {
        // Validasi input
        $validationRules = [
            'id_kriteria' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'ID Kriteria harus diisi',
                    'numeric' => 'ID Kriteria harus berupa angka'
                ]
            ],
            'nama_subkriteria' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Nama Subkriteria harus diisi',
                    'max_length' => 'Nama Subkriteria maksimal 255 karakter'
                ]
            ],
            'nilai' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nilai harus diisi',
                    'numeric' => 'Nilai harus berupa angka'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            // Jika error validasi:
            return redirect()->to('/kriteria')
                ->withInput()
                ->with('errors', $this->validator->getErrors()) // Menggunakan 'errors' (bisa diakses via session('errors'))
                ->with('show_modal', 'addSubkriteria-modal');
        }

        try {
            $data = [
                'id_kriteria' => $this->request->getVar('id_kriteria'),
                'nama_subkriteria' => $this->request->getVar('nama_subkriteria'),
                'nilai' => $this->request->getVar('nilai'),
            ];

            // Cek apakah ini penyimpanan baru atau update
            if ($id) {
                $data['id_subkriteria'] = $id;
            }

            $this->subKriteria->save($data);

            $message = $id ? 'Subkriteria berhasil diperbarui!' : 'Subkriteria berhasil ditambahkan!';
            session()->setFlashdata('success', $message);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }

        return redirect()->to('/kriteria');
    }


    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validationRules = [
            'id_kriteria' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'ID Kriteria harus diisi',
                    'numeric' => 'ID Kriteria harus berupa angka'
                ]
            ],
            'nama_subkriteria' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Nama Subkriteria harus diisi',
                    'max_length' => 'Nama Subkriteria maksimal 255 karakter'
                ]
            ],
            'nilai' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nilai harus diisi',
                    'numeric' => 'Nilai harus berupa angka'
                ]
            ]
        ];

        // Contoh di controller (update):
        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors())
                ->with('show_modal', 'edit')  // Identifier universal
                ->with('edit_id', $id);      // ID spesifik data yang diedit
        }

        try {
            $this->subKriteria->update($id, [
                'id_kriteria' => $this->request->getVar('id_kriteria'),
                'nama_subkriteria' => $this->request->getVar('nama_subkriteria'),
                'nilai' => $this->request->getVar('nilai'),
            ]);

            session()->setFlashdata('success', 'Subkriteria berhasil diperbarui!');
            return redirect()->to('/kriteria');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal memperbarui subkriteria. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id)
    {
        $this->subKriteria->delete($id);

        // pesan berhasil didelete
        session()->setFlashdata('success', 'Data subkriteria berhasil dihapus!');
        return redirect()->to('/kriteria');
    }
}
