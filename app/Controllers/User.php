<?php

namespace App\Controllers;

use App\Models\LapanganModel;
use App\Models\JadwalModel;
use App\Models\BokingModel;
use App\Models\InvoiceModel;
use App\Models\TransaksiModel;
use mysqli;
use TCPDF;

class User extends BaseController
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
        $this->bokg = new BokingModel();
        $this->session = session();
    }

    public function index()
    {
        return view('user/index');
    }
    public function transaksi()
    {
        $data['title'] = 'Admin - Centro';

        // $this->jadwl->select('jadwal.kdJadwal, tglJadwal, kdLap, jamBo, harga, statusBoking,');
        // $query = $this->jadwl->get();

        // $data['jadwal'] = $query->getResult();
        $boking = $this->bokg->getBokingByUser(user_id());
        $data['boking'] = $boking;


        return view('user/transaksi', $data);
    }
    public function tboking($kdLap)
    {
        $data = [
            'title' => 'Centro',
            'validation' => \Config\Services::validation(),
            'lapangan' => $this->lapanganModel->getOneByID($kdLap),
            'jadwal' => $this->jadwl->get()->getFirstRow()
        ];
        return view('user/transaksirci', $data);
    }


    public function tamboking()
    {


        //validasi input
        $validate = $this->validate([
            'atasNama' => [
                'rules' => 'required[boking.atasNama]',
                'errors' => [
                    'required' => ' No atasNama harus di isi.',
                ],
            ],
            'alamat' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => ' alamat harus di isi.',
                    'min_length' => ' deskripsi min 10 karakter'
                ],
            ],
            'kontak' => [
                'rules' => 'required|min_length[12]',
                'errors' => [
                    'required' => ' deskripsi harus di isi.',
                    'min_length' => ' deskripsi min 12 karakter'
                ]
            ],
            'jamMulai' => [
                'rules' => 'required[boking.jamMulai]',
                'errors' => [
                    'required' => ' No jamMulai harus di isi.',
                ],
            ],
            'jamSelesai' => [
                'rules' => 'required[boking.jamSelesai]',
                'errors' => [
                    'required' => ' No jamSelesai harus di isi.',
                ],
            ]
        ]);
        if (!$validate) {


            // $validation = \Config\Services::validation();
            //dd($validation);
            //return redirect()->to('/admin/tlapangan')->withInput()->with('validation', $validation);
            //    $data['validation'] = $validation
            //    return view('/admin/ceatelap', $data)
            return redirect()->back()->withInput();
        }
        // $conn = \Config\Database::connect();

        // $query = $this->bokg->selectMax('noInvoice');
        // $kodeJadi = $query->$this->bokg('noInvoice');
        // $noOrder = (int)substr($kodeJadi, 4, 6);
        // $noOrder++;
        // $char = "INV-";
        // $newID = $char . sprintf("%06s", $noOrder);
        // $inv = $this->bokg->get($newID);
        // $this->bokg->select('boking.kdBoking, tglInvoice, noInvoice, atasNama, alamat, kontak, totalBayar, statusBayar, kdJadwal, noLap, jamBo, harga, statusBoking, ');
        // $this->bokg->join('jadwal', 'jadwal.kdJadwal = boking.kdJadwal ');
        // $jadwalid = $this->jadwalModel->insert_id();
        // $this->bokg->select('boking.kdBoking, tglInvoice, noInvoice, atasNama, alamat, kontak, totalBayar, statusBayar ');
        // $this->bokg->where('kdBoking');
        $data = [
            // 'noInvoice'  => ,
            //'kdJadwal'  =>  $jadwalid,
            'userId'  =>  $this->request->getVar('userId'),
            'kdLapangan'  =>  $this->request->getVar('kdLapangan'),
            'noInvoice'  =>  $this->request->getVar('noInvoice'),
            'tglBooking'  =>  $this->request->getVar('tglBooking'),
            'tglInvoice'  =>  $this->request->getVar('tglInvoice'),
            'kontak'  =>  $this->request->getVar('kontak'),
            'alamat'  =>  $this->request->getVar('alamat'),
            'atasNama'  => $this->request->getVar('atasNama'),
            'jamMulaiBooking'  => $this->request->getVar('jamMulai'),
            'jamSelesaiBooking'  => $this->request->getVar('jamSelesai'),
            'totalBayar'  => $this->request->getVar('totalharga'),
            'kdStatus'  => 'menunggu_pembayaran',
        ];

        $this->transaksiModel->insert($data);
        $data = $this->request->getPost();
        $id = $this->request->uri->getSegment(3);
        $id = $this->transaksiModel->insertID();


        // if ($data != null) {
        //     $query = $this->jadwl->getWhere(['kdBoking' => $data]);
        //     if ($query->resultID->num_rows > 0) {
        //         $data['title'] = 'Transaksi';

        //     } else {
        //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        //     }
        // } else {
        //     throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        // }

        // $this->lapgn->insert($data);
        // Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')

        // $this->lapanganModel->save([
        //     'noLap' => $this->request->getVar('noLap'),
        //     'gambarLap' => $this->request->getVar('gambarLap'),
        //     'deskripsi' => $this->request->getVar('deskripsi')

        // ]);
        // $data['title'] = 'Tambah-Data';

        $segment = ['user', 'rctransaksi', $id];
        var_dump($segment);
        return redirect()->to(site_url($segment));
        // return view('admin/tlapangan', $data);
    }
    public function editaksi($id = null)
    {
        // $this->jadwl->select('jadwal.kdJadwal, tglInvoice, noInvoice, atasNama, alamat, kontak, totalBayar, statusBayar, noLap, jamBo, harga, tglJadwal,');
        // $this->jadwl->join('lapangan', 'lapangan.kdLap = jadwal.kdLap ');
        // $this->jadwl->join('boking', 'boking.kdJadwal = jadwal.kdJadwal ');
        // $this->jadwl->where('jadwal.kdJadwal', $id);
        // $this->jadwl->orderBy('jadwal.kdJadwal', 'DESC');
        // $this->bokg->select('boking.kdBoking, tglInvoice, noInvoice, usernameid, atasNama, alamat, kontak, totalBayar, statusBayar, username, noLap, jamBo, harga, tglJadwal');
        // $this->bokg->join('users', 'users.id = boking.usernameid ');
        // $this->bokg->join('jadwal', 'jadwal.kdJadwal = boking.kdJadwal ');
        // $this->bokg->join('lapangan', 'lapangan.kdLap = jadwal.kdLap ');

        // $query = $this->jadwl->get();

        // $data['jadwal'] = $query->getRow();


        if ($id != null) {
            $query = $this->jadwl->getWhere(['kdJadwal' => $id]);
            if ($query->resultID->num_rows > 0) {
                $data['title'] = 'Transaksi';
                $data['jadwal'] = $query->getRow();
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // var_dump($data);
        return view('user/transaksirci', $data);
    }

    public function edirci($id = null)
    {
        // $this->jadwl->select('jadwal.kdJadwal, tglInvoice, noInvoice, atasNama, alamat, kontak, totalBayar, statusBayar, noLap, jamBo, harga, tglJadwal,');
        // $this->jadwl->join('lapangan', 'lapangan.kdLap = jadwal.kdLap ');
        // $this->jadwl->join('boking', 'boking.kdJadwal = jadwal.kdJadwal ');
        // $this->jadwl->where('jadwal.kdJadwal', $id);
        // $this->jadwl->orderBy('jadwal.kdJadwal', 'DESC');
        // $this->bokg->select('boking.kdBoking, tglInvoice, noInvoice, usernameid, atasNama, alamat, kontak, totalBayar, statusBayar, username, noLap, jamBo, harga, tglJadwal');
        // $this->bokg->join('users', 'users.id = boking.usernameid ');
        // $this->bokg->join('jadwal', 'jadwal.kdJadwal = boking.kdJadwal ');
        // $this->bokg->join('lapangan', 'lapangan.kdLap = jadwal.kdLap ');

        // $query = $this->jadwl->get();

        // $data['jadwal'] = $query->getRow();

        // $bo['boking'] = mysqli_fetch_assoc($dat);
        if ($id != null) {
            $query = $this->bokg->getWhere(['userId' => $id]);
            if ($query->resultID->num_rows > 0) {
                $data['title'] = 'Transaksi';
                $data['boking'] = $query->getRow();
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        var_dump($data);
        return view('user/bokinginv', $data);
    }

    public function rctransaksi()
    {
        $data = $this->request->getPost();
        $id = $this->request->uri->getSegment(3);
        $data['title'] = 'User Detail';

        $this->bokg->select('boking.kdBoking, kdboking, userId, noInvoice, tglInvoice, atasNama, alamat, kontak, totalBayar, kdStatus,username, noLap,jamMulaiBooking, jamSelesaiBooking,harga, totalBayar');
        $this->bokg->join('lapangan', 'lapangan.kdLap = boking.kdLapangan ');
        $this->bokg->join('users', 'users.id=boking.userId');
        $this->bokg->where('boking.kdBoking', $id);
        $query = $this->bokg->get();

        $data['boking'] = $query->getRow();

        var_dump($data);

        return view('user/ts', $data);
    }
    public function invoice()
    {
        $data = $this->request->getPost();
        $id = $this->request->uri->getSegment(3);
        $data['title'] = 'User Detail';

        $this->bokg->select('boking.kdBoking, kdboking, userId, noInvoice, tglInvoice, atasNama, alamat, kontak, totalBayar, kdStatus,username, noLap,jamMulaiBooking, jamSelesaiBooking,harga, totalBayar');
        $this->bokg->join('lapangan', 'lapangan.kdLap = boking.kdLapangan ');
        $this->bokg->join('users', 'users.id=boking.userId');
        $this->bokg->where('boking.kdBoking', $id);
        $query = $this->bokg->get();

        $data['boking'] = $query->getRow();

        var_dump($data);

        $html = view('user/invoice', $data);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Centro Futsal');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->addPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        //line ini penting
        $this->response->setContentType('application/pdf');
        ob_end_clean();
        //Close and output PDF document
        $pdf->Output('invoice.pdf', 'I');
    }
}
