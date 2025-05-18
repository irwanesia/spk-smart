<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatPembelianModel extends Model
{
    protected $table      = 'riwayat_pembelian ';
    protected $primaryKey = 'id_riwayat';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id_pembelian', 'status', 'catatan'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getRiwayatByUser($id_user)
    {
        return $this->select('riwayat_pembelian.*, p.*, m.nama_mobil, u.nama AS nama_sales, u.alamat')
            ->join('pembelian p', 'p.id_pembelian = riwayat_pembelian.id_pembelian')
            ->join('mobil m', 'm.id_mobil = p.id_mobil')
            ->join('users u', 'u.id_user = p.id_sales')
            ->where('p.id_user', $id_user)
            ->orderBy('p.tanggal_pembelian', 'DESC')
            ->findAll();
    }
}
