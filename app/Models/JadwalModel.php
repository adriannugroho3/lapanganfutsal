<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'kdJadwal';
    protected $useTimestamps = true;
    //protected $useSoftDeletess = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['kdJadwal', 'tglJadwal', 'kdLap', 'jamBo', 'harga', 'statusBoking'];

    // public function getlapangan($id = false)
    // {
    //     if ($id == false) {
    //         return $this->findAll();
    //     }

    //     return $this->where(['slug' => $id])->first();
    // }
}
