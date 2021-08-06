<?php
	
	class Permintaan_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		
		public function index() {
			$data['judul']	= "Permintaan Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();
			$this->libtemplate->main('klien/permintaan_akuntansi/tampil', $data);
		}
		
		public function page() {
			$tahun	= $_POST['tahun'];
			$bulan	= $_POST['bulan'];
			$klien	= $this->session->userdata('id_user');
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Permintaan_akuntansi->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($permintaan as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['id_permintaan'];
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $k['nama'];
				$row[]	= '
					<a class="btn-detail_permintaan" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Detail">
						<i class="bi bi-info-circle-fill" style="font-size:20px; line-height:80%"></i>
					</a>';
				
				$data[] = $row;
			}
			$callback = [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=> $countData,
				'data'				=> $data,
			];
			echo json_encode($callback);
		}
		
		public function pageChild() {
			$id_permintaan	= $_GET['id'];
			$permintaan		= $this->M_Permintaan_akuntansi->getById($id_permintaan);
			$isi			= $this->M_Permintaan_akuntansi->getDetail($id_permintaan);
			
			foreach($isi as $i => $val) {
				if($val['status'] == 'yes') {
					$badge	= '<span class="badge badge-success">Lengkap</span>';
				} elseif($val['status'] == 'no') {
					$badge	= '<span class="badge badge-warning">Belum Lengkap</span>';
				} else {
					$badge	= '<span class="badge badge-danger">Belum Dikirim</span>';
				}
				$add[$i] = $badge;
			}
			$data['judul']		= 'Detail Permintaan';
			$data['permintaan']	= $permintaan;
			$data['isi']		= $isi;
			$data['badge']		= $add;
			
			$this->load->view('klien/permintaan_akuntansi/rincian', $data);
		}
		
		public function detail($id_data) {
			$detail = $this->M_Pengiriman_akuntansi->getByIdData($id_data);
			if($detail['status'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $this->M_Pengiriman_akuntansi->getDetail($id_data);
			$data['back']		= 'klien/permintaan_data_akuntansi';
			
			$this->form_validation->set_rules('id_data', 'ID Data', 'required');
			if($detail['format_data'] == 'Hardcopy') {
				$this->form_validation->set_rules('tanggal_ambil', 'Tanggal Ambil', 'required');
			}
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_akuntansi/detail', $data);
			} else {
				$send = $this->M_Pengiriman_akuntansi->kirim();
				if($send == 'ERROR') {
					$msg = 'Format file yang di izinkan : <b>.xls, .xlsx, .csv, .pdf, .rar, .zip</b>';
					$this->session->set_flashdata('flash', $msg);
				} elseif($send == 'OK') {
					$this->session->set_flashdata('notification', 'Data berhasil dikirim!');
				}
				redirect('klien/permintaan_data_akuntansi/detail/'.$id_data);
			}
		}
		
		public function detail_data() {
			$id_data	= $_GET['id'];
			$detail		= $this->M_Pengiriman_akuntansi->getByIdData($id_data);
			if($detail['status'] == 'yes') {
				$detail['ket_status'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status'] == 'no') {
				$detail['ket_status'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['ket_status'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $this->M_Pengiriman_akuntansi->getDetail($id_data);
			$data['back']		= 'klien/permintaan_data_akuntansi';
			
			$this->load->view('klien/permintaan_akuntansi/detail_data', $data);
		}
	}
?>