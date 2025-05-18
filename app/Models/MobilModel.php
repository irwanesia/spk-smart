<?php

namespace App\Models;

use CodeIgniter\Model;

class mobilModel extends Model
{
    protected $table      = 'mobil';
    protected $primaryKey = 'id_mobil';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['nama_mobil', 'merk', 'harga', 'tahun', 'gambar', 'deskripsi', 'tersedia'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getMobilTerbaru($limit = 6)
    {
        return $this->orderBy('updated_at', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    // Hitung total mobil
    public function getTotalMobil()
    {
        return $this->db->table('mobil')->countAll();
    }
}
