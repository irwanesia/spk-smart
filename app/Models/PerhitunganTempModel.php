<?php

namespace App\Models;

use CodeIgniter\Model;

class PerhitunganTempModel extends Model
{
    protected $table      = 'perhitungan_temp';
    protected $primaryKey = 'id_temp';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['id_user', 'id_mobil'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getPerhitunganTemp($id_user)
    {
        return $this->db->table('perhitungan_temp')
            ->select('id_mobil')
            ->where('id_user', $id_user)
            ->get()
            ->getResultArray();
    }
}
