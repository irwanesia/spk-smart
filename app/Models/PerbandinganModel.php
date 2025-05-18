<?php

namespace App\Models;

use CodeIgniter\Model;

class PerbandinganModel extends Model
{
    protected $table      = 'perbandingan';
    protected $primaryKey = 'id_perbandingan';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['id_user', 'tanggal', 'keterangan'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
