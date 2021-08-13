<?php
	
	class Pengiriman_data_akuntansi extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this->load->library('exportpengiriman');
			
			$this->load->model('M_Pengiriman_akuntansi');
			$this->load->model('M_Permintaan_akuntansi');
			$this->load->model('Jenis_data_model');
			$this->load->model('Klien_model');
		}
		
		public function index() {
			$data['judul']	= "Pengiriman Data Akuntansi";
			$data['masa']	= $this->Klien_model->getMasa();
			$data['klien']	= $this->Klien_model->getAllKlien();
			
			$this->libtemplate->main('admin/pengiriman_akuntansi/tampil', $data);
		}
		
		public function page() {
			$klien = $_POST['klien'];
			$bulan	= $_POST['bulan'];
			$tahun	= $_POST['tahun'];
			$this->session->set_userdata('bulan', $bulan); 
			$this->session->set_userdata('tahun', $tahun);
			$this->session->set_flashdata('klien', $klien);
			
			$limit		= $_POST['length'];
			$offset		= $_POST['start'];
			$klien		= ($klien == null) ? 'all' : $klien;
			$countData	= $this->M_Pengiriman_akuntansi->countPengiriman($bulan, $tahun, $klien); 
			$pengiriman	= $this->M_Pengiriman_akuntansi->getByMasa($bulan, $tahun, $klien, $offset, $limit);
			
			$data = [];
			foreach($pengiriman as $k) {
				$row	= [];
				$row[]	= ++$offset.'.';
				$row[]	= $k['nama_klien'];
				$row[]	= $k['id_permintaan'];
				$row[]	= $k['request'];
				$row[]	= $k['tanggal_permintaan'];
				$row[]	= $k['nama'];
				$row[]	= '
					<a class="btn-detail" data-nilai="'.$k['id_permintaan'].'" data-toggle="tooltip" data-placement="bottom" title="Detail Permintaan">
						<i class="bi bi-info-circle" style="font-size:20px; line-height:80%"></i>
					</a>';
					
				$data[] = $row;
			}
			
			$callback	= [
				'draw'				=> $_POST['draw'], // Ini dari datatablenya
				'recordsTotal'		=> $countData,
				'recordsFiltered'	=>$countData,
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
			$data['link']		= 'admin/pengiriman/pengiriman_data_akuntansi/detail/';
			
			$this->load->view('admin/permintaan_akuntansi/rincian', $data);
		}
		
		public function detail($id_data) {
			$detail		= $this->M_Pengiriman_akuntansi->getByIdData($id_data);
			$pengiriman	= $this->M_Pengiriman_akuntansi->getDetail($id_data);
			
			if($detail['status'] == 'yes') {
				$detail['badge'] = '<span class="badge badge-success">Lengkap</span>';
			} elseif($detail['status'] == 'no') {
				$detail['badge'] = '<span class="badge badge-warning">Belum Lengkap</span>';
			} else {
				$detail['badge'] = '<span class="badge badge-danger">Belum Dikirim</span>';
			}
			
			$button = '';
			if(count($pengiriman) > 0) {
				if($detail['status'] != 'yes') {
					$button = '<a href="#" class="btn btn-primary btn-konfirm" data-id="'.$detail['id_data'].'" data-status="yes" data-toggle="tooltip" data-placement="bottom" title="Konfirmasi kelengkapan data">Konfirmasi</a>';
				} else {
					$button = '<a href="#" class="btn btn-danger btn-konfirm" data-id="'.$detail['id_data'].'" data-status="no" data-toggle="tooltip" data-placement="bottom" title="Batalkan konfirmasi">Batalkan</a>';
				}
			}
			$detail['button']	= $button;
			
			$data['judul']		= "Detail Pengiriman"; 
			$data['detail']		= $detail;
			$data['pengiriman']	= $pengiriman;
			$data['link']		= "asset/uploads/".$detail['nama_klien']."/".$detail['tahun']."/";
			
			$this->libtemplate->main('admin/pengiriman_akuntansi/detail', $data);
		}
		
		public function cetak() {
			$data['bulan']	= $this->input->post('bulan', true);
			$data['tahun']	= $this->input->post('tahun', true);
			$data['klien']	= $this->input->post('klien', true);
			
			$data['filename']	= "Permintaan Data Akuntansi ".$data['bulan']." ".$data['tahun'];
			$data['judul']		= "Permintaan Data Akuntansi";
			$data['klien']		= $this->Klien_model->getAllKlien();
			foreach($data['klien'] as $k) {
				$perklien	= $this->M_Permintaan_akuntansi->getReqByKlien($data['bulan'], $data['tahun'], $k['id_klien']);
				$permintaan[$k['id_klien']] = $perklien;
			}
			$data['permintaan'] = $permintaan;
			
			if($this->input->post('xls', true))
				return $this->exportpengiriman->exportExcel($data);
			elseif($this->input->post('pdf', true))
				return $this->exportpengiriman->exportPdf($data);
		}
	}
?>