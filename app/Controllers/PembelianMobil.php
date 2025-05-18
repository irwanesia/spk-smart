<?php

namespace App\Controllers;

use App\Models\MobilModel;
use App\Models\UsersModel;
use App\Models\PembelianModel;
use App\Models\RiwayatPembelianModel;

class PembelianMobil extends BaseController
{
    protected $mobil;
    protected $pembelian;
    protected $user;
    protected $riwayatPembelian;

    public function __construct()
    {
        $this->mobil = new mobilModel();
        $this->pembelian = new PembelianModel();
        $this->riwayatPembelian = new RiwayatPembelianModel();
        $this->user = new UsersModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pembelian Mobil',
            'users' => $this->user->findAll(),
            'mobils' => $this->mobil->findAll(),
            'salesList' => $this->user->where('role', 'sales')->findAll(),
            'pembelian' => $this->pembelian->getAllPembelian() // Gunakan data mobil berdasarkan periode
        ];
        return view('Pembelian/index', $data);
    }

    public function simpan()
    {
        // validasi input
        $validationRules = [
            'no_telp' => [
                'rules' => 'required|min_length[10]|max_length[15]|regex_match[/^[0-9]+$/]',
                'errors' => [
                    'required' => 'No telepon harus diisi!',
                    'min_length' => 'No telepon minimal 10 digit',
                    'max_length' => 'No telepon maksimal 15 digit',
                    'regex_match' => 'No telepon hanya boleh mengandung angka'
                ]
            ],
            'id_sales' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Sales harus dipilih!',
                    'numeric' => 'Data sales tidak valid'
                ]
            ],
            'payment_method' => [
                'rules' => 'required|in_list[transfer,credit,cash]',
                'errors' => [
                    'required' => 'Metode pembayaran harus dipilih!',
                    'in_list' => 'Metode pembayaran tidak valid'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            // Ambil parameter cars dari URL sebelumnya
            $carsParam = $this->request->getVar('cars') ?? '';
            // dd($carsParam);
            // Jika error validasi:
            return redirect()->to('/proses-perbandingan?cars=' . $carsParam)
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('show_modal', 'add');
        }

        try {
            // Simpan data ke database
            $this->pembelian->save([
                'id_user' => $this->request->getVar('id_user'),
                'id_mobil' => $this->request->getVar('id_mobil'),
                'id_sales' => $this->request->getVar('id_sales'),
                'no_telp' => $this->request->getVar('no_telp'),
                'tanggal_pembelian' => $this->request->getVar('tgl_pembelian'),
                'metode_pembayaran' => $this->request->getVar('payment_method')
            ]);

            $idPembelian = $this->pembelian->insertID(); // ambil id_pembelian yang baru saja disimpan

            // Simpan data ke tabel riwayat
            $this->riwayatPembelian->save([
                'id_pembelian' => $idPembelian,
                'status' => $this->request->getVar('status'),
                'catatan' => $this->request->getVar('catatan') ?? null
            ]);

            session()->setFlashdata('success', 'Pembelian berhasil! Cek detail di halaman riwayat Pembelian Saya!');
            return redirect()->to('/riwayat-pembelian');
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            session()->setFlashdata('error', 'Pembelian mobil gagal. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function update($id)
    {
        // Gunakan service database
        $db = \Config\Database::connect();

        // 1. Tambahkan validasi untuk semua field yang digunakan
        $validationRules = [
            'no_telp' => [
                'rules' => 'required|min_length[10]|max_length[15]|regex_match[/^[0-9]+$/]',
                'errors' => [
                    'required' => 'No telepon harus diisi!',
                    'min_length' => 'No telepon minimal 10 digit',
                    'max_length' => 'No telepon maksimal 15 digit',
                    'regex_match' => 'No telepon hanya boleh mengandung angka'
                ]
            ],
            'id_sales' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Sales harus dipilih!',
                    'numeric' => 'Data sales tidak valid'
                ]
            ],
            'id_user' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'User harus dipilih!',
                    'numeric' => 'Data user tidak valid'
                ]
            ],
            'id_mobil' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Mobil harus dipilih!',
                    'numeric' => 'Data mobil tidak valid'
                ]
            ],
            'payment_method' => [
                'rules' => 'required|in_list[transfer,credit,cash]',
                'errors' => [
                    'required' => 'Metode pembayaran harus dipilih!',
                    'in_list' => 'Metode pembayaran tidak valid'
                ]
            ],
            'alamat' => [
                'rules' => 'required|min_length[10]|max_length[100]',
                'errors' => [
                    'required' => 'Alamat harus diisi!',
                    'min_length' => 'Alamat minimal 10 karakter',
                    'max_length' => 'Alamat maksimal 100 karakter'
                ]
            ],
            'tanggal_pembelian' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal pembelian harus diisi!',
                    'valid_date' => 'Format tanggal tidak valid'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors())
                ->with('show_modal', 'edit')
                ->with('edit_id', $id);
        }

        try {
            // Mulai transaksi database
            $db->transBegin();

            // Ambil semua input
            $idUser = $this->request->getVar('id_user');
            $idMobil = $this->request->getVar('id_mobil');
            $idSales = $this->request->getVar('id_sales');
            $noTelp = $this->request->getVar('no_telp');
            $tglPembelian = $this->request->getVar('tanggal_pembelian');
            $metodePembayaran = $this->request->getVar('payment_method');
            $alamat = $this->request->getVar('alamat');
            $status = $this->request->getVar('status') ?? null;
            $catatan = $this->request->getVar('catatan') ?? null;

            // 1. Cek apakah data pembelian ada
            $pembelian = $this->pembelian->find($id);
            if (!$pembelian) {
                throw new \Exception('Data pembelian tidak ditemukan');
            }

            // 2. Update data pembelian
            $this->pembelian->update($id, [
                'id_user' => $idUser,
                'id_mobil' => $idMobil,
                'id_sales' => $idSales,
                'no_telp' => $noTelp,
                'tanggal_pembelian' => $tglPembelian,
                'metode_pembayaran' => $metodePembayaran
            ]);

            // 3. Update alamat user
            $this->user->update($idUser, [
                'alamat' => $alamat
            ]);

            // 4. Update riwayat pembelian
            $this->riwayatPembelian
                ->where('id_pembelian', $id)
                ->set([
                    'status' => $status,
                    'catatan' => $catatan
                ])
                ->update();

            // Commit transaksi jika semua berhasil
            $db->transCommit();

            session()->setFlashdata('success', 'Data pembelian mobil berhasil di edit!');
            return redirect()->to('/pembelian');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            $db->transRollback();

            log_message('error', $e->getMessage());
            log_message('error', print_r($this->request->getPost(), true)); // Log data input

            session()->setFlashdata('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('show_modal', 'edit')
                ->with('edit_id', $id);
        }
    }

    public function delete($id_pembelian)
    {
        try {
            // 3. Cari data pembelian
            $pembelian = $this->pembelian->find($id_pembelian);

            if (!$pembelian) {
                log_message('notice', 'Users' . session()->get('id_user') . ' mencoba menghapus pembelian tidak ditemukan ID: ' . $id_pembelian);
                session()->setFlashdata('error', 'Data pembelian tidak ditemukan!');
                return redirect()->to('/pembelian');
            }

            // Log sebelum penghapusan
            log_message('info', 'User ' . session()->get('id_user') . ' memulai proses penghapusan pembelian ID: ' . $id_pembelian);

            $deleted = $this->pembelian->delete($id_pembelian); // Hapus pembelian dari database

            if (!$deleted) {
                log_message('error', 'Gagal menghapus data pembelian ID: ' . $id_pembelian . ' dari database');
                throw new \RuntimeException('Gagal menghapus data dari database');
            }

            // Log setelah penghapusan berhasil
            log_message('info', 'User ' . session()->get('id_user') . ' berhasil menghapus pembelian ID: ' . $id_pembelian);

            // 6. Pesan sukses
            session()->setFlashdata('success', 'Data pembelian berhasil dihapus!');
        } catch (\Exception $e) {
            log_message('error', 'Error saat menghapus pembelian ID: ' . $id_pembelian . ' - ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }

        return redirect()->to('/pembelian');
    }

    public function riwayat()
    {
        $userId = session()->get('id_user');

        $data['pembelian'] = $this->pembelian->getRiwayatByUser($userId);
        return view('riwayat_pembelian', $data);
    }
}
