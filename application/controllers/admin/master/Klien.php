<?php
	
	class Klien extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('Klien_model');
			$this->load->model('Klu_model');
			$this->load->model('Otoritas_model');
		} 
		 
		public function index() {
			$data['judul'] = "Data Klien"; 
			$data['klien_modal'] = $this->Klien_model->getAllKlien(); 
			
			$this->libtemplate->main('admin/klien/tampil', $data);
		}
		
		public function page() {
			$cari	= $_POST['search']['value'];
			$limit	= $_POST['length'];
			$offset = $_POST['start'];
			
			$countData	= $this->Klien_model->countKlien($cari); 
			$klien		= $this->Klien_model->getAllKlien($offset, $limit, $cari);
			
			$data		= [];
			foreach($klien as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['status_pekerjaan'];
				$row[]	= $k['jenis_usaha'];
				$row[]	= $k['nama_pimpinan'];
				$row[]	= '
						<a class="btn btn-sm btn-primary btn-detail" data-nilai="'.$k['id_klien'].'" data-toggle="tooltip" data-placement="bottom" title="Lihat Detail">
							<i class="bi bi-info-circle"></i>
						</a>
						<a href="klien/view/'.$k['id_klien'].'" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="bottom" title="Ubah">
							<i class="bi bi-pencil-square"></i>
						</a>
						<a class="btn btn-sm btn-danger btn-hapus" data-id="'.$k['id_klien'].'" data-nama="'.$k['nama_klien'].'" data-toggle="tooltip" data-placement="bottom" title="Hapus Klien">
							<i class="bi bi-trash"></i>
						</a>';

				$data[] = $row;
			}
			$callback	= [
				'draw'			=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'	=> $countData,
				'recordsFiltered'=>$countData,
				'data'			=> $data,
			];
			echo json_encode($callback);
		}

		public function tambah() {
			$data['judul']				= 'Tambah Data Klien'; 
			$data['klu']				= $this->Klu_model->getAllKlu(); 
			$data['status_pekerjaan']	= ['Accounting Service', 'Review', 'Semi Review'];
			$data['level']				= "klien";
			
			$this->form_validation->set_rules('nama_klien', 'Nama Klien', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]|max_length[15]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
			$this->form_validation->set_rules('passconf', 'Password', 'required|matches[password]');

			$this->form_validation->set_rules('status_pekerjaan', 'Status Pekerjaan', 'required');
			$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required');
			$this->form_validation->set_rules('alamat', 'Alamat', 'required');
			$this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|numeric');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('no_hp', 'No. HP', 'numeric');
			$this->form_validation->set_rules('no_akte', 'No. Akte', 'numeric');

			$this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
			$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
			$this->form_validation->set_rules('no_hp_pimpinan', 'No. HP', 'required|numeric');
			$this->form_validation->set_rules('email_pimpinan', 'Email', 'valid_email');

			$this->form_validation->set_rules('no_hp_counterpart', 'No. HP', 'numeric');
			$this->form_validation->set_rules('email_counterpart', 'Email', 'valid_email');

			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/klien/tambah', $data);
			} else {
				$this->Klien_model->tambahKlien();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/master/klien'); 
			}
		}
		
		public function pilih_klu() {
			$kode_klu	= $this->input->post('action', true);
			$klien		= $this->Klu_model->getById($kode_klu);
			
			$data = array(
				'bentuk_usaha' => $klien['bentuk_usaha'],
				'jenis_usaha' => $klien['jenis_usaha'],
			);
			echo json_encode($data);
		}
		
		public function profil() {
			$data['judul'] = 'Detail Klien';
			$data['klien'] = $this->Klien_model->getById($this->input->post('action', true));
			
			$this->load->view('admin/klien/detail', $data);
		}
		
		public function view($id_user) {
			$user		= $this->Klien_model->getById($id_user);
			$passcode	= '';
			for($i=0; $i<$user['passlength']; $i++) {
				$passcode .= '&bull;';
			}
			$user['passcode'] = $passcode;
			
			$data['judul']	= "Profile Klien";
			$data['user']	= $user;
			
			$this->libtemplate->main('admin/klien/view', $data);
		}
		
		public function verification() {
			$data['judul']		= 'Verifikasi';
			$data['subjudul']	= 'Beritahu kami bahwa ini benar Anda';
			$data['tipe']		= $this->input->post('type', true);
			$data['id_user']	= $this->input->post('id', true);
			$this->session->set_userdata('tipe', $data['tipe']);
			
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->load->view('admin/klien/verif', $data);
			} else {
				$cek	= $this->Otoritas_model->getById($this->session->userdata('id_user'));
				$verify	= password_verify($this->input->post('password', true), $cek['password']);
				
				if($verify == true) {
					redirect('admin/master/klien/ubah/'.$_POST['id_user']);
				} else {
					$this->session->set_flashdata('pass', 'Password salah!');
					redirect('admin/master/klien/view/'.$_POST['id_user']);
				}
			}
		}
		
		public function ubah($id_user) {
			$type			= $this->session->userdata('tipe');
			$data['klien']	= $this->Klien_model->getById($id_user);
			$data['klu']	= $this->Klu_model->getAllKlu(); 
			$data['status']	= ['Accounting Service', 'Review', 'Semi Review'];
			$data['judul']	= $data['klien']['nama'].' - Ubah '.ucwords($type);
			
			if($type == 'nama') {
				$this->form_validation->set_rules('nama', 'Nama', 'required');
			} elseif($type == 'email') {
				$this->form_validation->set_rules('email', 'Email', 'required|is_unique[user.email_user]|valid_email');
			} elseif($type == 'username') {
				$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|min_length[8]');
			} elseif($type == 'password') {
				$this->form_validation->set_rules('password', 'Password', 'min_length[8]|max_length[15]');
				$this->form_validation->set_rules('passconf', 'Password', 'matches[password]');
			} elseif($type == 'usaha') {
				$this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required');
				$this->form_validation->set_rules('kode_klu', 'Kode KLU', 'required');
				$this->form_validation->set_rules('alamat', 'Alamat', 'required');
				$this->form_validation->set_rules('telp', 'Nomor Telepon', 'required|numeric');
				$this->form_validation->set_rules('no_hp', 'No. HP', 'numeric');
				$this->form_validation->set_rules('no_akte', 'No. Akte', 'numeric');
				$this->form_validation->set_rules('status_pekerjaan', 'Status Pekerjaan', 'required');
			} elseif($type == 'pimpinan') {
				$this->form_validation->set_rules('nama_pimpinan', 'Nama Pimpinan', 'required');
				$this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
				$this->form_validation->set_rules('no_hp_pimpinan', 'No. HP', 'required|numeric');
				$this->form_validation->set_rules('email_pimpinan', 'Email', 'valid_email');
			} elseif($type == 'counterpart') {
				$this->form_validation->set_rules('no_hp_counterpart', 'No. HP', 'numeric');
				$this->form_validation->set_rules('email_counterpart', 'Email', 'valid_email');
			}
			
			if($this->form_validation->run() == FALSE) {
				$tipe = $this->session->userdata('tipe');
				$this->libtemplate->main('klien/profile/ganti_'.$tipe, $data);
			} else {
				$tipe = $this->session->userdata('tipe');
				$this->Klien_model->ubahKlien();
				$this->session->set_flashdata('notification', ucwords($tipe).' berhasil diubah!');
				redirect('admin/master/klien/view/'.$_POST['id_user']);
			}
		}
		
		public function hapus() {
			$this->Klien_model->hapusDataKlien($_POST['id']);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/master/klien');
		}
	}
?>