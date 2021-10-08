<?php
	
	use GuzzleHttp\Client;
	
	class Admin_model extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getAllAdmin($start=0, $limit='', $cari='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'all',
				'key'		=> $cari,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countAdmin($cari='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'count',
				'key'		=> $cari,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($id_user) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'byId',
				'key'		=> $id_user,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getByUsername($username) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'byUsername',
				'key'		=> $username,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getByEmail($email) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'byEmail',
				'key'		=> $email,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function tambahAdmin() {
			$row = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'data',
				'level'		=> $this->input->post('level'),
				'username'	=> $this->input->post('username'),
				'password'	=> $this->input->post('password'),
				'nama'		=> $this->input->post('nama'),
				'email'		=> $this->input->post('email'),
			];
			$response	= $this->client->request('POST', 'admin', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function ubahAdmin() {
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
				'id_user'	=> $this->input->post('id_user'),
				'type'		=> $tipe,
				'value'		=> $value,
			];
			$response	= $this->client->request('PUT', 'admin', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function updatePassword($password, $id_user) {
			$row = [
				'REQUEST'	=> Globals::apikey(),
				'id_user'	=> $id_user,
				'type'		=> 'password',
				'value'		=> $password,
			];
			$response	= $this->client->request('PUT', 'admin', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function hapusAdmin($id_user) {
			$row = [
				'REQUEST'	=> Globals::apikey(),
				'id_user'	=> $id_user,
			];
			$response	= $this->client->request('DELETE', 'admin', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function insertToken($id_user) {
			$row = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'token',
				'id_user'	=> $id_user,
			];
			$response	= $this->client->request('POST', 'admin', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function validToken($token) {
			$data = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'token',
				'key'		=> $token,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $data]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
	}
?>