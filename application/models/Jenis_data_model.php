<?php
	
	use GuzzleHttp\Client;
	
	class Jenis_data_model extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getAllJenis($start=0, $limit='', $cari='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'all',
				'key'		=> $cari,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'jenis_data', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}

		public function countJenis($cari='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'count',
				'key'		=> $cari,
			];
			$response	= $this->client->request('GET', 'jenis_data', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($kode_jenis) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'byId',
				'key'		=> $kode_jenis,
			];
			$response	= $this->client->request('GET', 'jenis_data', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getByKategori($kategori) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'byKategori',
				'key'		=> $kategori,
			];
			$response	= $this->client->request('GET', 'jenis_data', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function kategori() {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'kategori',
			];
			$response	= $this->client->request('GET', 'jenis_data', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function tambahJenis() {
			$row = [
				'REQUEST'		=> APIKEY,
				'jenis_data'	=> $this->input->post('jenis_data', true),
				'kategori'		=> $this->input->post('kategori', true),
			];
			$response	= $this->client->request('POST', 'jenis_data', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function ubahJenis() {
			$row = [
				'REQUEST'		=> APIKEY,
				'kode_jenis'	=> $this->input->post('kode_jenis', true),
				'jenis_data'	=> $this->input->post('jenis_data', true),
				'kategori'		=> $this->input->post('kategori', true),
			];
			$response	= $this->client->request('PUT', 'jenis_data', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function hapusJenis($kode_jenis) {
			$row = [
				'REQUEST'		=> APIKEY,
				'kode_jenis'	=> $kode_jenis,
			];
			$response	= $this->client->request('DELETE', 'jenis_data', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
	}
?>