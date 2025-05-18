<?php

namespace App\Models;

use CodeIgniter\Model;

class PerbandinganHasilModel extends Model
{
    protected $table      = 'perbandingan_hasil';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['id_perbandingan', 'id_mobil', 'nilai_preferensi', 'ranking'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
