<?php
	
	use GuzzleHttp\Client;
	
	class Akuntan_model extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getAllAkuntan($start=0, $limit='', $cari='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'all',
				'key'		=> $cari,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'akuntan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countAkuntan($cari='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'count',
				'key'		=> $cari,
			];
			$response	= $this->client->request('GET', 'akuntan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			$result		= ($result['data'] > 0) ? $result['data'] : 0;
			return $result;
		}
	
		public function getBy($type, $id_user) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> $type,
				'key'		=> $id_user,
			];
			$response	= $this->client->request('GET', 'akuntan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function tambahAkuntan() {
			$row = [
				'REQUEST'	=> APIKEY,
				'level'		=> $this->input->post('level'),
				'username'	=> $this->input->post('username'),
				'password'	=> $this->input->post('password'),
				'nama'		=> $this->input->post('nama'),
				'email'		=> $this->input->post('email'),
			];
			$response	= $this->client->request('POST', 'akuntan', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result;
		}
		
		public function ubahAkuntan() {
			$tipe = $this->input->post('tipe', true);
			if($tipe == 'nama') {
				$value = $this->input->post('nama', true);
			} elseif($tipe == 'email_user') {
				$value = $this->input->post('email', true);
			} elseif($tipe == 'username') {
				$value = $this->input->post('username', true);
			} else {
				$value = $this->input->post('password', true);
			}
			
			$row = [
				'REQUEST'	=> APIKEY,
				'id_user'	=> $this->input->post('id_user'),
				'type'		=> $tipe,
				'value'		=> $value,
			];
			$response	= $this->client->request('PUT', 'akuntan', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result;
		}
		
		public function hapusAkuntan($id_user) {
			$row = [
				'REQUEST'	=> APIKEY,
				'id_user'	=> $id_user,
			];
			$response	= $this->client->request('DELETE', 'akuntan', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result;
		}
	}
?>