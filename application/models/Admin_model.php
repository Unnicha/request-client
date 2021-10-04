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
				'REQUEST'	=> APIKEY,
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
				'REQUEST'	=> APIKEY,
				'type'		=> 'count',
				'key'		=> $cari,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($id_user) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'byId',
				'key'		=> $id_user,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getByUsername($username) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'byUsername',
				'key'		=> $username,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getByEmail($email) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'byEmail',
				'key'		=> $email,
			];
			$response	= $this->client->request('GET', 'admin', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function tambahAdmin() {
			$row = [
				'REQUEST'	=> APIKEY,
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
				'REQUEST'	=> APIKEY,
				'id_user'	=> $this->input->post('id_user'),
				'type'		=> $tipe,
				'value'		=> $value,
			];
			$response	= $this->client->request('PUT', 'admin', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		public function hapusAdmin($id_user) {
			$row = [
				'REQUEST'	=> APIKEY,
				'id_user'	=> $id_user,
			];
			$response	= $this->client->request('DELETE', 'admin', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['status'];
		}
		
		// delsoon
		public function ubahPassword($password, $id_user) {
			$this->db->set('password', password_hash($password, PASSWORD_DEFAULT))
					->where('id_user', $id_user)
					->update('user');
		}
		
		public function insertToken($id_user) {
			$token	= substr(sha1(rand()), 0, 30);
			$date	= date('d-m-Y');
			$data	= array(
				'token'		=> $token,
				'id_user'	=> $id_user,
				'date'		=> $date
			);
			$this->db->insert('token', $data);
			
			return $token.$id_user;
		}
		
		public function validToken($token) {
			$tkn		= substr($token, 0, 30);
			$uid		= substr($token, 30);
			$cekToken	= $this->db->get_where('token', [
				'token'		=> $tkn,
				'id_user'	=> $uid
			], 1)->row_array();
			
			if($cekToken == null) {
				return false;
			} else {
				$tokenDate	= strtotime($cekToken['date']);
				$todayDate	= strtotime(date('Y-m-d'));
				
				if($tokenDate != $todayDate) {
					return false;
				} else {
					$user = $this->getById($cekToken['id_user']);
					return $user;
				}
			}
		}
	}
?>