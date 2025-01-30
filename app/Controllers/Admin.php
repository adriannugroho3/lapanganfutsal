<?php

namespace App\Controllers;

use App\Models\LapanganModel;
use App\Models\JadwalModel;
use App\Models\BokingModel;
use App\Models\InvoiceModel;
use TCPDF;

class Admin extends BaseController
{

    protected $db, $builder, $lapanganModel, $lapgn, $jadwl, $bokg, $dompdf;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
        $this->lapanganModel = new LapanganModel();
        $this->jadwalModel = new JadwalModel();
        $this->bokingModel = new BokingModel();
        $this->invoiceModel = new InvoiceModel();
        $this->lapgn = $this->db->table('lapangan');
        $this->jadwl = $this->db->table('jadwal');
        $this->bokg = $this->db->table('boking');
    }

    public function index()
    {
        $data['title'] = 'Admin - Centro';
        // $users = new \Myth\Auth\Models\UserModel();
        // $data['users'] = $users->findAll();


        $this->builder->select('users.id as userid, username, email, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $this->builder->get();

        $data['users'] = $query->getResult();
        var_dump($data);
        return view('admin/index', $data);
    }

    public function detail($id = 0)
    {
        $data['title'] = 'User Detail';

        $this->builder->select('users.id as userid, username, email, fullname, user_image, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();

        $data['user'] = $query->getRow();

        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }

        return view('admin/detail', $data);
    }

    public function lapangan()
    {
        $data = $this->request->getPost();
        $lapangan = $this->lapanganModel->findAll();
        $data['title'] = 'Lapangan';
        $data['lapangan'] = $lapangan;


        // $this->builder->select('users.id as userid, username, email, fullname, user_image, name');
        // $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        // $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        // $this->builder->where('users.id', $id);
        // $query = $this->builder->get();

        // $data['user'] = $query->getRow();

        // if (empty($data['user'])) {
        //     return redirect()->to('/admin');
        // }

        return view('admin/lapangan', $data);
    }

    public function tlapangan()
    {

        $data = [
            'title' => 'Tambah-Data',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/tlapangan', $data);
    }

    public function savelap()
    {
        //validasi input
        $validate = $this->validate([
            'noLap' => [
                'rules' => 'required|is_unique[lapangan.noLap]',
                'errors' => [
                    'required' => ' No lapangan harus di isi.',
                    'is_unique' => ' No lapangan sudah terdaftar'
                ],
            ],
            'gambarLap' => [
                'rules' => 'required|is_unique[lapangan.gambarLap]',
                'errors' => [
                    'required' => ' gambar lapangan harus di isi.',
                    'is_unique' => ' gambar lapangan sudah terdaftar'
                ],
            ],
            'deskripsi' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => ' deskripsi harus di isi.',
                    'min_length' => ' deskripsi min 10 karakter'
                ]
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


        $data = [
            'noLap' => $this->request->getVar('noLap'),
            'gambarLap'  => $this->request->getVar('gambarLap'),
            'deskripsi'  => $this->request->getVar('deskripsi'),
        ];

        $this->lapgn->insert($data);
        // Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')

        // $this->lapanganModel->save([
        //     'noLap' => $this->request->getVar('noLap'),
        //     'gambarLap' => $this->request->getVar('gambarLap'),
        //     'deskripsi' => $this->request->getVar('deskripsi')

        // ]);
        // $data['title'] = 'Tambah-Data';
        return redirect()->to('admin/lapangan')->with('success', 'data berhasil ditambahkan');
        // return view('admin/tlapangan', $data);
    }

    public function edit($id = null)
    {
        if ($id != null) {
            $query = $this->lapgn->getWhere(['kdLap' => $id]);
            if ($query->resultID->num_rows > 0) {
                $data['title'] = 'Edit';
                $data['lapangan'] = $query->getRow();
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // $data = [
        //     'title' => 'From Edit Lapangan',
        //     'lapangan' => $this->lapanganModel->getlapangan($id)
        // ];
        return view('/admin/edit', $data);
    }
    public function update($id)
    {
        $validate = $this->validate([
            'noLap' => [
                'rules' => 'required[lapangan.noLap]',
                'errors' => [
                    'required' => ' No lapangan harus di isi.',
                ],
            ],
            'gambarLap' => [
                'rules' => 'required[lapangan.gambarLap]',
                'errors' => [
                    'required' => ' gambar lapangan harus di isi.',
                ],
            ],
            'deskripsi' => [
                'rules' => 'required|min_length[10]',
                'errors' => [
                    'required' => ' deskripsi harus di isi.',
                    'min_length' => ' deskripsi min 10 karakter'
                ]
            ]
        ]);
        if (!$validate) {

            return redirect()->back()->withInput();
        }
        // $data = $this->request->getPost();
        // unset($data['_method']);
        $data = [
            'noLap' => $this->request->getVar('noLap'),
            'gambarLap'  => $this->request->getVar('gambarLap'),
            'deskripsi'  => $this->request->getVar('deskripsi'),
        ];
        $this->lapgn->where(['kdLap' => $id])->update($data);

        return redirect()->to('admin/lapangan')->with('success', 'data berasil diupdate');
    }

    public function delete($id)
    {
        $this->lapanganModel->delete($id);

        return redirect()->to('/admin/lapangan')->with('success', 'data berhasil dihapus');
    }

    public function jadwal()
    {
        $data = $this->request->getPost();
        $jadwal = $this->jadwalModel->findAll();
        $data['title'] = 'Jadwal';
        $data['jadwal'] = $jadwal;

        return view('admin/jadwal', $data);
    }

    public function tjadwal()
    {

        $data = [
            'title' => 'Tambah-jadwal',
            'validation' => \Config\Services::validation()
        ];


        return view('admin/tjadwal', $data);
    }

    public function savejad()
    {
        //validasi input
        $validate = $this->validate([
            'kdLap' => [
                'rules' => 'required[jadwal.kdLap]',
                'errors' => [
                    'required' => ' No lapangan harus di isi.',
                    //'is_unique' => ' No lapangan sudah terdaftar'
                ],
            ],
            'jamBo' => [
                'rules' => 'required[jadwal.jamBo]',
                'errors' => [
                    'required' => ' jam lapangan harus di isi.',
                    //'is_unique' => ' No lapangan sudah terdaftar'
                ],
            ],
            'harga' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => ' deskripsi harus di isi.',
                    'min_length' => ' deskripsi min 5 karakter'
                ]
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


        $data = [
            'tglJadwal' => $this->request->getVar('tglJadwal'),
            'kdLap' => $this->request->getVar('kdLap'),
            'jamBo'  => $this->request->getVar('jamBo'),
            'harga'  => $this->request->getVar('harga'),
            'statusBoking' => 'R',
        ];

        $this->jadwl->insert($data);
        // Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date')

        // $this->lapanganModel->save([
        //     'noLap' => $this->request->getVar('noLap'),
        //     'gambarLap' => $this->request->getVar('gambarLap'),
        //     'deskripsi' => $this->request->getVar('deskripsi')

        // ]);
        // $data['title'] = 'Tambah-Data';
        return redirect()->to('admin/jadwal')->with('success', 'data berhasil ditambahkan');
        // return view('admin/tlapangan', $data);
    }
    public function editjad($id = 0)
    {
        if ($id != null) {
            $query = $this->jadwl->getWhere(['kdJadwal' => $id]);
            if ($query->resultID->num_rows > 0) {
                $data['title'] = 'Edit jadwal';
                $data['jadwal'] = $query->getRow();
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        // $data = [
        //     'title' => 'From Edit Lapangan',
        //     'lapangan' => $this->lapanganModel->getlapangan($id)
        // ];
        return view('/admin/editjad', $data);
    }

    public function updatejad($id)
    {
        $validate = $this->validate([
            'kdLap' => [
                'rules' => 'required[jadwal.kdLap]',
                'errors' => [
                    'required' => ' No lapangan harus di isi.',
                    //'is_unique' => ' No lapangan sudah terdaftar'
                ],
            ],
            'jamBo' => [
                'rules' => 'required[jadwal.jamBo]',
                'errors' => [
                    'required' => ' jam lapangan harus di isi.',
                    //'is_unique' => ' No lapangan sudah terdaftar'
                ],
            ],
            'harga' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => ' deskripsi harus di isi.',
                    'min_length' => ' deskripsi min 5 karakter'
                ]
            ]
        ]);
        if (!$validate) {

            return redirect()->back()->withInput();
        }
        // $data = $this->request->getPost();
        // unset($data['_method']);
        $data = [
            'tglJadwal' => $this->request->getVar('tglJadwal'),
            'kdLap' => $this->request->getVar('kdLap'),
            'jamBo'  => $this->request->getVar('jamBo'),
            'harga'  => $this->request->getVar('harga'),
        ];
        $this->jadwl->where(['kdJadwal' => $id])->update($data);

        return redirect()->to('admin/jadwal')->with('success', 'data berasil diupdate');
    }

    public function deletejad($id)
    {
        $this->jadwalModel->delete($id);

        return redirect()->to('/admin/jadwal')->with('success', 'data berhasil dihapus');
    }

    public function pesanan()
    {
        // $data = $this->request->getPost();
        // $boking = $this->bokingModel->findAll();
        // $data['title'] = 'Pesanan';
        // $data['boking'] = $boking;

        // return view('admin/pesanan', $data);
        $data['title'] = 'pesanan';

        $this->bokg->select('boking.kdBoking, tglInvoice, atasNama, alamat, kontak, totalBayar, kdStatus');
        $query = $this->bokg->get();

        $data['boking'] = $query->getResult();

        return view('admin/pesanan', $data);
    }


    public function editpsn($id = null)
    {

        $this->bokg->select('boking.kdBoking, tglInvoice, noInvoice, atasNama, alamat, kontak, totalBayar, kdStatus, noLap, jamMulaiBooking, jamSelesaiBooking,username, harga, username ');
        $this->bokg->join('status_boking', 'status_boking.idStatus = boking.kdStatus ');
        $this->bokg->join('lapangan', 'lapangan.kdLap = boking.kdLapangan ');
        $this->bokg->join('users', 'users.id=boking.userId');
        $this->bokg->where('boking.kdBoking', $id);
        //$query = $this->bokg->get();

        //$data['boking'] = $query->getRow();


        if ($id != null) {
            $query = $this->bokg->getWhere(['kdBoking' => $id]);
            if ($query->resultID->num_rows > 0) {
                $data['title'] = 'Edit pesanan';
                $data['boking'] = $query->getRow();
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        return view('admin/editpsn', $data);
    }
    public function updatepsn($id)
    {
        // $validate = $this->validate([
        //     'kdLap' => [
        //         'rules' => 'required[jadwal.kdLap]',
        //         'errors' => [
        //             'required' => ' No lapangan harus di isi.',
        //             //'is_unique' => ' No lapangan sudah terdaftar'
        //         ],
        //     ],
        //     'jamBo' => [
        //         'rules' => 'required[jadwal.jamBo]',
        //         'errors' => [
        //             'required' => ' jam lapangan harus di isi.',
        //             //'is_unique' => ' No lapangan sudah terdaftar'
        //         ],
        //     ],
        //     'harga' => [
        //         'rules' => 'required|min_length[5]',
        //         'errors' => [
        //             'required' => ' deskripsi harus di isi.',
        //             'min_length' => ' deskripsi min 5 karakter'
        //         ]
        //     ]
        // ]);
        // if (!$validate) {

        //     return redirect()->back()->withInput();
        // }
        // $data = $this->request->getPost();
        // unset($data['_method']);
        $data = [
            'kdStatus' => $this->request->getPost('kdStatus'),
        ];
        $this->bokg->where(['kdBoking' => $id])->update($data);

        return redirect()->to('admin/pesanan')->with('success', 'data berhasil diupdate');
    }
    public function deletepsn($id)
    {
        $this->bokingModel->delete($id);

        return redirect()->to('/admin/pesanan')->with('success', 'data berhasil dihapus');
    }
    public function invoiceadmin($id = null)
    {
        $this->bokg->select('boking.kdBoking, tglInvoice, noInvoice, atasNama, alamat, kontak, totalBayar, statusBayar, username, noLap, jamBo, harga, username ');
        $this->bokg->join('jadwal', 'jadwal.kdJadwal = boking.kdJadwal ');
        $this->bokg->join('lapangan', 'lapangan.kdLap = jadwal.kdLap ');
        $this->bokg->join('users', 'users.id=boking.usernameid');
        $this->bokg->where('boking.kdBoking', $id);
        //$query = $this->bokg->get();

        //$data['boking'] = $query->getRow();


        if ($id != null) {
            $query = $this->bokg->getWhere(['kdBoking' => $id]);
            if ($query->resultID->num_rows > 0) {
                $data['title'] = 'Edit pesanan';
                $data['boking'] = $query->getRow();
            } else {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $html = view('admin/invoiceadm', $data);
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
        //Close and output PDF document
        $pdf->Output('invoice.pdf', 'I');
    }
}
