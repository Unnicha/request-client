<?php
	
	use GuzzleHttp\Client;
	
	class M_Proses_perpajakan extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getByMasa($status, $bulan, $tahun, $klien='', $start=0, $limit='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'all',
				'status'	=> $status,
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'proses_data_perpajakan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countProses($status, $bulan, $tahun, $klien='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'count',
				'status'	=> $status,
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
			];
			$response	= $this->client->request('GET', 'proses_data_perpajakan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($id_proses) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'byId',
				'key'		=> $id_proses,
			];
			$response	= $this->client->request('GET', 'proses_data_perpajakan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getDetail($id_data) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'detail',
				'key'		=> $id_data,
			];
			$response	= $this->client->request('GET', 'proses_data_perpajakan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function simpanProses() {
			$mulai		= $this->input->post('tanggal_mulai', true).' '.$this->input->post('jam_mulai', true);
			$selesai	= $this->input->post('tanggal_selesai', true).' '.$this->input->post('jam_selesai', true);
			
			$row = [
				'REQUEST'			=> APIKEY,
				'tanggal_mulai'		=> $mulai,
				'tanggal_selesai'	=> (trim($selesai) == '') ? NULL : $selesai,
				'keterangan'		=> $this->input->post('keterangan', true),
				'kode_data'			=> $this->input->post('id_data', true),
				'id_akuntan'		=> $this->input->post('id_user', true),
			];
			$response	= $this->client->request('POST', 'proses_data_perpajakan', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function ubahProses() {
			$selesai	= $this->input->post('tanggal_selesai', true).' '.$this->input->post('jam_selesai', true);
			
			$row = [
				'REQUEST'			=> APIKEY,
				'type'				=> 'selesai',
				'id_proses'			=> $this->input->post('id_proses', true),
				'tanggal_selesai'	=> (trim($selesai) == '') ? NULL : $selesai,
				'keterangan'		=> $this->input->post('keterangan', true),
				'kode_data'			=> $this->input->post('id_data', true),
			];
			$response	= $this->client->request('PUT', 'proses_data_perpajakan', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function batalProses( $id_data ) {
			$row = [
				'REQUEST'			=> APIKEY,
				'type'				=> 'batal',
				'kode_data'			=> $id_data,
			];
			$response	= $this->client->request('PUT', 'proses_data_perpajakan', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
	}
?>