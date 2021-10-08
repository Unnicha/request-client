<?php
	
	use GuzzleHttp\Client;
	
	class Klien_model extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getAllKlien($start=0, $limit='', $cari='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'all',
				'key'		=> $cari,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'klien', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countKlien($cari='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'count',
				'key'		=> $cari,
			];
			$response	= $this->client->request('GET', 'klien', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($id_klien) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'byId',
				'key'		=> $id_klien,
			];
			$response	= $this->client->request('GET', 'klien', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getMasa($masa='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'masa',
				'key'		=> $masa,
			];
			$response	= $this->client->request('GET', 'klien', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function cekUnique($table, $field, $value) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> $field,
				'key'		=> $value,
				'etc'		=> $table,
			];
			$response	= $this->client->request('GET', 'klien', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function tambahKlien() {
			$row = [
				'REQUEST'		=> Globals::apikey(),
				// info user
				'level'			=> $this->input->post('level', true),
				'username'		=> $this->input->post('username', true),
				'password'		=> $this->input->post('password', true),
				'nama'			=> $this->input->post('nama_klien', true),
				'email_user'	=> $this->input->post('email', true),
				// info usaha
				'nama_usaha'		=> $this->input->post('nama_usaha', true),
				'kode_klu'			=> $this->input->post('kode_klu', true),
				'no_akte'			=> $this->input->post('no_akte', true),
				'alamat'			=> $this->input->post('alamat', true),
				'telp'				=> $this->input->post('telp', true),
				'no_hp'				=> $this->input->post('no_hp', true),
				'status_pekerjaan'	=> $this->input->post('status_pekerjaan', true),
				// info pimpinan
				'nama_pimpinan'		=> $this->input->post('nama_pimpinan', true),
				'jabatan'			=> $this->input->post('jabatan', true),
				'no_hp_pimpinan'	=> $this->input->post('no_hp_pimpinan', true),
				'email_pimpinan'	=> $this->input->post('email_pimpinan', true),
				// info counterpart
				'nama_counterpart'	=> $this->input->post('nama_counterpart', true),
				'no_hp_counterpart'	=> $this->input->post('no_hp_counterpart', true),
				'email_counterpart'	=> $this->input->post('email_counterpart', true),
			];
			$response	= $this->client->request('POST', 'klien', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function ubahAkun() {
			$tipe = $this->input->post('tipe', true);
			if($tipe == 'nama') {
				$value = $this->input->post('nama', true);
			} elseif($tipe == 'email') {
				$value = $this->input->post('email', true);
			} elseif($tipe == 'username') {
				$value = $this->input->post('username', true);
			} else {
				$value = $this->input->post('password', true);
			}
			
			$row = [
				'REQUEST'	=> Globals::apikey(),
				'id_user'	=> $this->input->post('id_klien'),
				'table'		=> $this->input->post('table'),
				'type'		=> $tipe,
				'value'		=> $value,
			];
			$response	= $this->client->request('PUT', 'klien', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function ubahProfil() {
			$tipe = $this->input->post('tipe', true);
			if($tipe == 'usaha') {
				$row = [
					'nama_usaha'		=> $this->input->post('nama_usaha', true),
					'kode_klu'			=> $this->input->post('kode_klu', true),
					'alamat'			=> $this->input->post('alamat', true),
					'telp'				=> $this->input->post('telp', true),
					'no_hp'				=> $this->input->post('no_hp', true),
					'email'				=> $this->input->post('email', true),
					'no_akte'			=> $this->input->post('no_akte', true),
					'status_pekerjaan'	=> $this->input->post('status_pekerjaan', true),
				];
			} elseif($tipe == 'pimpinan') {
				$row = [
					'nama_pimpinan'		=> $this->input->post('nama_pimpinan', true),
					'jabatan'			=> $this->input->post('jabatan', true),
					'no_hp_pimpinan'	=> $this->input->post('no_hp_pimpinan', true),
					'email_pimpinan'	=> $this->input->post('email_pimpinan', true),
				];
			} elseif($tipe == 'counterpart') {
				$row = [
					'nama_counterpart'	=> $this->input->post('nama_counterpart', true),
					'no_hp_counterpart'	=> $this->input->post('no_hp_counterpart', true),
					'email_counterpart'	=> $this->input->post('email_counterpart', true),
				];
			}
			$row['REQUEST']	= Globals::apikey();
			$row['type']	= $tipe;
			$row['id_user']	= $this->input->post('id_klien');
			$row['table']	= $this->input->post('table');
			
			$response	= $this->client->request('PUT', 'klien', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function hapusKlien($id_klien) {
			$row = [
				'REQUEST'	=> Globals::apikey(),
				'id_klien'	=> $id_klien,
			];
			$response	= $this->client->request('DELETE', 'klien', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result;
		}
	}
?>