<?php
	
	use GuzzleHttp\Client;
	
	class M_Permintaan_akuntansi extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getByMasa($bulan, $tahun, $klien='', $start=0, $limit='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'all',
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'permintaan_data_akuntansi', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countPermintaan($bulan, $tahun, $klien='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'countAll',
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
			];
			$response	= $this->client->request('GET', 'permintaan_data_akuntansi', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($id_permintaan) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'byId',
				'key'		=> $id_permintaan,
			];
			$response	= $this->client->request('GET', 'permintaan_data_akuntansi', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getDetail($id_permintaan) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'detail',
				'key'		=> $id_permintaan,
			];
			$response	= $this->client->request('GET', 'permintaan_data_akuntansi', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countDetail($id_permintaan) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'countDetail',
				'key'		=> $id_permintaan,
			];
			$response	= $this->client->request('GET', 'permintaan_data_akuntansi', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getUnsend($id_klien) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'unsend',
				'key'		=> $id_klien,
			];
			$response	= $this->client->request('GET', 'permintaan_data_akuntansi', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function tambahPermintaan() {
			$kode_jenis		= $this->input->post('kode_jenis', true);
			$detail			= $this->input->post('detail', true);
			$format_data	= $this->input->post('format_data', true);
			
			// insert permintaan
			$data['permintaan'] = [
				'tanggal_permintaan'=> date('d-m-Y H:i'),
				'id_klien'			=> $this->input->post('id_klien', true),
				'bulan'				=> date('m'),
				'tahun'				=> date('Y'),
				'id_pengirim'		=> $this->input->post('id_user', true),
			];
			
			// insert data
			$row = [];
			for($i=0; $i<count($kode_jenis); $i++) {
				$row[] = [
					'id_jenis'		=> $kode_jenis[$i],
					'detail'		=> $detail[$i],
					'format_data'	=> $format_data[$i],
				];
			}
			$data['detail']		= $row;
			$data['REQUEST']	= Globals::apikey();
			
			$response	= $this->client->request('POST', 'permintaan_data_akuntansi', ['form_params' => $data]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function ubahPermintaan() {
			$id_permintaan	= $this->input->post('id_permintaan', true);
			$id_data		= $this->input->post('id_data', true);
			$detail			= $this->input->post('detail', true);
			$format_data	= $this->input->post('format_data', true);
			
			for($i=0; $i<count($id_data); $i++) {
				// jika format_data ada lakukan update, jika tidak hapus data
				if(isset($format_data[$i])) {
					$row = [
						'REQUEST'		=> Globals::apikey(),
						'type'			=> 'permintaan',
						'id_data'		=> $id_data[$i],
						'detail'		=> $detail[$i],
						'format_data'	=> $format_data[$i],
					];
					$response	= $this->client->request('PUT', 'permintaan_data_akuntansi', ['form_params' => $row]);
					$result		= json_decode($response->getBody()->getContents(), true);
					// return $result['status'];
				} else {
					$row = [
						'REQUEST'	=> Globals::apikey(),
						'id'		=> $id_data[$i],
						'type'		=> 'data',
					];
					$response	= $this->client->request('DELETE', 'permintaan_data_akuntansi', ['form_params' => $row]);
					$result		= json_decode($response->getBody()->getContents(), true);
					// return $result['status'];
				}
			}
		}
		
		public function emailSent($id_data) {
			$row = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'emailSent',
				'id_data'	=> $id_data,
			];
			$response	= $this->client->request('PUT', 'permintaan_data_akuntansi', ['form_params' => $row]);
			// $result		= json_decode($response->getBody()->getContents(), true);
			// return $result['status'];
		}
		
		public function hapusPermintaan($id_permintaan) {
			$row = [
				'REQUEST'	=> Globals::apikey(),
				'id'		=> $id_permintaan,
				'type'		=> 'permintaan',
			];
			$response	= $this->client->request('DELETE', 'permintaan_data_akuntansi', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
	}
?>