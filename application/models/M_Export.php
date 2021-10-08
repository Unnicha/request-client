<?php
	
	use GuzzleHttp\Client;
	
	class M_Export extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getPermintaan($tahun, $bulan, $klien, $kategori) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'all',
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
				'kategori'	=> $kategori,
			];
			$response	= $this->client->request('GET', 'export_permintaan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countPermintaan($tahun, $bulan, $klien, $kategori) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'count',
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
				'kategori'	=> $kategori,
			];
			$response	= $this->client->request('GET', 'export_permintaan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function maxPengiriman($id_data, $kategori) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'lastSend',
				'id_data'	=> $id_data,
				'kategori'	=> $kategori,
			];
			$response	= $this->client->request('GET', 'export_permintaan', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getProses($tahun, $bulan, $klien, $kategori) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'all',
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
				'kategori'	=> $kategori,
			];
			$response	= $this->client->request('GET', 'export_proses', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countProses($tahun, $bulan, $klien, $kategori) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'count',
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
				'kategori'	=> $kategori,
			];
			$response	= $this->client->request('GET', 'export_proses', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function detailProses($id_data, $kategori) {
			$get = [
				'REQUEST'	=> Globals::apikey(),
				'type'		=> 'detail',
				'id_data'	=> $id_data,
				'kategori'	=> $kategori,
			];
			$response	= $this->client->request('GET', 'export_proses', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
	}
?>