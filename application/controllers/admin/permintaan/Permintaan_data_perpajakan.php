<?php
	
	class Permintaan_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_perpajakan');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		 
		public function index() {
			$data['judul']	= "Permintaan Data Perpajakan";
			$data['masa']	= $this->Klien_model->getMasa();
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('admin/permintaan_perpajakan/tampil', $data);
		}
		
		public function page() {
			$klien	= $_POST['klien'];
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$this->session->set_flashdata('klien', $klien);
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			if($klien == null) 
				{ $klien = 'all'; }
			$countData	= $this->M_Permintaan_perpajakan->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_perpajakan->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data		= [];
			foreach($permintaan as $k) {
				$status = '<i class="bi bi-hourglass-split icon-status" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Belum Diterima"></i>';

				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= (int) $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $status;
				$row[]	= '
					<a class="btn btn-sm btn-primary btn-detail_permintaan" data-toggle="tooltip" data-nilai="'.$k['id_permintaan'].'" data-placement="bottom" title="Detail Permintaan">
						<i class="bi bi-info-circle"></i>
					</a>

					<a href="permintaan_data_perpajakan/hapus/'.$k['id_permintaan'].'" class="btn btn-sm btn-danger " onclick="return confirm("Yakin ingin menghapus permintaan ke '.$k['request'].' untuk '.$k['nama_klien'].'?");" data-toggle="tooltip" data-placement="bottom" title="Hapus">
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
			$data['judul']	= "Form Tambah Permintaan";
			$data['klien']	= $this->Klien_model->getAllKlien();
			$data['jenis']	= $this->Jenis_data_model->getByKategori('Data Perpajakan');
			$bulan			= $this->Klien_model->getMasa(date('m'));
			$data['bulan']	= $bulan['nama_bulan'];
			
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('kode_jenis[]', 'Jenis Data', 'required');
			$this->form_validation->set_rules('format_data[]', 'Format Data', 'required');
			$this->form_validation->set_rules('detail[]', 'Keterangan', 'required');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/permintaan_perpajakan/tambah', $data);
			} else {
				$this->M_Permintaan_perpajakan->tambahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil ditambahkan!'); 
				redirect('admin/permintaan/permintaan_data_perpajakan'); 
			}
		}
		
		//delete soon
		public function ubah($id_permintaan) {
			$data['judul']		= "Form Ubah Permintaan"; 
			$data['masa']		= $this->Klien_model->getMasa();
			$data['klien']		= $this->Klien_model->getAllKlien();
			$data['jenis']		= $this->Jenis_data_model->getAllJenisData();
			$data['permintaan']	= $this->M_Permintaan_perpajakan->getById($id_permintaan);
			
			$this->form_validation->set_rules('id_klien', 'Klien', 'required');
			$this->form_validation->set_rules('kode_jenis', 'Jenis Data', 'required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', '');
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('admin/permintaan_perpajakan/ubah', $data);
			} else {
				$this->M_Permintaan_perpajakan->ubahPermintaan();
				$this->session->set_flashdata('notification', 'Data berhasil diubah!'); 
				redirect('admin/permintaan/permintaan_data_perpajakan'); 
			}
		}

		public function detail() {
			$id_permintaan	= $this->input->post('permintaan', true);
			$permintaan		= $this->M_Permintaan_perpajakan->getById($id_permintaan);
			$bulan			= $this->Klien_model->getMasa($permintaan['bulan']);
			$kode_jenis		= explode('|', $permintaan['kode_jenis']);
			foreach($kode_jenis as $kode) {
				$jenis_data[] = $this->Jenis_data_model->getById($kode);
			}
			
			$data['judul']			= 'Detail Permintaan';
			$data['permintaan']		= $permintaan;
			$data['bulan']			= $bulan['nama_bulan'];
			$data['jenis_data']		= $jenis_data;
			$data['format_data']	= explode('|', $permintaan['format_data']);
			$data['detail']			= explode('|', $permintaan['detail']);
			$data['jum_data']		= count($data['jenis_data']);
			
			$this->load->view('admin/permintaan_perpajakan/detail', $data);
		}
		
		public function hapus($id_permintaan) {
			$this->M_Permintaan_perpajakan->hapusPermintaan($id_permintaan);
			$this->session->set_flashdata('notification', 'Data berhasil dihapus!');
			redirect('admin/permintaan/permintaan_data_perpajakan');
		}
	}
?>