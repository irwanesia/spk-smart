<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianModel extends Model
{
    protected $table      = 'pembelian';
    protected $primaryKey = 'id_pembelian';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['id_user', 'id_mobil', 'id_sales', 'no_telp', 'tanggal_pembelian', 'metode_pembayaran'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function findPembelian($id = null)
    {
        $builder = $this->builder();
        $builder->select('*');
        $builder->join('mobil', 'mobil.id_mobil = pembelian.id_mobil');
        $builder->join('user', 'user.id_user = pembelian.id_user');
        $builder->join('user', 'user.id_user = pembelian.id_sales');

        // menambahkan kondisi jika $id disediakan
        if ($id != null) {
            // Menambahkan filter berdasarkan ID
            $builder->where('pembelian.id_pembelian', $id);
        }

        $query = $builder->get();
        return $query->getResultArray(); // Mengembalikan semua baris hasil sebagai array
    }

    public function getAllPembelian()
    {
        $builder = $this->db->table('pembelian p');
        $builder->select('p.*, m.nama_mobil, m.harga, m.gambar, u.nama as nama_user, u.alamat, us.nama as nama_sales, r.status, r.catatan');
        $builder->join('mobil m', 'm.id_mobil = p.id_mobil');
        $builder->join('users u', 'u.id_user = p.id_user');
        $builder->join('users us', 'us.id_user = p.id_sales');
        $builder->join('riwayat_pembelian r', 'r.id_pembelian = p.id_pembelian', 'left'); // Gunakan LEFT JOIN agar tetap muncul meski belum ada riwayat
        $builder->orderBy('p.tanggal_pembelian', 'DESC');
        $query = $builder->get();

        return $query->getResultArray();
    }

    public function getRiwayatByUser($id_user)
    {
        return $this->select('pembelian.*, mobil.nama_mobil, u2.role as nama_sales')
            ->join('mobil', 'mobil.id_monil = pembelian.id_mobil')
            ->join('user u2', 'u2.id_user = pembelian.id_sales') // sales
            ->where('pembelian.id_user', $id_user)
            ->orderBy('tanggal_pembelian', 'DESC')
            ->findAll();
    }

    // app/Models/PembelianModel.php

    public function getTopMobilPalingSeringDipilih($limit = 5)
    {
        return $this->db->table('pembelian')
            ->select('mobil.nama_mobil, mobil.tahun, COUNT(pembelian.id_mobil) as jumlah_pembelian, MAX(pembelian.tanggal_pembelian) as terakhir_dibeli')
            ->join('mobil', 'mobil.id_mobil = pembelian.id_mobil')
            ->groupBy('pembelian.id_mobil')
            ->orderBy('jumlah_pembelian', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }

    public function getStatistikPembelianPerBulan($tahun = null)
    {
        $tahun = $tahun ?? date('Y');

        return $this->db->table('pembelian')
            ->select('MONTH(tanggal_pembelian) as bulan, COUNT(*) as total')
            ->where('YEAR(tanggal_pembelian)', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan', 'ASC')
            ->get()
            ->getResultArray();
    }
}
