<?php
	
	use GuzzleHttp\Client;
	use GuzzleHttp\Psr7;

	class M_Pengiriman_lainnya extends CI_model {
		private $client;
		
		public function __construct() {
			$this->client = new Client([
				'base_uri'	=> REST_SERVER . 'api/',
				'time_out'	=> 10,
			]);
		}
		
		public function getByMasa($bulan, $tahun, $klien='', $start=0, $limit='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'all',
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
				'offset'	=> $start,
				'limit'		=> $limit,
			];
			$response	= $this->client->request('GET', 'pengiriman_data_lainnya', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function countPengiriman($bulan, $tahun, $klien='') {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'countAll',
				'bulan'		=> $bulan,
				'tahun'		=> $tahun,
				'klien'		=> $klien,
			];
			$response	= $this->client->request('GET', 'pengiriman_data_lainnya', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getById($id_data) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'byId',
				'key'		=> $id_data,
			];
			$response	= $this->client->request('GET', 'pengiriman_data_lainnya', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function getDetail($id_data) {
			$get = [
				'REQUEST'	=> APIKEY,
				'type'		=> 'detail',
				'key'		=> $id_data,
			];
			$response	= $this->client->request('GET', 'pengiriman_data_lainnya', ['query' => $get]);
			$result		= json_decode($response->getBody()->getContents(), true);
			return $result['data'];
		}
		
		public function kirim() {
			$id_data		= $this->input->post('id_data', true);
			$format_data	= $this->input->post('format_data', true);
			$keterangan		= $this->input->post('keterangan', true);
			$exts			= ['xls', 'xlsx', 'csv', 'pdf', 'rar', 'zip'];
			
			if($format_data == 'Softcopy') {
				$fileName = $_FILES['files']['name'];
				$filePath = $_FILES['files']['tmp_name'];
				if($fileName == null) {
					$callback	= false;
				} else {
					$targetFile	= basename($fileName);
					$fileExt	= strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
					if(in_array($fileExt, $exts) == false) {
						$callback = false;
					} else {
						$upload	= $fileName;
					}
				}
			} elseif($format_data == 'Hardcopy') {
				$upload = $this->input->post('tanggal_ambil', true);
			}
			
			if(isset($callback)) {
				return $callback;
			} else {
				if($format_data == 'Hardcopy') {
					$row = [
						'REQUEST'		=> APIKEY,
						'format_data'	=> $format_data,
						'file'			=> $upload,
						'keterangan'	=> $keterangan,
						'kode_data'		=> $id_data,
					];
					$response	= $this->client->request('POST', 'pengiriman_data_lainnya', ['form_params' => $row]);
					$result		= json_decode($response->getBody()->getContents(), true);
					return $result['data'];
				} else {
					$row = [
						'headers'	=> [
							'REQUEST'		=> APIKEY,
						],
						'multipart' => [
							[
								'name'		=> 'file_data',
								'filename'	=> $targetFile,
								'contents'	=> file_get_contents($filePath),
							],
							[
								'name'		=> 'file_info',
								'contents'	=> json_encode([
									'klien'			=> $this->session->userdata('id_user'),
									'keterangan'	=> $keterangan,
									'kode_data'		=> $id_data,
								]),
							],
						]
					];
					$response	= $this->client->request('POST', 'pengiriman_data_lainnya', $row);
					$result		= json_decode($response->getBody()->getContents(), true);
					return $result['status'];
				}
			}
		}
		
		public function download($klien, $year, $fileName) {
			$this->client = new Client([
				'base_uri' => REST_SERVER,
			]);
			$fileDir	= 'asset/uploads/'.$klien.'/'.$year.'/'.$fileName;
			$tempDir	= 'asset/download/';
			
			if (!is_dir($tempDir)) {
				mkdir($tempDir, 0777, $rekursif = true);
			}
			$resource	= fopen($tempDir.$fileName, 'w+');
			$response	= $this->client->request('GET', $fileDir, ['sink' => $resource]);
			$result = json_decode($response->getBody()->getContents(), true);
			return $result;
		}
		
		public function konfirmasi($id_data, $status) {
			$this->db->update('data_lainnya', ['status_kirim'=>$status], ['id_data'=>$id_data]);
		}
		
		public function hapusPengiriman($kode_data) {
			$this->db->where('kode_data', $kode_data);
			$this->db->delete('pengiriman_lainnya');
		}
	}
?>