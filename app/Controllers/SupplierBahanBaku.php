<?php

namespace App\Controllers;

use App\Models\SupplierBahanBakuModel;
use App\Models\BahanBakuModel;
use App\Models\SupplierModel;
use App\Models\PenilaianModel;

class SupplierBahanBaku extends BaseController
{
    protected $bahanBaku;
    protected $penilaian;
    protected $supplier;
    protected $supplierBahanBaku;

    public function __construct()
    {
        $this->bahanBaku = new BahanBakuModel();
        $this->supplierBahanBaku = new SupplierBahanBakuModel();
        $this->penilaian = new PenilaianModel();
        $this->supplier  = new SupplierModel();
    }

    public function index($id_bahan_baku = null)
    {
        $data = [
            'title' => 'Supplier Bahan Baku',
            'id_bahan_baku' => $id_bahan_baku,
            'bahanBaku' => $this->bahanBaku->findAll(),
            'supplierBahanBakuById' => $this->supplierBahanBaku->findSupplierBahanBakuById($id_bahan_baku), // Gunakan data BahanBaku berdasarkan periode
            'supplierBahanBaku' => $this->supplierBahanBaku->findSupplierBahanBaku() // Gunakan data BahanBaku berdasarkan periode
        ];
        return view('Supplier-Bahan-Baku/index', $data);
    }

    public function tambah($id_bahan_baku = null)
    {
        $data = [
            'title' => 'Tambah Supplier Bahan Baku',
            'id_bahan_baku' => $id_bahan_baku,
            'supplier' => $this->supplier->findAll(),
            'bahanBaku' => $this->bahanBaku->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('Supplier-Bahan-Baku/tambah', $data);
    }

    public function simpan()
    {
        // validasi input
        if (!$this->validate([
            'BahanBaku' => [
                // 'rules' => 'required|is_unique[BahanBaku.nama_BahanBaku]',
                'errors' => [
                    'required' => 'nama {field} harus diisi!',
                    // 'is_unique' => 'BahanBaku {field} sudah ada!'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/SupplierBahanBaku/simpan')->withInput()->with('validation', $validation);
        }

        // session()->setFlashdata('pesan', $isipesan);
        $id_bahan_baku = $this->request->getVar('id_bahan_baku');

        $this->supplierBahanBaku->save([
            'id_supplier' => $this->request->getVar('id_supplier'),
            'id_bahan_baku' => $id_bahan_baku,
            'harga_supplier' => $this->request->getVar('harga_supplier'),
        ]);

        // pesan data berhasil ditambah
        $isipesan = '<script> alert("Supplier bahan baku berhasil ditambahkan!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/supplier-bahan-baku/' . $id_bahan_baku);
    }

    public function edit($id)
    {

        $data = [
            'title' => 'Edit Bahan Baku',
            'supplierBahanBaku' => $this->supplierBahanBaku->find($id),
            'supplier' => $this->supplier->findAll(),
            'bahanBaku' => $this->bahanBaku->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('Supplier-Bahan-Baku/edit', $data);
    }

    public function update($id)
    {
        // validasi input
        if (!$this->validate([
            'BahanBaku' => [
                // 'rules' => 'required|is_unique[BahanBaku.nama_BahanBaku]',
                'errors' => [
                    'required' => 'nama {field} harus diisi!',
                    // 'is_unique' => 'BahanBaku {field} sudah ada!'
                ]
            ]
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to('/SupplierBahanBaku/edit/' . $id)->withInput()->with('validation', $validation);
        }
        $id_bahan_baku = $this->request->getVar('id_bahan_baku');

        $this->bahanBaku->save([
            'id_supplier_bahan_baku' => $id,
            'id_supplier' => $this->request->getVar('id_supplier'),
            'id_bahan_baku' => $id_bahan_baku,
            'harga_supplier' => $this->request->getVar('harga_supplier'),
        ]);

        // pesan data berhasil ditambah
        $isipesan = '<script> alert("Supplier Bahan Baku berhasil diupdate!") </script>';
        session()->setFlashdata('pesan', $isipesan);

        return redirect()->to('/supplier-bahan-baku/' . $id_bahan_baku);
    }

    public function delete($id)
    {

        $db = db_connect(); // Dapatkan instance koneksi database
        $db->transStart(); // Mulai transaksi

        try {
            // Hapus data dari tabel anak (penilaian) terlebih dahulu
            $this->penilaian->where('id_bahan_baku', $id)->delete();

            // Kemudian hapus data dari tabel induk (cuti)
            $this->bahanBaku->delete($id);

            $db->transComplete(); // Selesaikan transaksi

            if ($db->transStatus() === FALSE) {
                // Jika ada yang salah, transaksi akan dirollback
                session()->setFlashdata('error', 'Gagal menghapus data bahan baku.');
                return redirect()->to('/SupplierBahanBaku');
            }

            // Jika tidak ada masalah, set pesan sukses
            session()->setFlashdata('pesan', '<script> alert("Data Bahan Baku berhasil dihapus!") </script>');
            return redirect()->to('/SupplierBahanBaku');
        } catch (\Exception $e) {
            $db->transRollback(); // Rollback transaksi jika terjadi exception
            session()->setFlashdata('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
            return redirect()->to('/SupplierBahanBaku');
        }
    }
}
