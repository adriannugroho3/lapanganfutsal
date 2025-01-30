<?php

namespace App\Models;

use CodeIgniter\Model;

class BokingModel extends Model
{
    protected $table = 'boking';
    protected $primaryKey = 'kdBoking';
    protected $useTimestamps = false;
    protected $useSoftDeletess = true;
    protected $returnType     = 'object';
    protected $allowedFields = ['kdBoking', 'kdJadwal', 'noInvoice', 'atasNama', 'alamat', 'kontak', 'totalBayar', 'statusBoking', 'username', 'created_at'];

    public function getBokingByUser($userId)
    {
        $db      = \Config\Database::connect();

        $builder = $db->table($this->table);
        $builder->join('lapangan', 'boking.kdLapangan = lapangan.kdLap');
        $builder->join('status_boking', 'boking.kdStatus = status_boking.idStatus');
        $builder->where(['userId' => $userId]);

        return $builder->get()->getResult();
    }
}
