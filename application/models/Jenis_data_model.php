<?php

	class Jenis_data_model extends CI_model {

		public function getAllJenisData($start='', $limit='', $kata_cari='') {
			if($kata_cari) {
				$this->db->like('kode_jenis', $kata_cari)
						->or_like('jenis_data', $kata_cari)
						->or_like('kategori', $kata_cari);
			}
			return $this->db->order_by('kode_jenis', 'ASC')
							->get('jenis_data', $limit, $start)->result_array();
		}

		public function countJenisData($kata_cari='') {
			if($kata_cari) {
				$this->db->like('kode_jenis', $kata_cari)
						->or_like('jenis_data', $kata_cari)
						->or_like('kategori', $kata_cari);
			}
			return $this->db->from('jenis_data')->count_all_results();
		}

		public function getById($kode_jenis) {
			return $this->db->get_where('jenis_data', ['kode_jenis'=>$kode_jenis])->row_array();
		}

		public function getMax($kategori) {
			$q = "SELECT MAX(kode_jenis) as maxId FROM jenis_data WHERE kategori = '$kategori' ";
			$max = $this->db->query($q)->row_array();
			$kodeMax = $max['maxId']; 
			
			// ambil kode angka => substr(dari $kodeMax, index 1, sebanyak 3 char) 
			// jadikan integer => (int) 
			$tambah = (int) substr($kodeMax, 1);
			$tambah++;  //kode lama +1
			$baru = sprintf("%02s", $tambah); 

			$kategori_data	= $this->kategori();
			$id_kategori	= array_search($kategori, $kategori_data);
			
			return $kode_baru = "{$id_kategori}{$baru}";
		}

		public function kategori() {
			return $kategori = [ '1' => 'Data Akuntansi', '2' => 'Data Perpajakan', '3' => 'Data Lainnya'];
		}
		
		public function tambahJenisData() {
			
			$kode_jenis = $this->getMax($this->input->post('kategori', true));
			$data = [
				"kode_jenis"	=> $kode_jenis,
				"jenis_data"	=> $this->input->post('jenis_data', true),
				"kategori"		=> $this->input->post('kategori', true),
			];
			$this->db->insert('jenis_data', $data);
		}

		public function ubahJenisData() {
			
			$data = [
				"kode_jenis"	=> $this->input->post('kode_jenis', true),
				"jenis_data"	=> $this->input->post('jenis_data', true),
				"kategori"		=> $this->input->post('kategori', true),
			];
			$this->db->where('kode_jenis', $this->input->post('kode_jenis', true));
			$this->db->update('jenis_data', $data);
		}
		
		public function hapusJenisData($kode_jenis) {
			
			$this->db->where('kode_jenis', $kode_jenis);
			$this->db->delete('jenis_data');
		}
	}
?>