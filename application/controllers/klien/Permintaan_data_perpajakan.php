<?php
	
	class Permintaan_data_perpajakan extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('form_validation');
			
			$this->load->model('M_Permintaan_perpajakan');
			$this->load->model('M_Pengiriman_perpajakan');
			$this->load->model('Klien_model');
			$this->load->model('Jenis_data_model');
		} 
		
		public function index() {
			$data['judul']	= "Permintaan Data Perpajakan";
			$data['masa']	= $this->Klien_model->getMasa();
			$this->libtemplate->main('klien/permintaan_perpajakan/tampil', $data);
		}
		
		public function page() {
			$tahun	= $_POST['tahun'];
			$bulan	= $_POST['bulan'];
			$klien	= $this->session->userdata('id_user');
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$countData	= $this->M_Permintaan_perpajakan->countPermintaan($bulan, $tahun, $klien); 
			$permintaan	= $this->M_Permintaan_perpajakan->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
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
			$permintaan		= $this->M_Permintaan_perpajakan->getById($id_permintaan);
			$isi			= $this->M_Permintaan_perpajakan->getDetail($id_permintaan);
			
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
			$data['link']		= 'klien/permintaan_data_akuntansi/detail/';
			
			$this->load->view('klien/permintaan_perpajakan/rincian', $data);
		}
		
		public function detail($id_data) {
			$detail = $this->M_Pengiriman_perpajakan->getByIdData($id_data);
			if($detail['status'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $this->M_Pengiriman_perpajakan->getDetail($id_data);
			$data['back']		= 'klien/permintaan_data_perpajakan';
			
			$this->form_validation->set_rules('id_data', 'ID Data', 'required');
			if($detail['format_data'] == 'Hardcopy') {
				$this->form_validation->set_rules('tanggal_ambil', 'Tanggal Ambil', 'required');
			}
			
			if($this->form_validation->run() == FALSE) {
				$this->libtemplate->main('klien/permintaan_perpajakan/detail', $data);
			} else {
				$send = $this->M_Pengiriman_perpajakan->kirim();
				if($send == 'ERROR') {
					$this->session->set_flashdata('flash', 'Format file tidak sesuai!');
				} elseif($send == 'OK') {
					$this->session->set_flashdata('notification', 'Data berhasil dikirim!');
				}
				redirect('klien/permintaan_data_perpajakan/detail/'.$id_data);
			}
		}
	}
?>