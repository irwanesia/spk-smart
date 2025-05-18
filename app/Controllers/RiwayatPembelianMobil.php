<?php

namespace App\Controllers;

use App\Models\MobilModel;
use App\Models\RiwayatPembelianModel;

class RiwayatPembelianMobil extends BaseController
{
    protected $mobil;
    protected $riwayatPembelian;

    public function __construct()
    {
        $this->mobil = new mobilModel();
        $this->riwayatPembelian = new RiwayatPembelianModel();
    }

    public function index()
    {
        $id = session()->get('id_user');
        $data = [
            'title' => 'Riwayat Pembelian Mobil',
            'riwayatPembelian' => $this->riwayatPembelian->getRiwayatByUser($id) // Gunakan data mobil berdasarkan periode
        ];
        return view('Riwayat-Pembelian-Mobil/index', $data);
    }

    public function simpan()
    {
        // validasi input
        $validationRules = [
            'nama_mobil' => [
                'rules' => 'required|is_unique[mobil.nama_mobil]', // Perbaikan: tabel seharusnya 'mobil' bukan 'user'
                'errors' => [
                    'required' => 'Nama {field} harus diisi!',
                    'is_unique' => 'nama_mobil {field} sudah ada!'
                ]
            ],
            'merk' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama merk harus diisi!'
                ]
            ],
            'harga' => [
                'rules' => 'required|regex_match[/^[0-9]+(\.[0-9]{1,2})?$/]',
                'errors' => [
                    'required' => 'Harga harus diisi!',
                    'numeric' => 'Harga harus berupa angka!',
                    'regex_match' => 'Harga tidak valid!'
                ]
            ],
            'tahun' => [
                'rules' => 'required|regex_match[/^[0-9]{4}$/]',
                'errors' => [
                    'required' => 'Tahun harus diisi!',
                    'regex_match' => 'Tahun tidak valid!'
                ]
            ],
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]|ext_in[gambar,jpg,jpeg,png]',
                'errors' => [
                    'uploaded' => 'Gambar harus diisi!',
                    'max_size' => 'Ukuran gambar terlalu besar! Maksimal 2MB.',
                    'mime_in' => 'Format file harus JPG/JPEG/PNG',
                    'ext_in' => 'Ekstensi file harus .jpg/.jpeg/.png'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            // Jika error validasi:
            return redirect()->to('/mobil')
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('show_modal', 'add');
        }

        try {
            // Proses upload gambar
            $gambar = $this->request->getFile('gambar');
            $newName = '';

            if ($gambar->isValid() && !$gambar->hasMoved()) {
                // Generate nama gambar unik untuk menghindari konflik
                $newName = $gambar->getRandomName(); // Generate nama unik
                $gambar->move(WRITEPATH . 'uploads', $newName); // Simpan di folder writable/uploads

                // Simpan data ke database
                $this->mobil->save([
                    'nama_mobil' => $this->request->getVar('nama_mobil'),
                    'merk' => $this->request->getVar('merk'),
                    'harga' => $this->request->getVar('harga'),
                    'tahun' => $this->request->getVar('tahun'),
                    'gambar' => $newName, // Simpan nama file baru, bukan objek file
                    'deskripsi' => $this->request->getVar('deskripsi'),
                    'tersedia' => 1
                ]);
            }
            session()->setFlashdata('success', 'Mobil berhasil ditambahkan!');
            return redirect()->to('/mobil');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Gagal menambahkan mobil. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function update($id)
    {
        // 1. Cek keberadaan data
        $mobil = $this->mobil->find($id);
        if (!$mobil) {
            return redirect()->to('/mobil')->with('error', 'Data mobil tidak ditemukan!');
        }

        // 2. Siapkan validasi
        $validationRules = [
            'nama_mobil' => [
                'rules' => "required|is_unique[mobil.nama_mobil,id_mobil,{$id}]",
                'errors' => [
                    'required' => 'Nama mobil harus diisi!',
                    'is_unique' => 'Nama mobil sudah digunakan!'
                ]
            ],
            'merk' => ['rules' => 'required', 'errors' => ['required' => 'Merk harus diisi!']],
            'harga' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Harga harus diisi!',
                    'numeric' => 'Harga harus angka!'
                ]
            ],
            'tahun' => [
                'rules' => 'required|exact_length[4]|numeric',
                'errors' => [
                    'required' => 'Tahun harus diisi!',
                    'exact_length' => 'Tahun harus 4 digit!',
                    'numeric' => 'Tahun harus angka!'
                ]
            ]
        ];

        // 3. Handle upload gambar
        $gambar = $this->request->getFile('gambar');
        // TAMBAHKAN KONDISI INI:
        // Jika ada file gambar diupload, tambahkan validasi gambar
        if ($gambar->isValid()) {
            $validationRules['gambar'] = [
                'rules' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran maksimal 2MB!',
                    'is_image' => 'File harus berupa gambar!',
                    'mime_in' => 'Format harus JPG/JPEG/PNG!'
                ]
            ];
        }

        // 4. Jalankan validasi
        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('show_modal', 'edit')
                ->with('edit_id', $id);
        }

        // Proses gambar hanya jika ada upload baru
        $gambarName = $mobil['gambar']; // Default pakai gambar lama
        if ($gambar->isValid() && !$gambar->hasMoved()) {
            $newName = $gambar->getRandomName();
            $gambar->move(FCPATH . 'uploads', $newName);

            if ($mobil['gambar'] && file_exists(FCPATH . 'uploads/' . $mobil['gambar'])) {
                unlink(FCPATH . 'uploads/' . $mobil['gambar']);
            }

            $gambarName = $newName;
        }

        // 5. Siapkan data update
        $data = [
            'id_mobil' => $id,
            'nama_mobil' => $this->request->getPost('nama_mobil'),
            'merk' => $this->request->getPost('merk'),
            'harga' => str_replace('.', '', $this->request->getPost('harga')), // Handle format angka
            'tahun' => $this->request->getPost('tahun'),
            'gambar' => $gambarName,
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tersedia' => $this->request->getPost('tersedia') ?? 1,
            'updated_at' => date('Y-m-d H:i:s') // Timestamp update
        ];

        // 6. Simpan perubahan
        try {
            $this->mobil->save($data);
            session()->setFlashdata('success', 'Data mobil berhasil diperbarui!');
        } catch (\Exception $e) {
            log_message('error', 'Error update mobil: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal memperbarui data!');
        }

        return redirect()->to('/mobil');
    }

    public function delete($id_mobil)
    {
        try {
            // 1. Authentication - Pastikan user sudah login
            // 2. Authorization - Pastikan user memiliki role yang sesuai
            if (!in_array(session()->get('role'), ['admin', 'pelanggan', 'sales'])) {
                log_message('warning', 'User ' . session()->get('id_user') . ' mencoba menghapus mobil tanpa akses');
                session()->setFlashdata('error', 'Anda tidak memiliki izin untuk menghapus data mobil!');
                return redirect()->to('/mobil');
            }

            // 3. Cari data mobil
            $mobil = $this->mobil->find($id_mobil);

            if (!$mobil) {
                log_message('notice', 'Users' . session()->get('id_user') . ' mencoba menghapus mobil tidak ditemukan ID: ' . $id_mobil);
                session()->setFlashdata('error', 'Data mobil tidak ditemukan!');
                return redirect()->to('/mobil');
            }

            // Log sebelum penghapusan
            log_message('info', 'User ' . session()->get('id_user') . ' memulai proses penghapusan mobil ID: ' . $id_mobil);

            // 4. Hapus gambar terkait jika ada
            if (!empty($mobil['gambar']) && file_exists('uploads/' . $mobil['gambar'])) {
                if (!unlink('assets/uploads/' . $mobil['gambar'])) {
                    log_message('error', 'Gagal menghapus file gambar mobil ID: ' . $id_mobil);
                    throw new \RuntimeException('Gagal menghapus file gambar');
                }
                log_message('info', 'File gambar mobil ID: ' . $id_mobil . ' berhasil dihapus');
            }

            // 5. Hapus data dari database
            $deletedPenilaian = $this->penilaian->where('id_mobil', $id_mobil)->delete(); // Hapus penilaian terkait
            if ($deletedPenilaian === false) {
                log_message('error', 'Gagal menghapus penilaian terkait mobil ID: ' . $id_mobil);
                throw new \RuntimeException('Gagal menghapus penilaian terkait');
            }
            log_message('info', 'Penilaian terkait mobil ID: ' . $id_mobil . ' berhasil dihapus');

            $deleted = $this->mobil->delete($id_mobil); // Hapus mobil dari database

            if (!$deleted) {
                log_message('error', 'Gagal menghapus data mobil ID: ' . $id_mobil . ' dari database');
                throw new \RuntimeException('Gagal menghapus data dari database');
            }

            // Log setelah penghapusan berhasil
            log_message('info', 'User ' . session()->get('id_user') . ' berhasil menghapus mobil ID: ' . $id_mobil);

            // 6. Pesan sukses
            session()->setFlashdata('success', 'Data mobil berhasil dihapus!');
        } catch (\Exception $e) {
            log_message('error', 'Error saat menghapus mobil ID: ' . $id_mobil . ' - ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }

        return redirect()->to('/mobil');
    }
}
