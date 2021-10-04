<?php
	
	use GuzzleHttp\Client;
	
	class Tugas_model extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getAllTugas($start=0, $limit='', $cari='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'all',
				'key'		=> $cari,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'tugas', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countTugas($cari='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'count',
				'key'		=> $cari,
			];
			$response	= $this->client->request('GET', 'tugas', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($kode_tugas) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'byId',
				'key'		=> $kode_tugas,
			];
			$response	= $this->client->request('GET', 'tugas', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function tambahTugas() {
			$durasi	= [];
			$hari	= $this->input->post('hari', true);
			$jam	= $this->input->post('jam', true);
			for($i=0; $i<count($hari); $i++) {
				$durasi[] = ($hari[$i] * 8) + $jam[$i];
			}
			
			$row = [
				'REQUEST'			=> APIKEY,
				'nama_tugas'		=> $this->input->post('nama_tugas', true),
				'accounting_service'=> $durasi[0],
				'review'			=> $durasi[1],
				'semi_review'		=> $durasi[2],
				'id_jenis'			=> $this->input->post('kode_jenis', true),
			];
			$response	= $this->client->request('POST', 'tugas', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function ubahTugas() {
			$durasi	= [];
			$hari	= $this->input->post('hari', true);
			$jam	= $this->input->post('jam', true);
			for($i=0; $i<count($hari); $i++) {
				$durasi[] = ($hari[$i] * 8) + $jam[$i];
			}
			
			$row = [
				'REQUEST'			=> APIKEY,
				'kode_tugas'		=> $this->input->post('kode_tugas', true),
				'nama_tugas'		=> $this->input->post('nama_tugas', true),
				'accounting_service'=> $durasi[0],
				'review'			=> $durasi[1],
				'semi_review'		=> $durasi[2],
				'id_jenis'			=> $this->input->post('kode_jenis', true),
			];
			$response	= $this->client->request('PUT', 'tugas', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function hapusTugas($kode_tugas) {
			$row = [
				'REQUEST'		=> APIKEY,
				'kode_tugas'	=> $kode_tugas,
			];
			$response	= $this->client->request('DELETE', 'tugas', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
	}
?>