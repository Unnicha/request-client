<?php
	
	use GuzzleHttp\Client;
	
	class Akses_model extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getByTahun($start=0, $limit='', $tahun='') {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'all',
				'tahun'		=> $tahun,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'akses', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countAkses($tahun) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'count',
				'tahun'		=> $tahun,
			];
			$response	= $this->client->request('GET', 'akses', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($id_akses) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'byId',
				'id'		=> $id_akses,
			];
			$response	= $this->client->request('GET', 'akses', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getByKlien($tahun, $id_klien) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'byKlien',
				'id'		=> $id_klien,
				'tahun'		=> $tahun,
			];
			$response	= $this->client->request('GET', 'akses', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getByAkuntan($tahun, $bulan, $id_akuntan, $kategori) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'byAkuntan',
				'id'		=> $id_akuntan,
				'tahun'		=> $tahun,
				'bulan'		=> $bulan,
				'kategori'	=> $kategori,
			];
			$response	= $this->client->request('GET', 'akses', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function tambahAkses() {
			$row	= [
				'REQUEST'		=> Globals::apikey(),
				'kode_klien'	=> $this->input->post('id_klien', true),
				'masa'			=> $this->input->post('masa', true),
				'tahun'			=> $this->input->post('tahun', true),
				'akuntansi'		=> implode(',', $this->input->post('akuntansi', true)),
				'perpajakan'	=> implode(',', $this->input->post('perpajakan', true)),
				'lainnya'		=> implode(',', $this->input->post('lainnya', true)),
			];
			$response	= $this->client->request('POST', 'akses', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result;
		}
	
		public function ubahAkses() {
			$row = [
				'REQUEST'		=> Globals::apikey(),
				'id_akses'		=> $this->input->post('id_akses', true),
				'kode_klien'	=> $this->input->post('id_klien', true),
				'masa'			=> $this->input->post('masa', true),
				'tahun'			=> $this->input->post('tahun', true),
				'akuntansi'		=> implode(',', $this->input->post('akuntansi', true)),
				'perpajakan'	=> implode(',', $this->input->post('perpajakan', true)),
				'lainnya'		=> implode(',', $this->input->post('lainnya', true)),
			];
			$response	= $this->client->request('PUT', 'akses', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result;
		}
		
		public function hapusAkses($id_akses) {
			$row = [
				'REQUEST'	=> Globals::apikey(),
				'id_akses'	=> $id_akses,
			];
			$response	= $this->client->request('DELETE', 'akses', ['form_params' => $row]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result;
		}
	}
?>