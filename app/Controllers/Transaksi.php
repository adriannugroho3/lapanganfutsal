<?php

namespace App\Controllers;

use App\Models\LapanganModel;
use App\Models\JadwalModel;
use App\Models\BokingModel;
use App\Models\InvoiceModel;
use App\Models\TransaksiModel;
use mysqli;

class Transaksi extends BaseController
{
    protected $db, $builder, $lapanganModel, $lapgn, $jadwl, $bokg, $session;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->lapanganModel = new LapanganModel();
        $this->jadwalModel = new JadwalModel();
        $this->bokingModel = new BokingModel();
        $this->invoiceModel = new InvoiceModel();
        $this->transaksiModel = new TransaksiModel();
        $this->lapgn = $this->db->table('lapangan');
        $this->jadwl = $this->db->table('jadwal');
        $this->bokg = $this->db->table('boking');
        $this->session = session();
    }
    public function view($id = 0)
    {
        $id = $this->request->uri->getSegment(3);
        $transaksiModel = $this->transaksiModel;
        $transaksi = $transaksiModel->join('jadwal', 'jadwal.kdJadwal=boking.kdJadwal')
            ->join('users', 'users.id=boking.usernameid')
            ->where('boking.kdboking', $id)
            ->first();

        var_dump($transaksi);
        return view('user/bokinginv', [
            'transaksi' => $transaksi,
        ]);
    }
}
