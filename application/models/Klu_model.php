<?php
	
	use GuzzleHttp\Client;
	
	class Klu_model extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getAllKlu($start='', $limit='', $cari='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'all',
				'key'		=> $cari,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'klu', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countKlu($cari='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'count',
				'key'		=> $cari,
			];
			$response	= $this->client->request('GET', 'klu', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($kode_klu) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'byId',
				'key'		=> $kode_klu,
			];
			$response	= $this->client->request('GET', 'klu', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function tambahKlu() {
			$get = [
				'REQUEST'		=> Globals::apikey(),
				'kode_klu'		=> $this->input->post('kode_klu', true),
				'bentuk_usaha'	=> $this->input->post('bentuk_usaha', true),
				'jenis_usaha'	=> $this->input->post('jenis_usaha', true),
			];
			$response	= $this->client->request('POST', 'klu', ['form_params' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function ubahKlu() {
			$get = [
				'REQUEST'		=> Globals::apikey(),
				'kode_klu'		=> $this->input->post('kode_klu', true),
				'bentuk_usaha'	=> $this->input->post('bentuk_usaha', true),
				'jenis_usaha'	=> $this->input->post('jenis_usaha', true),
			];
			$response	= $this->client->request('PUT', 'klu', ['form_params' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function hapusKlu($kode_klu) {
			$get = [
				'REQUEST'		=> Globals::apikey(),
				'kode_klu'		=> $kode_klu,
			];
			$response	= $this->client->request('DELETE', 'klu', ['form_params' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
	}
?>